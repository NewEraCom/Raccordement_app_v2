<?php

namespace App\Http\Livewire\Backoffice;

use App\Charts\StockChart;
use App\Models\Soustraitant;
use App\Models\SoustraitantStock;
use App\Models\SoustraitantStockDemand;
use App\Services\web\StockService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StockPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $soustraitant_id;
    public $soustraitant;
    public $stock_id;

    public $e_f680, $e_f6600, $e_pto, $e_cable, $e_jarretier, $e_fix, $e_splitter;
    public $f680, $f6600, $pto, $cable, $jarretier, $fix, $splitter;


    public function add()
    {
        $this->validate([
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
                'soustraitant_id' => $this->soustraitant_id,
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

    public function setSoustraitant($id)
    {
        $this->stock_id = $id;
        $stock = SoustraitantStock::find($id);
        $this->e_pto = $stock->pto;
        $this->e_f680 = $stock->f680;
        $this->e_f6600 = $stock->f6600;
        $this->e_cable = $stock->cable;
        $this->e_jarretier = $stock->jarretiere;
        $this->e_fix = $stock->fix;
        $this->e_splitter = $stock->splitter;
    }

    public function update()
    {
        $this->validate([
            'e_pto' => 'required',
            'e_f680' => 'required',
            'e_f6600' => 'required',
            'e_cable' => 'required',
            'e_jarretier' => 'required',
            'e_fix' => 'required',
            'e_splitter' => 'required',
        ]);

        try {
            DB::beginTransaction();

            SoustraitantStock::find($this->stock_id)->update([
                'pto' => $this->e_pto,
                'f680' => $this->e_f680,
                'f6600' => $this->e_f6600,
                'cable' => $this->e_cable,
                'jarretiere' => $this->e_jarretier,
                'fix' => $this->e_fix,
                'splitter' => $this->e_splitter,
            ]);
            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Stock mis à jour avec succès.']);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::channel('error')->error('Function Update in StockPage.php : ' . $th->getMessage());
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue lors de la mise à jour du stock.']);
        }
    }

    public function render(StockChart $chart)
    {
        $stock = StockService::getDetailsStock();
        $soustraitantStock = StockService::getSoustraitantStock($this->soustraitant);
        $soustraitants = Soustraitant::get(['id', 'name']);
        return view('livewire.backoffice.stock-page', compact(['soustraitants', 'stock', 'soustraitants', 'soustraitantStock']), ['chart' => $chart->build()])->layout('layouts.app', ['title' => 'Stock']);
    }
}
