<?php

namespace App\Http\Livewire\Sav;

use App\Models\Affectation;
use App\Models\Client;
use App\Models\SavTicket;
use Livewire\Component;

class SavViewScreen extends Component
{


  public $client;

  public function mount(Client $client)
  {
    $this->client = $client;
  }

  public function render()
  {
    $affe = Affectation::with('history')->where('client_id',$this->client->id)->withTrashed()->get();
    return view('livewire.sav.sav-view-screen',compact('affe'))->layout('layouts.app', [
      'title' => $this->client->name,
    ]);
  }
}
