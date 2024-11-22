<?php

namespace App\Http\Livewire\Controller;

use Livewire\Component;

class BlocageControllerPage extends Component
{
    public function render()
    {
        return view('livewire.controller.blocage-controller-page')->layout('layouts.app',['title'=>'Blocages']);
    }
}
