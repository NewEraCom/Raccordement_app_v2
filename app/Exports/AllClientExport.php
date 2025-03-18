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


class AllClientExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public $start_date,$end_date,$plaque_id,$city_id;

    public function __construct($start_date,$end_date,$plaque_id,$city_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->plaque_id = $plaque_id;
        $this->city_id = $city_id;
    }
/*
    public function headings(): array
    {
        return [
            'Date de creation',
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
        ];
    }
        public function collection()
    {
        return Client::select(DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y %H:%i")'),'soustraitants.name as soustraitant_name','address','sip','clients.client_id','routeur_type as routeur','cities.name as city_name','clients.name','clients.phone_no as phoneNumber','clients.debit','clients.status as client_status')
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
            ->whereNull('clients.statusSav')
            ->orderBy('clients.created_at', 'DESC')
            ->groupBy('clients.sip')
            ->get();
    }
     public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:K1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:K1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:K' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:K' . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:K' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:K' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:K' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
*/
   public function headings(): array
    {
        return [
            'Date de creation',
            'Heure de creation',
            'Equipe',
            'Adresse',
            'Type de demande',
            'SIP',
            'ID',
            'Routeur',
            'Zone',
            'Nom Client',
            'Telephone',
            'Debit',
            'Etat Actuel',
            'Temps de traitement (Jours)',
            'Affectation 1 - Date',
            'Affectation 1 - Heure',
            'Affectation 1 - Status',
            'Affectation 1 - Soustraitant',
            'Affectation 2 - Date',
            'Affectation 2 - Heure',
            'Affectation 2 - Status',
            'Affectation 2 - Technicien',

  
        ];
    }
    
    public function collection()
    {   
        return Client::select([
         
            DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y") as creation_date'),
            DB::raw('DATE_FORMAT(clients.created_at, "%H:%i") as creation_time'),  
            'st_initial.name as equipe',
            'clients.address',
            'clients.type',
            'clients.sip',
            'clients.client_id as ID',
            'clients.routeur_type as routeur',
            'cities.name as zone',
            'clients.name as nom_client',
            'clients.phone_no as telephone',
            'clients.debit',
            'clients.status as etat_actuel',
            DB::raw('CASE 
                WHEN MIN(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.created_at END) IS NOT NULL THEN
                    DATEDIFF(
                        MIN(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.created_at END),
                        clients.created_at
                    )
                ELSE NULL
            END as processing_time'),
    
            // Première affectation (Backoffice -> Soustraitant)
            DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y ") END) as affectation1_date'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%H:%i") END) as affectation1_heure'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.status END) as affectation1_status'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN st_aff1.name END) as affectation1_soustraitant'),
    
            // Deuxième affectation (Soustraitant -> Technicien)
            DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y") END) as affectation2_date'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN DATE_FORMAT(affectation_histories.created_at, " %H:%i") END) as affectation2_heure'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN affectation_histories.status END) as affectation2_status'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN CONCAT(users_aff2.first_name, " ", users_aff2.last_name) END) as affectation2_technicien'),

        ])
        ->join('cities', 'cities.id', '=', 'clients.city_id')
        ->leftJoin('techniciens', 'clients.technicien_id', '=', 'techniciens.id')
        ->leftJoin('soustraitants as st_initial', 'techniciens.soustraitant_id', '=', 'st_initial.id')
        ->leftJoin('affectations', function ($join) {
            $join->on('clients.id', '=', 'affectations.client_id')
                ->whereNull('affectations.deleted_at');
        })
        ->leftJoin(DB::raw('(
            SELECT 
                ah.affectation_id,
                ah.id as history_id,
                a.client_id,
                ROW_NUMBER() OVER (PARTITION BY a.client_id ORDER BY ah.created_at ASC) as rank
            FROM affectation_histories ah
            INNER JOIN affectations a ON a.id = ah.affectation_id
            WHERE a.deleted_at IS NULL
        ) as hist_rank'), function($join) {
            $join->on('affectations.id', '=', 'hist_rank.affectation_id')
                 ->on('clients.id', '=', 'hist_rank.client_id');
        })
        ->leftJoin('affectation_histories', 'hist_rank.history_id', '=', 'affectation_histories.id')
        // Jointures pour Affectation 1
        ->leftJoin('soustraitants as st_aff1', function($join) {
            $join->on('affectation_histories.soustraitant_id', '=', 'st_aff1.id')
                ->whereRaw('hist_rank.rank = 1');
        })
        // Jointures pour Affectation 2
        ->leftJoin('techniciens as tech_aff2', function($join) {
            $join->on('affectation_histories.technicien_id', '=', 'tech_aff2.id')
                ->whereRaw('hist_rank.rank = 2');
        })
        ->leftJoin('users as users_aff2', 'tech_aff2.user_id', '=', 'users_aff2.id')
        ->leftJoin('soustraitants as st_aff2', function($join) {
            $join->on('affectation_histories.soustraitant_id', '=', 'st_aff2.id')
                ->whereRaw('hist_rank.rank = 2');
        })
        ->where('clients.deleted_at', null)
        ->when($this->start_date && $this->end_date, function ($query) {
            return $query->whereBetween('clients.created_at', [
                Carbon::parse($this->start_date)->startOfDay(), 
                Carbon::parse($this->end_date)->endOfDay()
            ]);
        })
        ->when($this->plaque_id, function ($query) {
            return $query->where('clients.plaque_id', $this->plaque_id);
        })
        ->when($this->city_id, function ($query) {
            return $query->where('clients.city_id', $this->city_id);
        })
        ->whereNull('clients.statusSav')
        ->orderBy('clients.created_at', 'DESC')
        ->groupBy([
            'clients.id',
            'clients.created_at',
            'st_initial.name',
            'clients.address',
            'clients.type',
            'clients.sip',
            'clients.client_id',
            'clients.routeur_type',
            'cities.name',
            'clients.name',
            'clients.phone_no',
            'clients.debit',
            'clients.status'
        ])
        ->get();
    }
    
    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $lastRow = $event->sheet->getHighestRow();
            $lastColumn = 'X'; // 24 colonnes (A à X)

            // Fonction helper pour générer les lettres des colonnes
            $getColumnName = function($num) {
                $numeric = $num - 1;
                $letter = '';
                while ($numeric > -1) {
                    $letter = chr(65 + ($numeric % 26)) . $letter;
                    $numeric = floor($numeric / 26) - 1;
                }
                return $letter;
            };

            // Style pour l'en-tête
            $event->sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
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
            $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
                'font' => [
                    'size' => 10,
                    'name' => 'Calibri'
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
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

            // Ajustement automatique de la largeur des colonnes
            for ($i = 1; $i <= 24; $i++) {
                $column = $getColumnName($i);
                $event->sheet->getColumnDimension($column)->setAutoSize(true);
            }
        },
    ];
}
   

    public function title(): string
    {
        return 'ToExcel';
    }


}
