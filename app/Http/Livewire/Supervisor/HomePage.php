<?php

namespace App\Http\Livewire\Supervisor;

use App\Charts\StatisticForSoustraitantChart;
use App\Models\Pipe;
use App\Services\web\SupervisorService;
use Livewire\Component;

class HomePage extends Component
{
    public $date, $start_date, $end_date;

    public function mount()
    {
        $this->date = now()->format('m-Y');
        $this->start_date = now()->format('d-m-Y');
        $this->end_date = now()->format('d-m-Y');
    }

    public function render(StatisticForSoustraitantChart $chart)
    {
        $data = SupervisorService::getDashboardKpis();
        $pipe = Pipe::whereDate('created_at',today())->orderBy('created_at','DESC')->first('total');
        return view('livewire.supervisor.home-page', compact('data','pipe'), [
            'chart' => $chart->build([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]),
        ])->layout('layouts.app', ['title' => 'Home Page']);
    }
}
