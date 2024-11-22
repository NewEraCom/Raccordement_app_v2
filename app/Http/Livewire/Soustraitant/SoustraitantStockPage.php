<?php

namespace App\Http\Livewire\Soustraitant;

use App\Models\SoustraitantStock;
use App\Models\SoustraitantStockDemand;
use Livewire\Component;

class SoustraitantStockPage extends Component
{
    public $soustraitant_id;

   
    public function render()
    {
        $stockCount = SoustraitantStock::where('soustraitant_id',auth()->user()->soustraitant_id)->first();
        $soustraitantStockDemand = SoustraitantStockDemand::where('soustraitant_id',auth()->user()->soustraitant_id)->get();
        return view('livewire.soustraitant.soustraitant-stock-page',compact('stockCount','soustraitantStockDemand'))->layout('layouts.app', ['title' => 'Stock']);
    }
}
