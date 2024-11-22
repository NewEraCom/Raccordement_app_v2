<?php

namespace App\Http\Livewire\Controller;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ReportsPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '',$client;

    public function render()
    {
        $clients = Client::where('phase_one', true)
        ->when($this->search, function ($query) {
            $search = '%' . $this->search . '%';
            $query->where('name', 'like', $search)
                ->orWhere('phone_no', 'like', $search)
                ->orWhere('address', 'like', $search);
        })
        ->paginate(15);
    
        return view('livewire.controller.reports-page',compact('clients'))->layout('layouts.app',['title' => 'Rapports']);
    }
}
