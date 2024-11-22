<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Affectation;
use App\Models\AffectationHistory;
use App\Models\Client;
use Livewire\Component;

class ProfileClientPage extends Component
{
    public $client;

    public function mount($client)
    {
        $this->client = Client::with(['technicien','affectations'])->find($client);
    }

    public function render()
    {
        $initialMarkers = [
            [
                'position' => [
                    'lat' => 28.625485,
                    'lng' => 79.821091
                ],
                'draggable' => true
            ],
        ];

        $affe = Affectation::with('history')->where('client_id',$this->client->id)->withTrashed()->get();
        return view('livewire.backoffice.profile-client-page',compact('initialMarkers','affe'))->layout('layouts.app', [
            'title' => $this->client->name,
        ]);
    }
}
