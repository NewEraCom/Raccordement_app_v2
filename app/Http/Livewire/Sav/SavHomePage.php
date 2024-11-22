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
use Illuminate\Database\Eloquent\Collection;


class SavHomePage extends Component
{


    public function render(ClientsByCityChart $chart, BlocageSavChart $chart2)
    {
        $savClients = Client::whereNotNull('statusSav')->get();
        $Client_down = Client::where('statusSav', 'Down')->get();
        $Ticket_soustraitant = SavTicket::where('status','!=','Valide');
        $Ticket_technicien = SavTicket::where('status','!=','Valide')->whereNotNull('technicien_id');
        $Client_Connecte = Client::where('statusSav', 'Connecté')->count();
        $total_blocages_for_today = SavTicket::where('status', 'Bloqué')->get();
        $total_planification_for_today = SavTicket::whereDate('planification_date', today())->count();
        $total_pipe = Client::where('statusSav', '!=', 'Connecté')
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
