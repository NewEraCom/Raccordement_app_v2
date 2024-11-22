<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
 

class ControllerQualiteExport implements FromCollection,WithHeadings,ShouldAutoSize,WithTitle,WithEvents
{
    use Exportable;

    protected $start_date,$end_date;

    public function __construct($start_date,$end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return [
            'Adresse',
            'SIP',
            'ID',
            'Nom Client',
            'Telephone',
            'Date de traitemant',
            'Status de client',
            'Etat',
            'Commentaire',
            'Retour BO',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:J1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:J1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('a57a00');
                $event->sheet->getStyle('A1:J' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:J' . $lastRow)->getFont()->setSize(12);
                $event->sheet->getStyle('A1:J' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:J' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:J' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }

    public function title(): string
    {
        return 'ToExcel';
    }


    public function collection(){
        return Client::select('address','sip','clients.client_id','name','phone_no',DB::raw('DATE_FORMAT(controler_clients.created_at, "%d-%m-%Y")'),'affectations.status','comment','controler_clients.note','blocages.cause')
        ->leftJoin('controler_clients', 'controler_clients.id', '=', 'clients.controler_client_id')
        ->leftJoin('affectations','affectations.client_id','=','clients.id')
        ->leftJoin('blocages','blocages.affectation_id','=','affectations.id')
        ->groupBy('clients.sip')
        ->where('flagged',true)->get();
    }
}
