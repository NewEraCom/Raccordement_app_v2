<?php

namespace App\Http\Livewire\Sav;
use App\Models\City;
use App\Models\User;
use Livewire\Component;

use App\Models\MailList;
use Illuminate\Support\Str;
use App\Models\Soustraitant;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Mail\NewTechnicienMail;
use Ladumor\OneSignal\OneSignal;
use App\Exports\TechnicienExport;
use App\Imports\TechnicienImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TechnicienMailNewAccount;
use App\Models\Technicien;
use App\Services\web\TechniciensService;

class Techniciens extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $first_name, $last_name, $soustraitant_id, $email, $phone_no, $type_tech;
    public $selectedItems = [], $technicien_id;
    public $filtrage_name = '', $start_date = '', $end_date = '', $status = '', $soustraitant_selected = '', $city_selected, $city_id;

    public $e_first_name, $e_last_name, $e_soustraitant_id, $e_email, $e_phone_no, $e_technicien_id,  $e_city_id, $e_city_compteur, $e_password = null;

    public $user_id, $file;

    public function add()
    {
        // dd($this->type_tech);
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'soustraitant_id' => 'required',
            'email' => 'required',
            'city_id' => 'required',
            'phone_no' => 'required',
        ]);


        DB::beginTransaction();


        try {
            $password = Str::random(10);

            $user = User::create([
                'uuid' => Str::uuid(),
                'first_name' => Str::title($this->first_name),
                'last_name' => Str::title($this->last_name),
                'email' => Str::lower($this->email),
                'password' => Hash::make($password),
                'phone_no' => $this->phone_no,
            ]);

            $user->assignRole('technicien');

            $technicien = Technicien::create([
                'soustraitant_id' => $this->soustraitant_id,
                'user_id' => $user->id,
                'type_tech' => $this->type_tech,
                'planification_count' => 5,
            ]);

            $technicien->cities()->attach($this->city_id);


            DB::commit();

            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Technicien a été ajouté avec succès.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            Log::channel('mylog')->error($th->getMessage());
        }
    }

    public function delete()
    {
        Technicien::find($this->technicien_id)->delete();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Technicien supprimé avec succès.']);
    }

    public function deleteAll()
    {
        Techniciens::whereIn('id', $this->selectedItems)->delete();
        $this->selectedItems = [];
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Techniciens supprimé avec succès.']);
    }

    public function setTech($item)
    {
        $this->e_technicien_id = $item['id'];
        $this->e_first_name = $item['user']['first_name'];
        $this->e_last_name = $item['user']['last_name'];
        $this->e_email = $item['user']['email'];
        $this->e_phone_no = $item['user']['phone_no'];
        $this->e_soustraitant_id = $item['soustraitant_id'];

        $this->e_city_id = [12];
    }

    public function update()
    {
        $this->validate([
            'e_first_name' => 'required',
            'e_last_name' => 'required',
            'e_soustraitant_id' => 'required',
            'e_email' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $technicien = Technicien::where('id', $this->e_technicien_id)->first();
            $technicien->update([
                'soustraitant_id' => $this->e_soustraitant_id,

            ]);

            $technicien->cities()->sync($this->e_city_id);

            User::where('id', $technicien->user->id)->first()->update([
                'first_name' => $this->e_first_name,
                'last_name' => $this->e_last_name,
                'email' => Str::lower($this->e_email),
                'phone_no' => $this->e_phone_no,
            ]);

            if ($this->e_password != null) {
                User::where('id', $technicien->user->id)->first()->update([
                    'password' => Hash::make($this->e_password),
                ]);
            }

            DB::commit();

            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Technicien a été modifié avec succès.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function export()
    {
        return (new TechnicienExport($this->filtrage_name, $this->soustraitant_selected, $this->status, $this->start_date, $this->end_date))->download('techniciens.xlsx');
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Technicien .']);
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new TechnicienImport(), $this->file);
        // TODO : Send mail to admin
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => TechnicienImport::getNumImported()  . ' Technicien importé avec succès.']);
    }

    public function disable()
    {
        $status = User::find($this->user_id)->status;

        User::find($this->user_id)->update([
            'status' => !$status,
        ]);

        $phrase = $status ? 'Technicien a été desactiver avec succès.' : 'Technicien a été activer avec succès.';

        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => $phrase]);
    }

    public function refresh()
    {
        $this->validate([
            'technicien_id' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $technicien = Techniciens::find($this->technicien_id);
            $filedsh['include_player_ids'] = [$technicien->player_id];
            $message = 'Votre compte a été déconnecté.';
            OneSignal::sendPush($filedsh, $message);

            $technicien->user->update([
                'device_key' => null,
                'is_online' => false,
            ]);
            $technicien->update([
                'player_id' => null,
            ]);
            DB::commit();

            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Technicien a été rafraichi avec succès.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('mylog')->error($th->getMessage());
        }
    }
    public function render()
    {
        $techniciens = TechniciensService::returnTechniciens($this->filtrage_name, $this->soustraitant_selected, $this->status, $this->start_date, $this->end_date)->paginate(15);
        $data = TechniciensService::kpisTechniciens();
        $soustraitants = Soustraitant::get();
        $soustraitant_list = Soustraitant::get();
        $this->city_selected = City::get(['name', 'id']);

        return view('livewire.sav.techniciens',compact(['techniciens', 'data', 'soustraitants', 'soustraitant_list']))->layout('layouts.app', [
            'title' => 'Techniciens']);
    }
}
