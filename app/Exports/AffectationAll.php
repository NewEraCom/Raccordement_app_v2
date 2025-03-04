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

class AffectationAll implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;

    protected $start_date,$end_date, $technicien;

    public function __construct($technicien, $start_date,$end_date)
    {
        $this->technicien = $technicien;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return [
            'Date de creation',
            'Heure de creation',
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
            'Technicien',
        ];
    }

    public function collection()
    {
        return Affectation::select(DB::raw('DATE_FORMAT(affectations.created_at, "%d-%m-%Y ")'), DB::raw('DATE_FORMAT(clients.created_at, "%H:%i") as creation_time'),'soustraitants.name as soustraitant_name','clients.address','clients.sip','clients.client_id','clients.routeur_type as routeur','cities.name as city_name','clients.name','clients.phone_no as phoneNumber','clients.debit','affectations.status',DB::raw("CONCAT(users.first_name,' ',users.last_name)"))
            ->join('clients', 'clients.id', '=', 'affectations.client_id')
            ->join('cities', 'cities.id', '=', 'clients.city_id')
            ->join('techniciens', 'techniciens.id', '=', 'affectations.technicien_id')
            ->join('users', 'users.id', '=', 'techniciens.user_id')
            ->join('soustraitants', 'soustraitants.id', '=', 'techniciens.soustraitant_id')
            ->when($this->technicien, function ($query, $technicien) {
                return $query->where('techniciens.id', $technicien);
            })->when($this->start_date && $this->end_date, function ($query) {
                return $query->whereBetween('affectations.created_at', [Carbon::parse($this->start_date)->startOfDay(), Carbon::parse($this->end_date)->endOfDay()]);
            })
            ->where('affectations.deleted_at', null)
            ->orderBy('affectations.created_at', 'desc')
            ->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:L1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:L1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:L1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:L' . $lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:L' . $lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:L' . $lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:L' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:L' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }


    public function title(): string
    {
        return 'Toutes les affectations ' . date('d-m-Y');
    }
}
