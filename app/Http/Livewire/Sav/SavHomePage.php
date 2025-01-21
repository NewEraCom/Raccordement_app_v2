<?php

namespace App\Http\Livewire\Sav;

use App\Models\Client;
use Livewire\Component;
use App\Models\SavTicket;
use App\Charts\BlocageSavChart;
use App\Charts\BlocageByCityChart;
use App\Charts\ClientsByCityChart;
use App\Services\web\HomePageSAVService;
use App\Http\Livewire\Soustraitant\HomePage;
use App\Charts\StatisticForSoustraitantChart;
use App\Models\SavClient;
use Illuminate\Database\Eloquent\Collection;


class SavHomePage extends Component
{


    public function render(ClientsByCityChart $chart, BlocageSavChart $chart2)
    {
        $savClients = SavClient::all();
        $Client_down = SavClient::where('status', 'Bloqué')->get();
        $Ticket_soustraitant = SavTicket::where('status','Affecté');
        $Ticket_technicien = SavTicket::where('status','En cours')->whereNotNull('technicien_id');
        $Client_Connecte = SavClient::where('status', 'Validé')->count();
        $total_blocages_for_today = SavTicket::where('status', 'Bloqué')
            ->whereDate('updated_at',today())
            ->get();
        
        $total_planification_for_today = SavTicket::whereDate('planification_date', today())->count();
        $total_pipe = SavClient::where('status', 'Saisie')
                ->count();

        $kpisData = [
            'Sav_Client' => $savClients->count(),
            'Total_Down' => $Client_down->count(),
            'Ticket_soustraitant' => $Ticket_soustraitant->count(),
            'Ticket_technicien' => $Ticket_technicien->count(),
            'Client_Connecté' => $Client_Connecte,
            'total_blocages_for_today' => $total_blocages_for_today->count(),
            'total_planification_for_today' => $total_planification_for_today,
            'total_pipe' => $total_pipe,
        ];




        return view('livewire.sav.sav-home-page', compact('kpisData'), ['chart' => $chart->build(), 'chart2' => $chart2->build()])->layout('layouts.app', [
            'title' => 'Dashboard',
        ]);
    }
}
