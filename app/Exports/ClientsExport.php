<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ClientsExport implements WithMultipleSheets
{
    use Exportable;

    protected $technicien, $start_date,$end_date, $date, $plaque_id, $city_id;

    public function __construct($technicien, $start_date, $end_date,$plaque_id, $city_id)
    {
        $this->technicien = $technicien;
        $this->date = [Carbon::parse($start_date)->startOfDay(),Carbon::parse($end_date)->endOfDay()];
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->plaque_id = $plaque_id;
        $this->city_id = $city_id;
    }

    public function sheets(): array
    {
        $sheets = [
            'CANVA_' . now() => new CanvaExport($this->start_date,$this->end_date,$this->technicien,$this->plaque_id,$this->city_id),
            'Tous les clients' => new AllClientExport($this->start_date,$this->end_date,$this->plaque_id,$this->city_id),
            'Clients Restant' => new ClientsRestantExport(),
            'Affectation Bloque' => new AffectationBlocage($this->technicien,$this->start_date,$this->end_date,$this->plaque_id,$this->city_id),
            'Affectation Historique' => new AffectationHistorique($this->technicien,$this->start_date,$this->end_date,$this->plaque_id,$this->city_id),
            'Affectation Planifier' => new AffectationPlanned($this->technicien,$this->start_date,$this->end_date,$this->plaque_id,$this->city_id),
        ];

        return $sheets;
    }
}
