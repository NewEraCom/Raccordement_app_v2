<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RouteurExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets():array
    {
        $sheets = [
            'Routeur' => new RouteurAll(),
        ];

        return $sheets;
    }


}
