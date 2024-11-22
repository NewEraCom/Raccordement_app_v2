<?php

namespace App\Http\Livewire\StoreKeeper;

use App\Services\web\StockService;
use Livewire\Component;

class StockPage extends Component
{
    public function render()
    {
        $stock = StockService::getDetailsStock();

        return view('livewire.store-keeper.stock-page',compact('stock'))->layout('layouts.app',['title' => 'Stock']);
    }
}
