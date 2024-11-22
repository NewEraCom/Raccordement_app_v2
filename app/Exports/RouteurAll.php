<?php

namespace App\Exports;

use App\Models\Routeur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RouteurAll implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Routeur',
            'GPON',
            'MAC',
            'SIP',
            'Client',
            'Technicien',
            'Status',
            'Date de creation',
        ];
    }

    public function collection()
    {
        return Routeur::select('clients.routeur_type', 'routeurs.sn_gpon', 'routeurs.sn_mac', 'clients.sip', 'clients.name', DB::raw("CONCAT(users.first_name,' ',users.last_name)"), DB::raw('CASE routeurs.status 
                  WHEN 0 THEN "Inactif" 
                  WHEN 2 THEN "Besoin de vérification" 
                  WHEN 1 THEN "Actif" 
                  ELSE "unknown" 
                END AS status_text'), DB::raw('DATE_FORMAT(routeurs.created_at, "%d-%m-%Y %H:%i")'))
            ->leftJoin('clients', 'clients.id', '=', 'routeurs.client_id')
            ->leftJoin('techniciens', 'techniciens.id', '=', 'routeurs.technicien_id')
            ->leftJoin('users', 'users.id', '=', 'techniciens.user_id')
            -> where('routeurs.deleted_at', null)->get();
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:H1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:H1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:H' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:H' . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:H' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:H' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:H' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }


    public function title(): string
    {
        return 'Toutes les routeurs ' . date('d-m-Y');
    }
}
