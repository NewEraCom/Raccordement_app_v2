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



//  public function headings(): array
//     {
//         return [
//             'Date et Heure de Création',
//             'Date de création',
//             'Heure de création',
//             'Équipe',
//             'Adresse',
//             'Type de demande',
//             'Offre',
//             'SIP',
//             'ID',
//             'Routeur',
//             'Zone',
//             'Nom Client',
//             'Téléphone',
//             'Débit',
//             'État Actuel',
//             'Délai 1 (Affectation BO - Création)',
//             'Délai 2 (Affectation SST - Affectation BO)',
//             'Délai 3 (1er Feedback - Affectation SST)',
//             'Affectation 1 - Date',
//             'Affectation 1 - Heure',
//             'Affectation 1 - Status',
//             'Affectation 1 - Soustraitant',
//             'Affectation 2 - Date',
//             'Affectation 2 - Heure',
//             'Affectation 2 - Status',
//             'Affectation 2 - Technicien',
//         ];
//     }

    
//     public function collection()
//     {
//         return Client::select([
//             DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y %H:%i") as creation_datetime'),
//             DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y") as creation_date'),
//             DB::raw('DATE_FORMAT(clients.created_at, "%H:%i") as creation_time'),
    
//             'st_initial.name as equipe',
//             'clients.address',
//             'clients.type',
//             'clients.offre',
//             'clients.sip',
//             'clients.client_id as ID',
//             'clients.routeur_type as routeur',
//             'cities.name as zone',
//             'clients.name as nom_client',
//             'clients.phone_no as telephone',
//             'clients.debit',
//             'clients.status as etat_actuel',
    
//             DB::raw('IFNULL((SELECT CONCAT(
//                 DATEDIFF(ah_bo.created_at, clients.created_at), " jours et ",
//                 FLOOR(TIMESTAMPDIFF(HOUR, clients.created_at, ah_bo.created_at) % 24), " heures et ",
//                 FLOOR(TIMESTAMPDIFF(MINUTE, clients.created_at, ah_bo.created_at) % 60), " minutes")
//                 FROM affectation_histories ah_bo 
//                 INNER JOIN affectations a_bo ON a_bo.id = ah_bo.affectation_id 
//                 WHERE a_bo.client_id = clients.id AND ah_bo.status = "Affecté" 
//                 ORDER BY ah_bo.created_at ASC LIMIT 1), NULL) AS delai_1'),
    
//             DB::raw('IFNULL((SELECT CONCAT(
//                 DATEDIFF(ah_sst.created_at, ah_bo.created_at), " jours ",
//                 FLOOR(TIMESTAMPDIFF(HOUR, ah_bo.created_at, ah_sst.created_at) % 24), " heures ",
//                 FLOOR(TIMESTAMPDIFF(MINUTE, ah_bo.created_at, ah_sst.created_at) % 60), " minutes")
//                 FROM affectation_histories ah_sst 
//                 INNER JOIN affectations a_sst ON a_sst.id = ah_sst.affectation_id,
//                 affectation_histories ah_bo 
//                 INNER JOIN affectations a_bo ON a_bo.id = ah_bo.affectation_id 
//                 WHERE a_sst.client_id = clients.id AND ah_sst.status = "En cours" 
//                 AND a_bo.client_id = clients.id AND ah_bo.status = "Affecté" 
//                 ORDER BY ah_sst.created_at ASC LIMIT 1), NULL) AS delai_2'),
    
//             DB::raw('IFNULL((SELECT CONCAT(
//                 DATEDIFF(ah_feedback.created_at, ah_sst.created_at), " jours ",
//                 FLOOR(TIMESTAMPDIFF(HOUR, ah_sst.created_at, ah_feedback.created_at) % 24), " heures ",
//                 FLOOR(TIMESTAMPDIFF(MINUTE, ah_sst.created_at, ah_feedback.created_at) % 60), " minutes")
//                 FROM affectation_histories ah_feedback 
//                 INNER JOIN affectations a_feedback ON a_feedback.id = ah_feedback.affectation_id,
//                 affectation_histories ah_sst 
//                 INNER JOIN affectations a_sst ON a_sst.id = ah_sst.affectation_id 
//                 WHERE a_feedback.client_id = clients.id AND ah_feedback.status IN ("Planifié", "Déclaré", "Bloqué") 
//                 AND a_sst.client_id = clients.id AND ah_sst.status = "En cours" 
//                 ORDER BY ah_feedback.created_at ASC LIMIT 1), NULL) AS delai_3'),
    
