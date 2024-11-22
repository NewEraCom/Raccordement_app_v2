<?php

namespace App\Http\Livewire\Backoffice;

use App\Exports\PlaqueExport;
use App\Models\City;
use App\Models\Client;
use App\Models\Plaque;
use App\Models\Technicien;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


class PlaquesPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status, $plaque_name = "",$is_ppi, $plaque_id, $deleteList = [], $city, $plaque;
    public $technicien_affectation;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInputs()
    {
        $this->deleteList = [];
        $this->technicien_affectation = '';
    }

    public function add()
    {
        $this->validate([
            'plaque' => 'required',
            'city' => 'required',
        ]);

        Plaque::create([
            'code_plaque' => $this->plaque,
            'city_id' => $this->city,
            'is_ppi' => $this->is_ppi,
        ]);

        $this->city = $this->plaque = '';
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Plaque ajouté avec succès.']);
    }

    public function edit()
    {
        $this->validate([
            'plaque' => 'required',
            'city' => 'required',
        ]);


        Plaque::find($this->plaque_id)->update([
            'code_plaque' => $this->plaque,
            'city_id' => $this->city,
            'is_ppi' => $this->is_ppi,
        ]);

        $this->city = $this->plaque = '';
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Plaque modifié avec succès.']);
    }

    public function setPlaque(Plaque $plaque)
    {
        $this->plaque_id = $plaque->id;
        $this->plaque = $plaque->code_plaque;
        $this->city = $plaque->city_id;
        $this->is_ppi = $plaque->is_ppi;
    }

    public function delete()
    {
        
        try {
            DB::beginTransaction();
            $clients = Client::where('plaque_id', $this->plaque_id)->get();

            foreach ($clients as $item) {
                $item->update([
                    'plaque_id' => 114,
                    'city_id' => 12,
                ]);
            }
            Plaque::find($this->plaque_id)->update([
                'city_id' => 12,
                'is_ppi' => 0,
            ]);
            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Plaque supprimé avec succès.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            $this->emit('error');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Erreur lors de la suppression de la plaque.']);
        }
    }

    public function deleteAll()
    {
        foreach ($this->deleteList as $item) {
            $clients = Client::where('plaque_id', $item)->get();

            foreach ($clients as $item) {
                $item->update([
                    'plaque_id' => 114,
                    'city_id' => 12,
                ]);
            }
            
            Plaque::find($item)->update([
                'city_id' => 12,
                'is_ppi' => 0,
            ]);
        }
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Plaques supprimés avec succès.']);
        $this->resetInputs();
    }

    public function affectation()
    {
        $this->validate([
            'technicien_affectation' => 'required',
        ]);

        Technicien::find($this->technicien_affectation)->plaques()->syncWithoutDetaching($this->deleteList);
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Plaques affectés avec succès.']);
        $this->resetInputs();
    }

    public function export()
    {
        return (new PlaqueExport())->download('Plaques_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
        $this->emit('success');
    }
    
    public function sync()
    {
        $clients = Client::where('city_id', 12)->get();
        $plaques = Plaque::with('city')->get();

        try {
            DB::beginTransaction();
            foreach ($clients as $item) {
                preg_match('/\d{2}\.\d\.\d{2}/', $item->address, $plaq_sp);
                foreach ($plaques as $p) {
                    if ($p->code_plaque == $plaq_sp[0]) {
                        Client::find($item->id)->update([
                            'plaque_id' => $p->id,
                            'city_id' => $p->city_id,
                        ]);
                    }
                }
            }
            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Plaque Synchroniser avec succès.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function render()
    {
        $plaques = Plaque::withCount('clients')->with('city')
            ->where('code_plaque', 'LIKE', '%' . $this->plaque_name . '%')->orWhereHas('city',function($query){
                $query->where('name','LIKE','%' . $this->plaque_name . '%');
            })
            ->paginate(25);

        $cities = City::get(['name', 'id']);
        return view('livewire.backoffice.plaques-page', compact('plaques', 'cities'))->layout('layouts.app', [
            'title' => 'Plaques',
        ]);
    }
}
