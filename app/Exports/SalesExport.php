<?php

namespace App\Exports;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;


class SalesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public $start_date,$end_date;

    public function __construct($start_date,$end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return [
            'Date de creation',
            'Heure de creation',
            'Equipe',
            'Adresse',
            'SIP',
            'ID',
            'Routeur',
            'Zone',
            'Nom Client',
            'Telephone',
            'Debit',
            'Etat',
            'Satut d\'affectation'
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
        return 'Clients';
    }

    public function collection()
    {
        return Client::select(DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y %H:%i")'),DB::raw('DATE_FORMAT(clients.created_at, "%H:%i")'),'soustraitants.name as soustraitant_name','address','sip','clients.client_id','routeur_type as routeur','cities.name as city_name','clients.name','clients.phone_no as phoneNumber','clients.debit','clients.status as client_status','affectations.status as affectation_status')
            ->join('cities', 'cities.id', '=', 'clients.city_id')
             ->leftJoin('affectations', function ($join) {
                $join->on('clients.id', '=', 'affectations.client_id')
                    ->whereNull('affectations.deleted_at');
            })
            ->leftJoin('techniciens', 'clients.technicien_id', '=', 'techniciens.id')
            ->leftJoin('soustraitants', 'techniciens.soustraitant_id', '=', 'soustraitants.id')
            ->where('clients.deleted_at', null)
            ->when($this->start_date && $this->end_date, function ($query) {
                return $query->whereBetween('clients.created_at', [Carbon::parse($this->start_date)->startOfDay(), Carbon::parse($this->end_date)->endOfDay() ]);
            })
            ->orderBy('clients.created_at', 'DESC')
            ->groupBy('clients.sip')
            ->get();
    }
}
