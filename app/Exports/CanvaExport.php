<?php

namespace App\Exports;

use App\Models\Client;
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


class CanvaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    public $technicien;
    
    public $start_date,$end_date;

    public function __construct($start_date,$end_date, $technicien)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;

        $this->technicien = $technicien;
    }

    public function headings(): array
    {
        return [
            'Compte SIP',
            'Login internet',
            'Nom de client',
            'Adresse',
            'Ville',
            'Numéro de téléphone',
            'Type',
            'Débit',
            'Équipe',
            'Technicien',
            "Date d'intervention",
            'Test signal',
            'Test debit',
            'CIN',
            'Routeur',
            'SN_GPON',
            'SN_MAC',
            'Câble 1FO',
            'PTO',
            'Jartiere',
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
        return Client::select('sip', 'clients.client_id', 'clients.name', 'address','cities.name as city_name','clients.phone_no','type','debit','soustraitants.name as soustraitant_name',DB::raw("CONCAT(users.first_name,' ',users.last_name)"),DB::raw('DATE_FORMAT(affectations.updated_at, "%d-%m-%Y")'),'declarations.test_signal', 'validations.test_debit', 'validations.cin_description','clients.routeur_type','routeurs.sn_gpon', 'routeurs.sn_mac', 'declarations.cable_metre', 'declarations.pto', 'declarations.nbr_jarretieres') 
            ->join('cities', 'clients.city_id', '=', 'cities.id')
            ->join('techniciens', 'clients.technicien_id', '=', 'techniciens.id')
            ->join('users','techniciens.user_id','=','users.id')
            ->join('soustraitants', 'techniciens.soustraitant_id', '=', 'soustraitants.id')
            ->join('affectations', 'clients.id', '=', 'affectations.client_id')
            ->join('declarations','affectations.id','=','declarations.affectation_id')
            ->leftJoin('validations','affectations.id','=','validations.affectation_id')
            ->leftJoin('routeurs','clients.id','=','routeurs.client_id')
            ->when($this->start_date && $this->end_date, function ($query) {
                return $query->whereBetween('validations.created_at', [Carbon::parse($this->start_date)->startOfDay(), Carbon::parse($this->end_date)->endOfDay() ]);
            })
            ->whereNull('clients.statusSav')
            ->groupBy('clients.sip')
            ->whereIn('clients.status',['Validé'])
            ->get();
    }

    public function title(): string
    {
        return 'CANVA_' . date('d-m-Y');
    }
}
