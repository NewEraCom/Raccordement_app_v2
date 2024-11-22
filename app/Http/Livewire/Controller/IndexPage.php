<?php

namespace App\Http\Livewire\Controller;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;
use App\Models\Blocage;
use App\Services\web\ClientsService;

class IndexPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $start_date, $end_date;

    public function render()
    {
        $data = ClientsService::kpisController();
        $planification = Client::where('flagged',true)->whereHas('affectations',function($query){
            $query->where('status','Planifié');
        })->get();

        $clients = Client::with('city')->when($this->start_date && $this->end_date, function ($query) {
            $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        })->whereIn('status',['Déclaré','Validé'])->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.controller.index-page', compact('clients','data','planification'))->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
