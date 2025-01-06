<?php

namespace App\Http\Livewire\Sav;

use App\Models\SavTicket;
use App\Models\Technicien as ModelsTechnicien;
use Livewire\Component;

class Technicien extends Component
{
    public $technicien;
    public function mount(ModelsTechnicien $technicien){
        $this->technicien = $technicien;
    }
    public function render()
    {
        $profileTech = ModelsTechnicien::withCount('affectations','declarations','blocages')->with('affectations')->find($this->technicien->id);   
        $tickets = SavTicket::where('technicien_id', $this->technicien->id)
        ->with(['client', 'sousTraitant', 'blocage'])
        ->latest()
        ->get();
        return view('livewire.sav.technicien',compact('profileTech','tickets'))->layout('layouts.app',['title' => $this->technicien->user->getFullname()]);
    
    }
}
