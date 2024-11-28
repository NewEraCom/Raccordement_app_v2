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
            // Première affectation (Backoffice -> Soustraitant)
            'Affectation 1 - Date',
            'Affectation 1 - Status',
            'Affectation 1 - Soustraitant',
            // Deuxième affectation (Soustraitant -> Technicien)
            'Affectation 2 - Date',
            'Affectation 2 - Status',
            'Affectation 2 - Technicien',
            'Affectation 2 - Soustraitant',
            // Troisième affectation (Feedback Technicien)
            'Feedback 3 - Date',
            'Feedback 3 - Status',
            'Feedback 3 - Cause',
            'Affectation 3 - Technicien',
            'Affectation 3 - Soustraitant',
            // Quatrième affectation (Si reaffectation nécessaire)
            'Feedback 4 - Date',
            'Feedback 4 - Status',
            'Feedback 4 - Cause',
            'Affectation 4 - Soustraitant',
            'Affectation 4 - Technicien',
            // Cinquième affectation
            'Feedback 5 - Date',
            'Feedback 5 - Status',
            'Feedback 5 - Cause',
            'Affectation 5 - Soustraitant',
            'Affectation 5 - Technicien',
            // Sixième affectation
            'Feedback 6 - Date',
            'Feedback 6 - Status',
            'Feedback 6 - Cause',
            'Affectation 6 - Soustraitant',
            'Affectation 6 - Technicien',
        ];
    }

    public function collection()
    {   
        return Client::select([
            DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y %H:%i") as created_at'),
            'st_initial.name as soustraitant_name',
            'clients.address',
            'clients.type',
            'clients.sip',
            'clients.client_id',
            'clients.routeur_type as routeur',
            'cities.name as city_name',
            'clients.name',
            'clients.phone_no as phoneNumber',
            'clients.debit',
            'clients.status as client_status',
            // Affectation 1
            DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y %H:%i") END) as affectation1_date'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.status END) as affectation1_status'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN st_aff1.name END) as affectation1_soustraitant'),
            // Affectation 2
            DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y %H:%i") END) as affectation2_date'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN affectation_histories.status END) as affectation2_status'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN CONCAT(users_aff2.first_name, " ", users_aff2.last_name) END) as affectation2_technicien'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN st_aff2.name END) as affectation2_soustraitant'),
            // Affectation 3 (Feedback Technicien)
            DB::raw('MAX(CASE WHEN hist_rank.rank = 3 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y %H:%i") END) as affectation3_date'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 3 THEN affectation_histories.status END) as affectation3_status'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 3 THEN affectation_histories.cause END) as affectation3_cause'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 3 THEN CONCAT(users3.first_name, " ", users3.last_name) END) as affectation3_technicien'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 3 THEN st3.name END) as affectation3_soustraitant'),
            // Affectation 4
            DB::raw('MAX(CASE WHEN hist_rank.rank = 4 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y %H:%i") END) as affectation4_date'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 4 THEN affectation_histories.status END) as affectation4_status'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 4 THEN affectation_histories.cause END) as affectation4_cause'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 4 THEN st4.name END) as affectation4_soustraitant'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 4 THEN CONCAT(users4.first_name, " ", users4.last_name) END) as affectation4_technicien'),
            // Affectation 5
            DB::raw('MAX(CASE WHEN hist_rank.rank = 5 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y %H:%i") END) as affectation5_date'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 5 THEN affectation_histories.status END) as affectation5_status'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 5 THEN affectation_histories.cause END) as affectation5_cause'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 5 THEN st5.name END) as affectation5_soustraitant'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 5 THEN CONCAT(users5.first_name, " ", users5.last_name) END) as affectation5_technicien'),
            // Affectation 6
            DB::raw('MAX(CASE WHEN hist_rank.rank = 6 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y %H:%i") END) as affectation6_date'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 6 THEN affectation_histories.status END) as affectation6_status'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 6 THEN affectation_histories.cause END) as affectation6_cause'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 6 THEN st6.name END) as affectation6_soustraitant'),
            DB::raw('MAX(CASE WHEN hist_rank.rank = 6 THEN CONCAT(users6.first_name, " ", users6.last_name) END) as affectation6_technicien')
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
        ->leftJoin('soustraitants as st3', function($join) {
            $join->on('affectation_histories.soustraitant_id', '=', 'st3.id')
                ->whereRaw('hist_rank.rank = 3');
        })
        ->leftJoin('soustraitants as st4', function($join) {
            $join->on('affectation_histories.soustraitant_id', '=', 'st4.id')
                ->whereRaw('hist_rank.rank = 4');
        })
        ->leftJoin('soustraitants as st5', function($join) {
            $join->on('affectation_histories.soustraitant_id', '=', 'st5.id')
                ->whereRaw('hist_rank.rank = 5');
        })
        ->leftJoin('techniciens as tech3', function($join) {
            $join->on('affectation_histories.technicien_id', '=', 'tech3.id')
                ->whereRaw('hist_rank.rank = 3');
        })
        ->leftJoin('users as users3', 'tech3.user_id', '=', 'users3.id')
        ->leftJoin('techniciens as tech4', function($join) {
            $join->on('affectation_histories.technicien_id', '=', 'tech4.id')
                ->whereRaw('hist_rank.rank = 4');
        })
        ->leftJoin('users as users4', 'tech4.user_id', '=', 'users4.id')
        ->leftJoin('techniciens as tech5', function($join) {
            $join->on('affectation_histories.technicien_id', '=', 'tech5.id')
                ->whereRaw('hist_rank.rank = 5');
        })
        ->leftJoin('users as users5', 'tech5.user_id', '=', 'users5.id')
        ->leftJoin('soustraitants as st6', function($join) {
            $join->on('affectation_histories.soustraitant_id', '=', 'st6.id')
                ->whereRaw('hist_rank.rank = 6');
        })
        ->leftJoin('techniciens as tech6', function($join) {
            $join->on('affectation_histories.technicien_id', '=', 'tech6.id')
                ->whereRaw('hist_rank.rank = 6');
        })
        ->leftJoin('users as users6', 'tech6.user_id', '=', 'users6.id')
        ->where('clients.deleted_at', null)
        ->when($this->start_date && $this->end_date, function ($query) {
            return $query->whereBetween('clients.created_at', [
                Carbon::parse($this->start_date)->startOfDay(), 
                Carbon::parse($this->end_date)->endOfDay()
            ]);
        })
        ->whereNull('clients.statusSav')
        ->orderBy('clients.created_at', 'DESC')
        ->groupBy([
            'clients.id',
            'clients.created_at',
            'st_initial.name',
            'clients.address',
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
                $lastColumn = 'AO'; // 36 colonnes + 6 nouvelles colonnes

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
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->getColor()
                    ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFill()->getStartColor()
                    ->setARGB('002060');

                // Style pour toutes les cellules
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getBorders()
                    ->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Ajustement automatique de la largeur des colonnes
                for ($i = 1; $i <= 36; $i++) {
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
