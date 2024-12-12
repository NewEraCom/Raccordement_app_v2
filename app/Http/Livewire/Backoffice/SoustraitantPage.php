<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Soustraitant;
use App\Models\SoustraitantStock;
use Livewire\Component;
use Illuminate\Support\Str;

class SoustraitantPage extends Component
{

    public $name,$soustraitant_name;


    public function add(){
        $this->validate([
            'soustraitant_name' => 'required',
        ]);

        $soustraitant = Soustraitant::create([
            'uuid' => Str::uuid(),
            'name' => $this->soustraitant_name,
        ]);
        SoustraitantStock::create([
            'soustraitant_id' => $soustraitant->id,
            'f680' => 0,
            'f6600' => 0,
            'pto' => 0,
            'cable' => 0,
            'fix' => 0,
            'jarretiere' => 0,
            'splitter' => 0,
            'racco' => 0,
        ]);

        $this->soustraitant_name = '';
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Soustraitant ajouté avec succès.']);
    }

    public function render()
    {
        $soustraitant = Soustraitant::withCount(['techniciens','clients'])->where('name','LIKE','%'.$this->name.'%')->get();
        return view('livewire.backoffice.soustraitant-page',compact('soustraitant'))->layout('layouts.app', [
            'title' => 'Soustraitant',
        ]);
    }
}
