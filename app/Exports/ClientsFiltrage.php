<?php

namespace App\Exports;

use App\Models\Client;
use App\Services\web\ClientsService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;


class ClientsFiltrage implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
{
    use Exportable;

    protected $client_name, $client_sip, $client_status, $technicien, $start_date, $end_date;

    public function headings() : array
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
            'Date de creation',
        ];
    }

    public function __construct($client_name, $client_sip, $client_status, $technicien, $start_date, $end_date)
    {
        $this->client_name = $client_name;
        $this->client_sip = $client_sip;
        $this->client_status = $client_status;
        $this->technicien = $technicien;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

      public function collection()
    {
        return Client::select('sip','client_id','clients.name','address','cities.name as city_name','phone_no','type','debit','clients.created_at')->join('cities','cities.id','=','clients.city_id')
        ->orderBy('clients.created_at','desc')
        ->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();

                $event->sheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:I1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('002060');

                $event->sheet->getStyle('A1:I'.$lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:I'.$lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:I'.$lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:I'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:I'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
    
}
