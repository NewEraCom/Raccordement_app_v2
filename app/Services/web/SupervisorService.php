<?php


declare(strict_types=1);

namespace App\Services\web;

use App\Models\Affectation;
use App\Models\Blocage;
use App\Models\Client;
use Carbon\Carbon;

class SupervisorService
{
    static function getDashboardKpis()
    {

        $MonthlyClient = Client::whereMonth('created_at', today()->month)->whereYear('created_at', today()->year)->count();
        $clientDoneMonth = Client::whereIn('status', ['Validé', 'Déclaré'])->whereMonth('created_at', today()->month)->whereYear('created_at', today()->year)->count();
        $chut = number_format((1 - ($clientDoneMonth / $MonthlyClient)) * 100, 2, '.', '');

        return [
            'monthlyClient' => $MonthlyClient,
            'clientDone' => $clientDoneMonth,
            'chut' => $chut,
            'clientOfTheDay' => Client::whereDate('created_at', today())->count(),
            'clientDoneOfTheDay' => Affectation::where('status', 'Terminé')->whereHas('declarations', function ($query) {
                $query->whereDate('created_at', today());
            })->count(),
            'clientPlanifier' => Affectation::where('status', 'Planifié')->whereDate('planification_date', today())->count(),
            'prTech' => Blocage::where('resolue', false)->whereIn('cause', ['Câble transport dégradés ', 'Manque Cable transport', 'Gpon saturé', 'Non Eligible', 'Cabel transport saturé', 'Splitter saturé', 'Pas Signal'])->whereDate('created_at', today())->count(),
            'prClient' => Blocage::where('resolue', false)->whereIn('cause', ['Adresse erronée', 'Blocage de passage coté appartement', 'Blocage de passage coté Syndic', 'Client  a annulé sa demande', 'Contact Erronee', 'Indisponible', 'Injoignable/SMS', 'Manque ID'])->whereDate('created_at', today())->count(),
        ];
    }
}
