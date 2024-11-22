<?php

namespace App\Http\Livewire\Backoffice;

use App\Exports\RouteurExport;
use App\Imports\RouteursImport;
use App\Models\Routeur;
use App\Services\web\RouteursService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class RouteursPage extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $sn_gpon, $sn_mac, $selectedItems = [], $file, $routeur_id;
    public $client, $client_name, $routeur_status, $start_date, $end_date, $routeur;

    public $e_sn_gpon, $e_sn_mac, $e_routeur_id;

    public function add()
    {
        $this->validate([
            'sn_gpon' => 'required',
            'sn_mac' => 'required',
        ]);

        Routeur::create([
            'uuid' => Str::uuid(),
            'sn_gpon' => $this->sn_gpon,
            'sn_mac' => $this->sn_mac,
        ]);

        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Routeur ajouté avec succès.']);
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new RouteursImport, $this->file);

        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Routeurs importés avec succès.']);
    }

    public function setRouteur(Routeur $routeur)
    {
        $this->e_routeur_id = $routeur->id;
        $this->e_sn_gpon = $routeur->sn_gpon;
        $this->e_sn_mac = $routeur->sn_mac;
    }

    public function edit()
    {
        $this->validate([
            'e_sn_gpon' => 'required',
        ]);

        Routeur::find($this->e_routeur_id)->update([
            'sn_gpon' => $this->e_sn_gpon,
            'sn_mac' => $this->e_sn_mac,
        ]);

        $this->e_sn_gpon = $this->e_sn_mac = null;

        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Routeur modifie avec success.']);
    }

    public function delete()
    {
        Routeur::find($this->routeur_id)->delete();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Routeur supprimé avec succès.']);
    }

    public function deleteSelected()
    {
        Routeur::whereIn('id', $this->selectedItems)->delete();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Routeurs supprimés avec succès.']);
    }

    public function export()
    {
        $this->emit('success');
        return (new RouteurExport())->download('ROUTEURS_' . date('d_m_Y_H_i_s') . '.xlsx');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Routeurs exportés avec succès.']);
    }

    public function activer()
    {
        try {
            DB::beginTransaction();
            $this->validate([
                'routeur_id' => 'required',
            ]);
    
            Routeur::find($this->routeur_id)->update([
                'status' => 1,
            ]);
    
            DB::commit();    
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Routeur activer avec success.']);
        } catch (\Throwable $th) {
            DB::rollback();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Routeur activer avec success.']);
        }
    }

    public function render()
    {
        $routeurs = RouteursService::returnRouteurs($this->routeur_status, $this->start_date, $this->end_date, $this->routeur, $this->client)->paginate(25);
        $data = RouteursService::kpisRouteurs();
        return view('livewire.backoffice.routeurs-page', compact(['routeurs', 'data']))->layout('layouts.app', ['title' => 'Routeurs']);
    }
}
