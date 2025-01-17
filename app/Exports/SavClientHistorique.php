<?php

namespace App\Exports;

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

class SavClientHistorique implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    protected $start_date, $end_date, $technicien;

    public function __construct($technicien = null, $start_date = null, $end_date = null)
    {
        $this->technicien = $technicien;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return [
            'N° Case',
            'Soustraitant',
            'Technicien',
            'Date',
            'Status',
            'Root Cause',
            'Cause',
        ];
    }
    
    public function collection()
    {
        return DB::table('savhistories AS sh')
            ->select([
                'sc.n_case AS N° Case',
                's.name AS Soustraitant',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) AS Technicien"),
                DB::raw('DATE_FORMAT(sh.created_at, "%d-%m-%Y %H:%i") AS Date'),
                'sh.status AS Status',
                DB::raw("
                    CASE 
                        WHEN sh.status = 'Bloqué' THEN b.cause 
                        WHEN sh.status = 'Validé' THEN fb.root_cause 
                        ELSE NULL 
                    END AS Cause
                "),
            ])
            ->join('sav_tickets AS st', 'st.id', '=', 'sh.savticket_id')
            ->join('sav_client AS sc', 'sc.id', '=', 'st.client_id')
            ->leftJoin('techniciens AS t', 't.id', '=', 'sh.technicien_id')
            ->leftJoin('users AS u', 'u.id', '=', 't.user_id')
            ->leftJoin('soustraitants AS s', 's.id', '=', 'sh.soustraitant_id')
            ->leftJoin('blocage_savs AS b', 'b.sav_ticket_id', '=', 'sh.savticket_id')
            ->leftJoin('feed_back_savs AS fb', 'fb.sav_ticket_id', '=', 'sh.savticket_id')
            ->orderBy('sc.n_case')
            ->orderBy('sh.created_at', 'asc')
            ->get();
    }
    
    
    
    
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Get the last column based on the headings count
                $lastColumn = $event->sheet->getHighestColumn();
    
                // Style header row (first row)
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFF'], // White font color
                        'size' => 12, // Slightly larger font size for the header
                        'name' => 'Calibri',
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => '002060'], // Dark blue background color
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FFFFFF'], // White border for the header
                        ],
                    ],
                ]);
    
                // Adjust column widths automatically for better visibility
                foreach (range('A', $lastColumn) as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
    

    public function title(): string
    {
        return 'SAV Histories ' . date('d-m-Y');
    }
}
