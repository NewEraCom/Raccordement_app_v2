<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Routeur;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class RouteurController extends Controller
{
    public function getRouteurs()
    {
        $routeurs = Routeur::get();
        return  response()->json(['Routeurs' => $routeurs], 200);
    }
    
    
     public function addRouteurs(Request $request)
    {
        $routeurData = [
            'uuid' => Str::uuid(),
            'client_id' => $request->input('client_id'),
            'technicien_id' => $request->input('technicien_id'),
            'sn_gpon' => $request->input('sn_gpon'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (Routeur::where('sn_mac', $request->input('sn_mac'))->exists()) {
            $routeurData['status'] = 1;
        } else {
            $routeurData['status'] = 2;
        }

        $routeur = Routeur::updateOrCreate(['sn_mac' => $request->input('sn_mac')], $routeurData);
        return  response()->json(['Routeur' => $routeur], 200);
    }
}
