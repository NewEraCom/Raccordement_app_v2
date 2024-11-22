<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Blocage;
use Livewire\Component;

class BlocageReport extends Component
{
    public $blocage;
    public function mount(Blocage $blocage)
    {
        $this->blocage = $blocage;
    }

    public function render()
    {
        return view('livewire.backoffice.blocage-report')->layout('layouts.app',['title' => 'Rapport de blocage']);
    }
}
