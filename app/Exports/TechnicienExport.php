<?php

namespace App\Exports;

use App\Models\Technicien;
use App\Services\web\TechniciensService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TechnicienExport implements FromCollection,WithHeadings,ShouldAutoSize,WithEvents
{
    use Exportable;

    public $filtrage_name, $soustraitant_selected, $status, $start_date, $end_date;

    public function __construct($filtrage_name, $soustraitant_selected, $status, $start_date, $end_date)
    {
        $this->filtrage_name = $filtrage_name;
        $this->soustraitant_selected = $soustraitant_selected;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return [
            'Technicien',
            'Email',
            'Téléphone',
            'Soustaitant',
            'Affectation',
            'Declaration',
            'Blocage',
            'Compteur de planification',
            'Date de création',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:I1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('002060');
                $event->sheet->getStyle('A1:I'.$lastRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getStyle('A1:I'.$lastRow)->getFont()->setSize(10);
                $event->sheet->getStyle('A1:I'.$lastRow)->getFont()->setName('Calibri');
                $event->sheet->getStyle('A1:I'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A1:I'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Technicien::withCount(['affectations', 'declarations', 'blocages'])->select(DB::raw("CONCAT(users.first_name,' ',users.last_name) as full_name"),'users.email','users.phone_no','soustraitants.name' ,'users.created_at')
        ->join('users', 'users.id', '=', 'techniciens.user_id')
        ->join('soustraitants','soustraitants.id','=','techniciens.soustraitant_id')
        ->join('affectations','affectations.technicien_id','=','techniciens.id')
        ->orderBy('users.created_at','DESC')
        ->get();
    }
}
