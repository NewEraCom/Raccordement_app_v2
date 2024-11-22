<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AffectationsAll implements WithMultipleSheets
{
    use Exportable;

    protected $start_date, $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function sheets(): array
    {
        $sheets = [
            'All' => new AffectationAll(null, $this->start_date, $this->end_date),
            'En Cours' => new AffectationAll(null, $this->start_date, $this->end_date),
        ];

        return $sheets;
    }
}