//             // Affectation 1 (Backoffice -> Soustraitant)
//             DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y ") END) as affectation1_date'),
//             DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%H:%i") END) as affectation1_heure'),
//             DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.status END) as affectation1_status'),
//             DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN st_aff1.name END) as affectation1_soustraitant'),
    
//             // Affectation 2 (Soustraitant -> Technicien)
//             DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y") END) as affectation2_date'),
//             DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN DATE_FORMAT(affectation_histories.created_at, " %H:%i") END) as affectation2_heure'),
//             DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN affectation_histories.status END) as affectation2_status'),
//             DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN CONCAT(users_aff2.first_name, " ", users_aff2.last_name) END) as affectation2_technicien'),
//         ])
//         ->join('cities', 'cities.id', '=', 'clients.city_id')
//         ->leftJoin('techniciens', 'clients.technicien_id', '=', 'techniciens.id')
//         ->leftJoin('soustraitants as st_initial', 'techniciens.soustraitant_id', '=', 'st_initial.id')
//         ->leftJoin('affectations', function ($join) {
//             $join->on('clients.id', '=', 'affectations.client_id')
//                 ->whereNull('affectations.deleted_at');
//         })
//         ->leftJoin(DB::raw('(
//             SELECT 
//                 ah.affectation_id,
//                 ah.id as history_id,
//                 a.client_id,
//                 ROW_NUMBER() OVER (PARTITION BY a.client_id ORDER BY ah.created_at ASC) as rank
//             FROM affectation_histories ah
//             INNER JOIN affectations a ON a.id = ah.affectation_id
//             WHERE a.deleted_at IS NULL
//         ) as hist_rank'), function($join) {
//             $join->on('affectations.id', '=', 'hist_rank.affectation_id')
//                  ->on('clients.id', '=', 'hist_rank.client_id');
//         })
//         ->leftJoin('affectation_histories', 'hist_rank.history_id', '=', 'affectation_histories.id')
//         // Jointures pour Affectation 1
//         ->leftJoin('soustraitants as st_aff1', function($join) {
//             $join->on('affectation_histories.soustraitant_id', '=', 'st_aff1.id')
//                 ->whereRaw('hist_rank.rank = 1');
//         })
//         // Jointures pour Affectation 2
//         ->leftJoin('techniciens as tech_aff2', function($join) {
//             $join->on('affectation_histories.technicien_id', '=', 'tech_aff2.id')
//                 ->whereRaw('hist_rank.rank = 2');
//         })
//         ->leftJoin('users as users_aff2', 'tech_aff2.user_id', '=', 'users_aff2.id')
//         ->leftJoin('soustraitants as st_aff2', function($join) {
//             $join->on('affectation_histories.soustraitant_id', '=', 'st_aff2.id')
//                 ->whereRaw('hist_rank.rank = 2');
//         })
//         ->where('clients.deleted_at', null)
//         ->when($this->start_date && $this->end_date, function ($query) {
//             return $query->whereBetween('clients.created_at', [
//                 Carbon::parse($this->start_date)->startOfDay(), 
//                 Carbon::parse($this->end_date)->endOfDay()
//             ]);
//         })
//         ->when($this->plaque_id, function ($query) {
//             return $query->where('clients.plaque_id', $this->plaque_id);
//         })
//         ->when($this->city_id, function ($query) {
//             return $query->where('clients.city_id', $this->city_id);
//         })
//         ->whereNull('clients.statusSav')
//         ->orderBy('clients.created_at', 'DESC')
//         ->groupBy([
//             'clients.id',
//             'clients.created_at',
//             'st_initial.name',
//             'clients.address',
//             'clients.type',
//             'clients.sip',
//             'clients.client_id',
//             'clients.routeur_type',
//             'cities.name',
//             'clients.name',
//             'clients.phone_no',
//             'clients.debit',
//             'clients.status'
//         ])
//         ->get();
//     }
    
