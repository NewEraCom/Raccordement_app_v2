<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CitiesPage extends Component
{
    use WithPagination;

    public $search = '', $city_id, $city_name, $compteur, $edit_city_name, $e_compteur;


    public function add()
    {
        $this->validate([
            'city_name' => 'required',
        ]);

        City::create([
            'uuid' => Str::uuid(),
            'name' => $this->city_name,
            'compteur' => $this->compteur,
        ]);

        $this->city_name = '';
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Ville ajouté avec succès.']);
    }

    public function setCity(City $city)
    {
        $this->city_id = $city->id;
        $this->edit_city_name = $city->name;
        $this->e_compteur = $city->compteur;    
    }

    public function edit()
    {
        $this->validate([
            'edit_city_name' => 'required',
        ]);

        City::find($this->city_id)->update([
            'name' => $this->edit_city_name,
            'compteur' => $this->e_compteur,

        ]);

        $this->city_name = '';
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Ville modifié avec succès.']);
    }

    public function delete()
    {
        City::find($this->city_id)->delete();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Ville supprimé avec succès.']);
    }

    public function render()
    {
        $cities = City::withCount(['plaques', 'clients', 'techniciens', 'declarations', 'validations', 'blocages'])->where('name', 'LIKE', '%' . $this->search . '%')->paginate(15);
        return view('livewire.backoffice.cities-page', compact('cities'))->layout('layouts.app', [
            'title' => 'Villes',
        ]);
    }
}
