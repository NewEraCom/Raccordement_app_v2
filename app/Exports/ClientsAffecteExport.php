<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;


class ClientsAffecteExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public $date, $technicien;

    public function __construct($date, $technicien)
    {
        $this->date = $date;
        $this->technicien = $technicien;
    }

    public function headings(): array
    {
        return [
            'Compte SIP',
            'Login internet',
            'Nom de client',
            'Adresse',
            'Ville',
            'Numéro de téléphone',
            'Type',
            'Débit',
            'Technicien',
            'Status d\'affectation',
            'Date de planification',
            'Date d\'affectation',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:L1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:L1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:L1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:L' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:L' . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:L' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:L' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:L' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }

    public function title(): string
    {
        return 'Clients Affectés';
    }

    public function collection()
    {
        return Client::select('sip', 'clients.client_id', 'clients.name', 'address', 'cities.name as city_name', 'clients.phone_no', 'type', 'debit', DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'affectations.status', DB::raw('DATE_FORMAT(affectations.planification_date, "%d-%m-%Y %H:%i")'),'affectations.status', DB::raw('DATE_FORMAT(affectations.created_at, "%d-%m-%Y %H:%i")'))
            ->join('cities', 'cities.id', '=', 'clients.city_id')
            ->join('affectations', 'affectations.client_id', '=', 'clients.id')
            ->join('techniciens', 'techniciens.id', '=', 'affectations.technicien_id')
            ->join('users', 'users.id', '=', 'techniciens.user_id')
            ->when(empty($this->date), function ($query) {
                return $query->whereBetween('clients.created_at', $this->date);
            })
            ->get();
    }
}
