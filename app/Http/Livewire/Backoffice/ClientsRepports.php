<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Client;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ClientsRepports extends Component
{
    public $search = '', $client;

    public function valider()
    {
        $this->validate([
            'client' => 'required',
        ]);

        try {
            DB::beginTransaction();
            Client::find($this->client)->update([
                'phase_three' => true
            ]);
            $this->emit('success');
            $this->dispatchBrowserEvent('contenrChanged', ['item' => 'Votre commentaire a été envoyé avec succès']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function refuser()
    {
        $this->validate([
            'client' => 'required',
        ]);

        try {
            DB::beginTransaction();
            Client::find($this->client)->update([
                'phase_three' => 3
            ]);
            $this->emit('success');
            $this->dispatchBrowserEvent('contenrChanged', ['item' => 'Votre commentaire a été envoyé avec succès']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function render()
    {
        $clients = Client::with('city')->when($this->search, function ($query) {
            $query->where('sip', 'like', '%' . $this->search . '%');
        })->whereNotNull('phase_two')->get();
        return view('livewire.backoffice.clients-repports', compact('clients'))->layout('layouts.app', ['title' => 'Rapports clients']);
    }
}
