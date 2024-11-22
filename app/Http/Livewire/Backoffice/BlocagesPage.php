<?php

namespace App\Http\Livewire\Backoffice;

use Livewire\Component;
use Livewire\WithPagination;

class BlocagesPage extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        return view('livewire.backoffice.blocages-page')->layout('layouts.app',['title' => '']);
    }
}
