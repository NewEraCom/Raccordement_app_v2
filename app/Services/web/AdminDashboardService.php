<?php

declare(strict_types=1);

namespace App\Services\web;

use App\Models\Affectation;
use App\Models\Blocage;
use App\Models\Client;

class AdminDashboardService
{
    static public function getKpisData()
    {
        $data = [
            'total_clients' => Client::count(),
            'total_new_importations' => Client::whereDate('created_at', today())->count(),
            'total_affectations' => Affectation::whereDate('created_at', today())->count(),
            'total_affectations_new_client' => Affectation::whereHas('client', function ($query) {
                $query->whereDate('created_at', today());
            })->count(),
            'total_validations' => Client::where('status', 'Validé')->count(),
            'total_blocages' => Blocage::where('resolue', false)->whereDate('created_at', today())->count(),
            'total_planification_for_today' => Affectation::whereDate('planification_date', today())->count(),
            'total_pipe' => Client::where('status','!=','Validé')->count(),
            'blocage_technique' => Blocage::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->where('resolue', false)->whereIn('cause', ['Câble transport dégradés', 'Manque Cable transport', 'Gpon saturé', 'Non Eligible', 'Cabel transport saturé', 'Splitter saturé', 'Pas Signal'])->count(),
            'blocage_client' => Blocage::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->where('resolue', false)->whereIn('cause', ['Demande en double','Adresse erronée/IMM sans non(non Eligible)', 'Blocage de passage coté appartement', 'Blocage de passage coté Syndic', 'Client a annulé sa demande', 'Contact Erronee', 'Indisponible', 'Injoignable/SMS', 'Manque ID'])->count(),
        ];
        return $data;
    }
}
