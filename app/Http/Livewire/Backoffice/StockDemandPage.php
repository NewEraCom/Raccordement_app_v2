<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Soustraitant;
use App\Models\SoustraitantStockDemand;
use App\Services\web\StockService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class StockDemandPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $soustraitant_id, $status, $start_date = '', $end_date = '';

    public $demand_id,$e_soustraitant,$e_f680, $e_f6600, $e_pto, $e_cable, $e_jarretier, $e_fix, $e_splitter;
    public $soustraitant,$f680, $f6600, $pto, $cable, $jarretier, $fix, $splitter;    

    public function setDemande($item)
    {
        $this->demand_id = $item['id'];
        $this->e_soustraitant = $item['soustraitant']['id'];
        $this->e_pto = $item['pto'];
        $this->e_f680 = $item['f680'];
        $this->e_f6600 = $item['f6600'];
        $this->e_jarretier = $item['jarretiere'];
        $this->e_splitter = $item['splitter'];
        $this->e_cable = $item['cable'];
        $this->e_fix = $item['fix'];
    }

    public function update()
    {
        $this->validate([
            'e_soustraitant' => 'required',
            'e_pto' => 'required',
            'e_f680' => 'required',
            'e_f6600' => 'required',
            'e_cable' => 'required',
            'e_jarretier' => 'required',
            'e_fix' => 'required',
            'e_splitter' => 'required',
        ]);

        try{
            DB::beginTransaction();

            SoustraitantStockDemand::find($this->demand_id)->update([
                'soustraitant_id' => $this->e_soustraitant,
                'pto' => $this->e_pto,
                'f680' => $this->e_f680,
                'f6600' => $this->e_f6600,
                'jarretiere' => $this->e_jarretier,
                'splitter' => $this->e_splitter,
                'cable' => $this->e_cable,                
                'fix' => $this->e_fix,
                'status' => 0,                
            ]);

            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Demande de stock a été modifié avec succès.']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue lors de la modification de la demande de stock.']);
        }
    }

   
    public function add()
    {
        $this->validate([
            'soustraitant' => 'required',
            'pto' => 'required',
            'f680' => 'required',
            'f6600' => 'required',
            'cable' => 'required',
            'jarretier' => 'required',
            'fix' => 'required',
            'splitter' => 'required',
        ]);

        try {
            DB::beginTransaction();

            SoustraitantStockDemand::create([
                'soustraitant_id' => $this->soustraitant,
                'created_by' => auth()->user()->id,
                'pto' => $this->pto,
                'f680' => $this->f680,
                'f6600' => $this->f6600,
                'jarretiere' => $this->jarretier,
                'splitter' => $this->splitter,
                'cable' => $this->cable,                
                'fix' => $this->fix,
                'status' => 0,                
            ]);

            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Demande de stock a été envoyé avec succès.']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue lors de l\'envoi de la demande de stock.']);
        }
    }

    public function render()
    {
        $demandes = StockService::getStock($this->soustraitant_id, $this->status, $this->start_date, $this->end_date)->paginate(15);
        $data = StockService::KpisStock();
        $soustraitants = Soustraitant::get(['id', 'name']);
        return view('livewire.backoffice.stock-demand-page', compact(['demandes', 'data', 'soustraitants']))->layout('layouts.app', ['title' => 'Demande de stock']);
    }
}
