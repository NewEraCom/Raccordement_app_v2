<?php

namespace App\Http\Livewire\Sav;

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
    
        return view('livewire.sav.technicien',compact('profileTech'))->layout('layouts.app',['title' => $this->technicien->user->getFullname()]);
    
    }
}
