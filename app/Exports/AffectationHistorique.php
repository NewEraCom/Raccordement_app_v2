<?php

namespace App\Exports;

use App\Models\Affectation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class AffectationHistorique implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    protected $start_date, $end_date, $technicien;

    public function __construct($technicien, $start_date, $end_date)
    {
        $this->technicien = $technicien;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return [
           'Sip',
           'Soustraitant',
           'Technicien',
           'Date',
           'Status',
           'Cause'
        ];
    }


    
public function collection()
{
    return DB::table('affectation_histories as ah')
        ->select([
            'c.sip',
            's.name as soustraitant',
            DB::raw("CONCAT(u.first_name, ' ', u.last_name) as technicien"),
            DB::raw('DATE_FORMAT(ah.created_at, "%d-%m-%Y %H:%i") as date'),
            'ah.status',
            'b.cause'
        ])
        ->join('affectations as a', 'a.id', '=', 'ah.affectation_id')
        ->join('clients as c', 'c.id', '=', 'a.client_id')
        ->leftJoin('techniciens as t', 't.id', '=', 'ah.technicien_id')
        ->leftJoin('users as u', 'u.id', '=', 't.user_id')
        ->leftJoin('soustraitants as s', 's.id', '=', 'ah.soustraitant_id')
        ->leftJoin('blocages as b', function($join) {
            $join->on('b.affectation_id', '=', 'ah.affectation_id')
                ->where('ah.status', '=', 'Bloqué');
        })
        ->when($this->start_date && $this->end_date, function ($query) {
            return $query->whereBetween('ah.created_at', [
                Carbon::parse($this->start_date)->startOfDay(),
                Carbon::parse($this->end_date)->endOfDay()
            ]);
        })
        ->when($this->technicien, function ($query, $technicien) {
            return $query->where('t.id', $technicien);
        })
        ->whereNull('a.deleted_at')
        ->whereNull('c.deleted_at')
        ->orderBy('c.sip')
        ->orderBy('ah.created_at', 'asc')
        ->get();
}

public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $lastRow = $event->sheet->getHighestRow();
            
            // Style pour l'en-tête (première ligne)
            $event->sheet->getStyle('A1:F1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFF'],
                    'size' => 10,
                    'name' => 'Calibri'
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '002060']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                ]
            ]);

            // Style pour toutes les cellules
            $event->sheet->getStyle('A1:F' . $lastRow)->applyFromArray([
                'font' => [
                    'size' => 10,
                    'name' => 'Calibri'
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ]
            ]);

            // Ajuster automatiquement la largeur des colonnes
            foreach (range('A', 'F') as $column) {
                $event->sheet->getColumnDimension($column)->setAutoSize(true);
            }
        },
    ];
}


    public function title(): string
    {
        return 'Affectations Historique ' . date('d-m-Y');
    }
}
