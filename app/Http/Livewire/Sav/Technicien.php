<?php

namespace App\Http\Livewire\Sav;

use App\Models\SavTicket;
use App\Models\Technicien as ModelsTechnicien;
use App\Services\web\ClientSavService;
use Livewire\Component;
use Livewire\WithPagination;

class Technicien extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $technicien,$searchTerm;
    public function mount(ModelsTechnicien $technicien){
        $this->technicien = $technicien;
    }
    public function render()
    {
       // $profileTech = ModelsTechnicien::withCount('affectations','declarations','blocages')->with('affectations')->find($this->technicien->id);   
        $tickets = ClientSavService::getTechnicienTickets($this->searchTerm, $this->technicien->id);
        $kpis = [
            'totalTickets' => $tickets->count(),
            'totalConnecté' => $tickets->where('status', 'Validé')->count(),
            'totalBlockages' => $tickets->where('status', 'Bloqué')->count(),
            'clientsPlanned' => $tickets->where('status', 'planifié')->count(),
        ];
        return view('livewire.sav.technicien',compact('tickets','kpis'))->layout('layouts.app',['title' => $this->technicien->user->getFullname()]);
    
    }
}
