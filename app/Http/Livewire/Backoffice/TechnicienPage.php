<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Technicien;
use App\Models\TechnicienLog;
use Livewire\Component;
use OneSignal;

class TechnicienPage extends Component
{
    public $technicien;

    public function mount(Technicien $technicien){
        $this->technicien = $technicien;
    }

    public function getLocalisation(){
        try {
            $filedsh['include_player_ids'] = [$this->technicien->player_id];
            $message = 'Neweracom Souhaitez une bonne journée.';
            OneSignal::sendPush($filedsh, $message);
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Notification envoyée avec succès.']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function render()
    {
        $localisation = TechnicienLog::where('technicien_id',$this->technicien->id)->where('nb_affectation',500)->orderBy('created_at','desc')->first() ?? null;
        $profileTech = Technicien::withCount('affectations','declarations','blocages')->with('affectations')->find($this->technicien->id);   
        return view('livewire.backoffice.technicien-page',compact('profileTech','localisation'))->layout('layouts.app',['title' => $this->technicien->user->getFullname()]);
    }
}
