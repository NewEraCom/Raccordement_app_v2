<?php

namespace App\Exports;

use App\Models\SavClient;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;


class SavClientExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public function headings(): array
    {
        return [
            'N° case',
            'SIP',
            'Adresse',
            'Nom du client',
            'Ville',
            'Contact',
            'Date demande',
            'Date d\'intervention',
            'Root Cause',
            'Equipe',

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:T1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:T1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:T1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:T' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:T' . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:T' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:T' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:T' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }

    public function collection()
    {
        $data = SavClient::select('n_case', 'login', 'address', 'client_name', 'cities.name as ville', 'contact', 'date_demande',)
            ->join('cities', 'sav_client.city_id', '=', 'cities.id')
            ->orderBy('date_demande', 'desc')
            ->get();
      
        return $data;
    }

    public function title(): string
    {
        return 'Suivi_' . date('d-m-Y');
    }
}
