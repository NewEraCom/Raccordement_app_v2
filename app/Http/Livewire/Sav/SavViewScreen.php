<?php

namespace App\Http\Livewire\Sav;

use App\Models\Affectation;
use App\Models\Client;
use App\Models\SavClient;
use App\Models\SavTicket;
use Illuminate\Support\Facades\Log;
use Livewire\Component;


class SavViewScreen extends Component
{
    public $client;

    public function mount(SavClient $client)
    {
        $this->client = $client; // Fetch client profile from the `sav_client` table
    }

    public function render()
    {
        // Fetch all tickets related to this client
        $affe = SavTicket::
            with(['savhistories.soustraitant', 'technicien', 'sousTraitant','affectedBy','blocages.pictures','clientSav.plaque'])
            ->where('client_id',$this->client->id)
            ->withTrashed() // Include soft-deleted tickets if applicable
            ->get();
        // Log::info($affe);
        $clientt = SavClient::with('plaque')->find($this->client->id);
        Log::info($clientt);
        

        return view('livewire.sav.sav-view-screen', compact('affe','clientt'))
            ->layout('layouts.app', [
                'title' => $this->client->client_name,
            ]);
    }
}
