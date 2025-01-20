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

    protected $startDate;
    protected $endDate;


    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    

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
          //  'Equipe',
           // 'Date d\'intervention',
            //'Root Cause',
            'Statut',
            

        ];
    }

 
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Get the last column dynamically based on the headings count
                $lastColumn = chr(64 + count($this->headings())); // Convert number to column letter (A, B, ..., G)
    
                // Style the header row
                $event->sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE], // White font color
                        'size' => 12,
                        'name' => 'Calibri',
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => '002060'], // Dark blue background
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
    

    public function collection()
    {
        // Start building the query
        $query = SavClient::select(
            'n_case',
            'login',
            'address',
            'client_name',
            'cities.name as ville',
            'contact',
            'date_demande',
            'sav_client.status' // Include the status column
        )
        ->join('cities', 'sav_client.city_id', '=', 'cities.id');

        // Apply date filtering if dates are provided
        if ($this->startDate) {
            $query->where('date_demande', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->where('date_demande', '<=', $this->endDate);
        }

        // Order by date and fetch results
        return $query->orderBy('date_demande', 'desc')->get();
    }

    public function title(): string
    {
        return 'Suivi_' . date('d-m-Y');
    }
}
