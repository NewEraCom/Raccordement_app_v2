<?php

namespace App\Imports;

use App\Models\Routeur;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class RouteursImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
        $routeur = Routeur::firstOrCreate(
            [
                'sn_gpon' => $row[0],
            ],
            [
                'uuid' => Str::uuid(),
                'sn_gpon' => $row[0],
                'sn_mac' => $row[1],
                'status' => 0,
            ]
        );

        if($routeur){
            $routeur->sn_mac = $row[1];
            if($routeur->status == 2){                
                $routeur->status = 1;                
            }
            $routeur->save();
        }
    }
}
