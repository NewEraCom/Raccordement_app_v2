<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\StockHistory;
use App\Services\web\StockService;
use Livewire\Component;
use Livewire\WithPagination;

class StockHistoric extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $start_date, $end_date;

    public function render()
    {
        $stockHistoric = StockHistory::orderBy('created_at', 'desc')->paginate(10);
        $stock = StockService::StockHistoric($this->start_date, $this->end_date);
        return view('livewire.backoffice.stock-historic', compact(['stockHistoric', 'stock']))->layout('layouts.app', ['title' => 'Historique de stock']);
    }
}
