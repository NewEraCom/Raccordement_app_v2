<?php

namespace App\Http\Livewire\Backoffice;

use App\Charts\BlocageByCityChart;
use App\Charts\ClientsByCityChart;
use App\Charts\StatisticForSoustraitantChart;
use App\Models\Soustraitant;
use App\Services\web\AdminDashboardService;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(ClientsByCityChart $chart,BlocageByCityChart $chart2,StatisticForSoustraitantChart $chart3)
    {
        $kpisData = AdminDashboardService::getKpisData();
        return view('livewire.backoffice.dashboard',compact(['kpisData']),['chart' => $chart->build(),'chart2' => $chart2->build(),'chart3' => $chart3->build()])->layout('layouts.app', [
            'title' => 'Dashboard',
        ]);
    }
}
