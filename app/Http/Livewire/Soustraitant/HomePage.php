<?php

namespace App\Http\Livewire\Soustraitant;

use App\Models\Soustraitant;
use Livewire\Component;
use App\Models\Technicien;

class HomePage extends Component
{
    public function render()
    {
        $techniciens = Technicien::withCount('blocages','affectations','declarations')->where('soustraitant_id', auth()->user()->soustraitant_id)->get();   
        $soustraitant = Soustraitant::find(auth()->user()->soustraitant_id);
        $daily_affectations =  $soustraitant->dailyAffectations->count();
        $affectations = $soustraitant->affectations->count();
        $daily_rdv_clients = $soustraitant->dailyPlanifications->count();
        $daily_blocages_clients = $soustraitant->dailyBlocages->count();
        $total_client_done = $soustraitant->totalClientDone->count();
        return view('livewire.soustraitant.home-page', compact('techniciens','daily_affectations','affectations','soustraitant','daily_rdv_clients','daily_blocages_clients','total_client_done'))->layout('layouts.app', ['title' => 'Soustraitant']);
    }
}
