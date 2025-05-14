<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Blocage;
use Livewire\Component;

class BlocageReport extends Component
{
    public $blocage;
    public $imageOrder = [
        'Photo façade',
        'PBI (Fermé)',
        'PBI (Ouvert)',
        'Splitter 1',
        'Splitter 2',
        'PBO (Fermé)',
        'PBO (Ouvert)',
        'Splitter 3',
        'Splitter 4',
        'Chambre (Fermé)',
        'Chambre (Ouvert)',
    ];
    public function mount(Blocage $blocage)
    {
        $this->blocage = $blocage;
    }
    

    public function render()
    {
        return view('livewire.backoffice.blocage-report')->layout('layouts.app',['title' => 'Rapport de blocage','imageOrder' => $this->imageOrder]);
    }
}
