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


class ClientsRestantExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Compte SIP',
            'Login internet',
            'Nom de client',
            'Adresse',
            'Ville',
            'Numéro de téléphone',
            'Routeur',
            'Type',
            'Débit',
            'Date de creation',
            'Heure de creation',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $lastColumn = $event->sheet->getHighestColumn(); // Get the last column dynamically
    
                // Apply style to all headers (from A1 to the last column header)
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFill()->getStartColor()->setARGB('002060');
    
                // Apply other styles to the entire sheet (data and headers)
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
    

    public function title(): string
    {
        return 'Clients Restant';
    }

    public function collection()
    {
        return Client::select('sip','client_id','clients.name','address','cities.name as city_name','clients.phone_no','routeur_type','type','debit',DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y ")'),DB::raw('DATE_FORMAT(clients.created_at, "%H:%i") as creation_time'),)
        ->join('cities','cities.id','=','clients.city_id')
        ->where([['clients.status','Saisie'],['clients.statusSav',null]])
        ->get();
    }
}