public function headings(): array
{
    return [
        'Date et Heure de Création',
        'Date de création',
        'Heure de création',
        'Équipe',
        'Adresse',
        'Type de demande',
        'Offre',
        'SIP',
        'ID',
        'Routeur',
        'Zone',
        'Nom Client',
        'Téléphone',
        'Débit',
        'État Actuel',
        'Délai 1 (Affectation BO - Création)',
        'Délai 2 (Affectation SST - Affectation BO)',
        'Retard Délai 2 (30 min max)',
        'Délai 3 (1er Feedback - Affectation SST)',
        'Retard Délai 3 (48h max)',
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
        DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y %H:%i") as creation_datetime'),
        DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y") as creation_date'),
        DB::raw('DATE_FORMAT(clients.created_at, "%H:%i") as creation_time'),
        
        'st_initial.name as equipe',
        'clients.address',
        'clients.type',
        'clients.offre',
        'clients.sip',
        'clients.client_id as ID',
        'clients.routeur_type as routeur',
        'cities.name as zone',
        'clients.name as nom_client',
        'clients.phone_no as telephone',
        'clients.debit',
        'clients.status as etat_actuel',

        // Délai 1: Affectation BO - Création
        DB::raw('IFNULL((SELECT CONCAT(
            DATEDIFF(ah_bo.created_at, clients.created_at), " jours et ",
            FLOOR(TIMESTAMPDIFF(HOUR, clients.created_at, ah_bo.created_at) % 24), " heures et ",
            FLOOR(TIMESTAMPDIFF(MINUTE, clients.created_at, ah_bo.created_at) % 60), " minutes")
            FROM affectation_histories ah_bo 
            INNER JOIN affectations a_bo ON a_bo.id = ah_bo.affectation_id 
            WHERE a_bo.client_id = clients.id AND ah_bo.status = "Affecté" 
            ORDER BY ah_bo.created_at ASC LIMIT 1), NULL) AS delai_1'),

        // Délai 2: Affectation SST - Affectation BO (30 min max from creation)
        DB::raw('IFNULL((SELECT CONCAT(
            DATEDIFF(ah_sst.created_at, clients.created_at), " jours ",
            FLOOR(TIMESTAMPDIFF(HOUR, clients.created_at, ah_sst.created_at) % 24), " heures ",
            FLOOR(TIMESTAMPDIFF(MINUTE, clients.created_at, ah_sst.created_at) % 60), " minutes")
            FROM affectation_histories ah_sst 
            INNER JOIN affectations a_sst ON a_sst.id = ah_sst.affectation_id
            WHERE a_sst.client_id = clients.id AND ah_sst.status = "En cours" 
            ORDER BY ah_sst.created_at ASC LIMIT 1), NULL) AS delai_2'),

        // Retard Délai 2 (30 min max from creation)
        DB::raw('IFNULL((SELECT 
            CASE 
                WHEN TIMESTAMPDIFF(MINUTE, clients.created_at, ah_sst.created_at) > 30 
                THEN CONCAT(
                    TIMESTAMPDIFF(MINUTE, clients.created_at, ah_sst.created_at) - 30, " minutes"
                )
                ELSE "À temps"
            END
            FROM affectation_histories ah_sst 
            INNER JOIN affectations a_sst ON a_sst.id = ah_sst.affectation_id
            WHERE a_sst.client_id = clients.id AND ah_sst.status = "En cours" 
            ORDER BY ah_sst.created_at ASC LIMIT 1), "Non affecté") AS retard_delai_2'),

         // Délai 3: 1er Feedback - Affectation SST (48h max from SST assignment)
         DB::raw('IFNULL((SELECT CONCAT(
            DATEDIFF(ah_feedback.created_at, ah_sst.created_at), " jours ",
            FLOOR(TIMESTAMPDIFF(HOUR, ah_sst.created_at, ah_feedback.created_at) % 24), " heures ",
            FLOOR(TIMESTAMPDIFF(MINUTE, ah_sst.created_at, ah_feedback.created_at) % 60), " minutes")
            FROM affectation_histories ah_feedback 
            INNER JOIN affectations a_feedback ON a_feedback.id = ah_feedback.affectation_id
            INNER JOIN affectation_histories ah_sst ON ah_sst.affectation_id = a_feedback.id AND ah_sst.status = "En cours"
            WHERE a_feedback.client_id = clients.id 
            AND ah_feedback.status IN ("Planifié", "Déclaré", "Bloqué")
            ORDER BY ah_feedback.created_at ASC LIMIT 1), NULL) AS delai_3'),

        // Retard Délai 3 (48h max from SST assignment)
        DB::raw('IFNULL((SELECT 
            CASE 
                WHEN TIMESTAMPDIFF(HOUR, ah_sst.created_at, ah_feedback.created_at) > 48 
                THEN CONCAT(
                    TIMESTAMPDIFF(HOUR, ah_sst.created_at, ah_feedback.created_at) - 48, " heures et ",
                    TIMESTAMPDIFF(MINUTE, ah_sst.created_at, ah_feedback.created_at) % 60, " minutes"
                )
                ELSE "À temps"
            END
            FROM affectation_histories ah_feedback 
            INNER JOIN affectations a_feedback ON a_feedback.id = ah_feedback.affectation_id
            INNER JOIN affectation_histories ah_sst ON ah_sst.affectation_id = a_feedback.id AND ah_sst.status = "En cours"
            WHERE a_feedback.client_id = clients.id 
            AND ah_feedback.status IN ("Planifié", "Déclaré", "Bloqué")
            ORDER BY ah_feedback.created_at ASC LIMIT 1), "Non traité") AS retard_delai_3'),

        // Affectation 1 (Backoffice -> Soustraitant)
        DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y ") END) as affectation1_date'),
        DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%H:%i") END) as affectation1_heure'),
        DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.status END) as affectation1_status'),
        DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN st_aff1.name END) as affectation1_soustraitant'),

        // Affectation 2 (Soustraitant -> Technicien)
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
                $lastColumn = 'AB'; // Updated to include all 26 columns (A to Z)
    
                // Helper function to generate column letters
                $getColumnName = function($num) {
                    $numeric = $num - 1;
                    $letter = '';
                    while ($numeric > -1) {
                        $letter = chr(65 + ($numeric % 28)) . $letter;
                        $numeric = floor($numeric / 28) - 1;
                    }
                    return $letter;
                };
    
                // Style for the header row (A1:Z1)
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
    
                // Style for all cells (A1:Z{lastRow})
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
    
                // Auto-size columns (A to Z)
                for ($i = 1; $i <= 26; $i++) { // Adjusted to include all 26 columns (A to Z)
                    $column = $getColumnName($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
    






    // public function collection()
    // {   
    //     return Client::select([
         
    //         DB::raw('DATE_FORMAT(clients.created_at, "%d-%m-%Y") as creation_date'),
    //         DB::raw('DATE_FORMAT(clients.created_at, "%H:%i") as creation_time'),  
    //         'st_initial.name as equipe',
    //         'clients.address',
    //         'clients.type',
    //         'clients.sip',
    //         'clients.client_id as ID',
    //         'clients.routeur_type as routeur',
    //         'cities.name as zone',
    //         'clients.name as nom_client',
    //         'clients.phone_no as telephone',
    //         'clients.debit',
    //         'clients.status as etat_actuel',
    //         DB::raw('CASE 
    //             WHEN MIN(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.created_at END) IS NOT NULL THEN
    //                 DATEDIFF(
    //                     MIN(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.created_at END),
    //                     clients.created_at
    //                 )
    //             ELSE NULL
    //         END as processing_time'),
    
    //         // Première affectation (Backoffice -> Soustraitant)
    //         DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y ") END) as affectation1_date'),
    //         DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN DATE_FORMAT(affectation_histories.created_at, "%H:%i") END) as affectation1_heure'),
    //         DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN affectation_histories.status END) as affectation1_status'),
    //         DB::raw('MAX(CASE WHEN hist_rank.rank = 1 THEN st_aff1.name END) as affectation1_soustraitant'),
    
    //         // Deuxième affectation (Soustraitant -> Technicien)
    //         DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN DATE_FORMAT(affectation_histories.created_at, "%d-%m-%Y") END) as affectation2_date'),
    //         DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN DATE_FORMAT(affectation_histories.created_at, " %H:%i") END) as affectation2_heure'),
    //         DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN affectation_histories.status END) as affectation2_status'),
    //         DB::raw('MAX(CASE WHEN hist_rank.rank = 2 THEN CONCAT(users_aff2.first_name, " ", users_aff2.last_name) END) as affectation2_technicien'),

    //     ])
    //     ->join('cities', 'cities.id', '=', 'clients.city_id')
    //     ->leftJoin('techniciens', 'clients.technicien_id', '=', 'techniciens.id')
    //     ->leftJoin('soustraitants as st_initial', 'techniciens.soustraitant_id', '=', 'st_initial.id')
    //     ->leftJoin('affectations', function ($join) {
    //         $join->on('clients.id', '=', 'affectations.client_id')
    //             ->whereNull('affectations.deleted_at');
    //     })
    //     ->leftJoin(DB::raw('(
    //         SELECT 
    //             ah.affectation_id,
    //             ah.id as history_id,
    //             a.client_id,
    //             ROW_NUMBER() OVER (PARTITION BY a.client_id ORDER BY ah.created_at ASC) as rank
    //         FROM affectation_histories ah
    //         INNER JOIN affectations a ON a.id = ah.affectation_id
    //         WHERE a.deleted_at IS NULL
    //     ) as hist_rank'), function($join) {
    //         $join->on('affectations.id', '=', 'hist_rank.affectation_id')
    //              ->on('clients.id', '=', 'hist_rank.client_id');
    //     })
    //     ->leftJoin('affectation_histories', 'hist_rank.history_id', '=', 'affectation_histories.id')
    //     // Jointures pour Affectation 1
    //     ->leftJoin('soustraitants as st_aff1', function($join) {
    //         $join->on('affectation_histories.soustraitant_id', '=', 'st_aff1.id')
    //             ->whereRaw('hist_rank.rank = 1');
    //     })
    //     // Jointures pour Affectation 2
    //     ->leftJoin('techniciens as tech_aff2', function($join) {
    //         $join->on('affectation_histories.technicien_id', '=', 'tech_aff2.id')
    //             ->whereRaw('hist_rank.rank = 2');
    //     })
    //     ->leftJoin('users as users_aff2', 'tech_aff2.user_id', '=', 'users_aff2.id')
    //     ->leftJoin('soustraitants as st_aff2', function($join) {
    //         $join->on('affectation_histories.soustraitant_id', '=', 'st_aff2.id')
    //             ->whereRaw('hist_rank.rank = 2');
    //     })
    //     ->where('clients.deleted_at', null)
    //     ->when($this->start_date && $this->end_date, function ($query) {
    //         return $query->whereBetween('clients.created_at', [
    //             Carbon::parse($this->start_date)->startOfDay(), 
    //             Carbon::parse($this->end_date)->endOfDay()
    //         ]);
    //     })
    //     ->whereNull('clients.statusSav')
    //     ->orderBy('clients.created_at', 'DESC')
    //     ->groupBy([
    //         'clients.id',
    //         'clients.created_at',
    //         'st_initial.name',
    //         'clients.address',
    //         'clients.type',
    //         'clients.sip',
    //         'clients.client_id',
    //         'clients.routeur_type',
    //         'cities.name',
    //         'clients.name',
    //         'clients.phone_no',
    //         'clients.debit',
    //         'clients.status'
    //     ])
    //     ->get();
    // }
    
 
   

    public function title(): string
    {
        return 'ToExcel';
    }


}
