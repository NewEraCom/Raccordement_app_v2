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

class AffectationBlocage implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
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
            'Cause de blocage 1',
            'Technicien',
            'Affectation 1 - Status',
            'Affectation 2 - Soustraitant',
            'Affectation 2 - Date',
            'Affectation 2 - Technicien',
            'Affectation 2 - Status',
            'Cause de blocage 2',
            'Affectation 3 - Soustraitant',
            'Affectation 3 - Date',
            'Affectation 3 - Technicien',
            'Affectation 3 - Status',
            'Cause de blocage 3',
            'Date de la dernière mise à jour'
        ];
    }

    public function collection()
    {
        return DB::table('affectation_histories as a1')
            ->select([
                DB::raw('DATE_FORMAT(a1.created_at, "%d-%m-%Y %H:%i") as date_creation'),
                's1.name as equipe',
                'c.address',
                'c.sip',
                'c.client_id as ID',
                'c.routeur_type as routeur',
                'cities.name as zone',
                'c.name as nom_client',
                'c.phone_no as telephone',
                'c.debit',
                'b1.cause as cause_blocage_1',
                DB::raw("CONCAT(u1.first_name, ' ', u1.last_name) as technicien"),
                'a1.status as affectation_1_status',
                's2.name as affectation_2_soustraitant',
                DB::raw('DATE_FORMAT(a2.created_at, "%d-%m-%Y %H:%i:%s") as affectation_2_date'),
                DB::raw("CONCAT(u2.first_name, ' ', u2.last_name) as affectation_2_technicien"),
                'a2.status as affectation_2_status',
                'b2.cause as cause_blocage_2',
                's3.name as affectation_3_soustraitant',
                DB::raw('DATE_FORMAT(a3.created_at, "%d-%m-%Y %H:%i:%s") as affectation_3_date'),
                DB::raw("CONCAT(u3.first_name, ' ', u3.last_name) as affectation_3_technicien"),
                'a3.status as affectation_3_status',
                'b3.cause as cause_blocage_3',
                DB::raw('DATE_FORMAT(a1.updated_at, "%d-%m-%Y %H:%i:%s") as derniere_maj')
            ])
            ->join('affectations as aff', 'aff.id', '=', 'a1.affectation_id')
            ->join('clients as c', 'c.id', '=', 'aff.client_id')
            ->join('cities', 'cities.id', '=', 'c.city_id')
            ->leftJoin('techniciens as t1', 't1.id', '=', 'a1.technicien_id')
            ->leftJoin('users as u1', 'u1.id', '=', 't1.user_id')
            ->leftJoin('soustraitants as s1', 's1.id', '=', 'a1.soustraitant_id')
            ->leftJoin('blocages as b1', 'b1.affectation_id', '=', 'a1.affectation_id')
            // Deuxième affectation
            ->leftJoin('affectation_histories as a2', function($join) {
                $join->on('a2.affectation_id', '=', 'a1.affectation_id')
                    ->whereRaw('a2.created_at = (
                        SELECT MIN(created_at)
                        FROM affectation_histories
                        WHERE affectation_id = a1.affectation_id
                        AND created_at > a1.created_at
                    )');
            })
            ->leftJoin('techniciens as t2', 't2.id', '=', 'a2.technicien_id')
            ->leftJoin('users as u2', 'u2.id', '=', 't2.user_id')
            ->leftJoin('soustraitants as s2', 's2.id', '=', 'a2.soustraitant_id')
            ->leftJoin('blocages as b2', 'b2.affectation_id', '=', 'a2.affectation_id')
            // Troisième affectation
            ->leftJoin('affectation_histories as a3', function($join) {
                $join->on('a3.affectation_id', '=', 'a1.affectation_id')
                    ->whereRaw('a3.created_at = (
                        SELECT MIN(created_at)
                        FROM affectation_histories
                        WHERE affectation_id = a1.affectation_id
                        AND created_at > a2.created_at
                    )');
            })
            ->leftJoin('techniciens as t3', 't3.id', '=', 'a3.technicien_id')
            ->leftJoin('users as u3', 'u3.id', '=', 't3.user_id')
            ->leftJoin('soustraitants as s3', 's3.id', '=', 'a3.soustraitant_id')
            ->leftJoin('blocages as b3', 'b3.affectation_id', '=', 'a3.affectation_id')
            ->where('a1.status', 'Bloqué')
            ->whereNull('aff.deleted_at')
            ->whereNull('c.deleted_at')
            ->orderBy('a1.created_at', 'desc')
            ->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:M1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:M1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:M1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:M' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:M' . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:M' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:M' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:M' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }


    public function title(): string
    {
        return 'Affectations Bloqué ' . date('d-m-Y');
    }
}
