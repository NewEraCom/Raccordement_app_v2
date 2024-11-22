<?php

namespace App\Exports;

use App\Models\Plaque;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PlaqueExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function collection()
    {
        return Plaque::select('cities.name as city_name', 'code_plaque')
            ->join('cities', 'cities.id', '=', 'plaques.city_id')
            ->where('plaques.deleted_at', null)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ville', 'plaque',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();

                $event->sheet->getStyle('A1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:B1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:B1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:B1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:B' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:B' . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:B' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:B' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:B' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}
