<?php

namespace App\Http\Livewire\Backoffice;

use App\Charts\SoustraitantByCity;
use App\Models\City;
use App\Services\web\CitiesServices;
use Carbon\Carbon;
use Livewire\Component;

class ProfileCityPage extends Component
{

    public $city, $start_date, $end_date;

    public function mount(City $city)
    {
        $this->city = $city;
    }

    public function render()
    {
        $data = CitiesServices::getCityData($this->city->id, [Carbon::parse($this->start_date)->startOfDay(), Carbon::parse($this->end_date)->endOfDay()]);
        $clients = $this->city->clients;
        return view('livewire.backoffice.profile-city-page', compact('data'), ['clients' => json_encode($clients)])->layout('layouts.app', [
            'title' => $this->city->name,
        ]);
    }
}
