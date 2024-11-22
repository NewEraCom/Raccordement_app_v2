<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class AffectationExport implements WithMultipleSheets
{
    use Exportable;

    protected $technicien, $start_date, $end_date;

    public function __construct($technicien, $start_date, $end_date)
    {
        $this->technicien = $technicien;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function sheets(): array
    {
        $sheets = [
            //'Affectations_' => new AffectationAll($this->technicien, $this->start_date, $this->end_date),
            //'Affectations En Cours' => new AffectationEnCours($this->technicien, $this->start_date,$this->end_date),
            'Affectations Bloqué' => new AffectationBlocage($this->technicien, $this->start_date, $this->end_date),
            'Affectations Planifié' => new AffectationPlanned($this->technicien, $this->start_date, $this->end_date),
            //'Affectations Terminé' => new AffectationDone($this->technicien, $this->start_date,$this->end_date), 
        ];
        return $sheets;
    }
}
