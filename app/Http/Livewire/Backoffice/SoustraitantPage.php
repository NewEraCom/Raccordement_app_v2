<?php

namespace App\Http\Livewire\Backoffice;

use App\Mail\NewStrCreated;
use App\Models\Soustraitant;
use App\Models\SoustraitantStock;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;

class SoustraitantPage extends Component
{

    public $name,$soustraitant_name;


    public function add(){
        // $password = Str::random(10);
        $this->validate([
            'soustraitant_name' => 'required',
        ]);

        $soustraitant = Soustraitant::create([
            'uuid' => Str::uuid(),
            'name' => $this->soustraitant_name,
        ]);
        SoustraitantStock::create([
            'soustraitant_id' => $soustraitant->id,
            'f680' => 0,
            'f6600' => 0,
            'pto' => 0,
            'cable' => 0,
            'fix' => 0,
            'jarretiere' => 0,
            'splitter' => 0,
            'racco' => 0,
        ]);
        // $user = User::create([
        //     'uuid' => Str::uuid(),
        //     'first_name' => $this->soustraitant_name,
        //     'last_name' => '-',
        //     'email' => $this->soustraitant_name . '@neweracom.ma',
        //     'password' => Hash::make($password),
        // ]);
        // $user->assignRole('soustraitant');

        // Mail::to(['h.jlidat@neweracom.ma'])->send(new NewStrCreated($user, $password));

        $this->soustraitant_name = '';
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Soustraitant ajouté avec succès.']);
    }

    public function render()
    {
        $soustraitant = Soustraitant::withCount(['techniciens','clients'])->where('name','LIKE','%'.$this->name.'%')->get();
        return view('livewire.backoffice.soustraitant-page',compact('soustraitant'))->layout('layouts.app', [
            'title' => 'Soustraitant',
        ]);
    }
}
