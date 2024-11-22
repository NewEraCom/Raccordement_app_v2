<?php

namespace App\Exports;

use App\Models\SavTicket;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class SavTicketExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    public $technicien;
    
    public $start_date,$end_date;

    public function headings(): array
    {
        return [
            'SIP',
            'Id Case',
            'Adresse',
            'Numéro de téléphone',
            'Technicien',

            'Nom de client',
            'Soustraitant',
        ];
    }
    public function collection()
    {
        return SavTicket::select('clients.sip','id_case','clients.address','clients.phone_no','clients.name', DB::raw("CONCAT(users.first_name,' ',users.last_name)"),'soustraitants.name as soustraitant')

        ->join('clients', 'clients.id', '=', 'sav_tickets.client_id')
        ->leftJoin('techniciens', 'techniciens.id', '=', 'sav_tickets.technicien_id')
        ->leftJoin('users', 'users.id', '=', 'techniciens.user_id')
        ->leftJoin('soustraitants', 'soustraitants.id', '=', 'sav_tickets.soustraitant_id')
        ->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:G1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:G' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:G' . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:G' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:G' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:G' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}
