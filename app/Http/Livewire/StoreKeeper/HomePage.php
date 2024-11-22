<?php

namespace App\Http\Livewire\StoreKeeper;

use Livewire\Component;
use App\Services\web\StockService;
use Livewire\WithPagination;
use App\Models\Soustraitant;

class HomePage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $soustraitant_id, $status, $start_date = '', $end_date = '';

    public function render()
    {
        $stock = StockService::getDetailsStock();
        $demandes = StockService::getStock($this->soustraitant_id, $this->status, $this->start_date, $this->end_date)->paginate(15);
        $soustraitants = Soustraitant::get(['id', 'name']);
        return view('livewire.store-keeper.home-page',compact('stock','demandes','soustraitants'))->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
