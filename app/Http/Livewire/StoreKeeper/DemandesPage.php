<?php

namespace App\Http\Livewire\StoreKeeper;

use Livewire\Component;
use App\Models\Soustraitant;
use App\Services\web\StockService;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\SoustraitantStockDemand;

class DemandesPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $soustraitant_id, $status, $start_date, $end_date;

    public $request_id;


    public function livre()
    {
        try {
            DB::beginTransaction();
            $stockDemand = SoustraitantStockDemand::where('id', $this->request_id)->first();
            $stockDemand->update(['status' => 1]);
            $stockDemand->soustraitant->stock->increment('f680', $stockDemand->f680);
            $stockDemand->soustraitant->stock->increment('f6600', $stockDemand->f6600);
            $stockDemand->soustraitant->stock->increment('pto', $stockDemand->pto);
            $stockDemand->soustraitant->stock->increment('cable', $stockDemand->cable);
            $stockDemand->soustraitant->stock->increment('jarretiere', $stockDemand->jarretiere);
            $stockDemand->soustraitant->stock->increment('splitter', $stockDemand->splitter);
            $stockDemand->soustraitant->stock->increment('fix', $stockDemand->fix);
            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged',['item' => 'Le stock a été livré avec succès.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged',['item' => 'Une erreur est survenue.']);
        }
    }

    public function render()
    {
        $demandes = StockService::getStock($this->soustraitant_id, $this->status, $this->start_date, $this->end_date)->paginate(15);
        $soustraitants = Soustraitant::get(['id', 'name']);
        $data = StockService::KpisStock();

        return view('livewire.store-keeper.demandes-page', compact('demandes', 'soustraitants', 'data'))->layout('layouts.app', ['title' => 'Demandes']);
    }
}
