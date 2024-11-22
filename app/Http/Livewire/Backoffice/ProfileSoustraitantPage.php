<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Soustraitant;
use App\Services\web\SoustraitantService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Str;
use App\Models\MailList;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTechnicienMail;

class ProfileSoustraitantPage extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $soustraitant, $start_date, $end_date,$city_id;

    public $email, $first_name, $last_name, $phone_no;

    public function mount(Soustraitant $soustraitant)
    {
        $this->soustraitant = $soustraitant;
    }

    public function associer()
    {
        $this->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
        ],[
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'L\'email doit être unique',
        ]);

        try {
            DB::beginTransaction();

            $password = trim($this->last_name) . '1234';
            $user = User::create([
                'uuid' => Str::uuid(),
                'email' => strtolower($this->email),
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone_no' => $this->phone_no,
                'password' => bcrypt($password),
                'soustraitant_id' => $this->soustraitant->id,
            ]);

            $user->assignRole('soustraitant');

            //Mail::to(MailList::where([['type','neweracom'],['status',1]])->get('email'))->send(new NewTechnicienMail($user,$password));
            Mail::to(MailList::where([['type','neweracom'],['status',1]])->get('email'))->send(new NewTechnicienMail($user,$password));

            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Soustraitant a été associé avec succès']);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue']);
        }
    }

    public function render()
    {
        $cities = City::get();
        $clients = SoustraitantService::KpisSoustraitant($this->start_date, $this->end_date, $this->soustraitant->id,$this->city_id);
        $allClient = SoustraitantService::returnClientSoustraitant($this->start_date, $this->end_date, $this->soustraitant->id,$this->city_id);
        return view('livewire.backoffice.profile-soustraitant-page', compact(['clients', 'allClient','cities']))->layout('layouts.app', [
            'title' => $this->soustraitant->name,
        ]);
    }
}
