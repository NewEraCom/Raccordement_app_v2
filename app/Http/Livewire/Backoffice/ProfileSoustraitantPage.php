<?php

namespace App\Http\Livewire\Backoffice;

use App\Mail\NewStrCreated;
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
use Illuminate\Support\Facades\Log;

class ProfileSoustraitantPage extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $soustraitant, $start_date, $end_date,$city_id;

    public $email, $first_name, $last_name, $phone_no,$password,$cpassword;
    public $search_term = '' ,$search = '';

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
            // Mail::to(MailList::where([['type','neweracom'],['status',1]])->get('email'))->send(new NewTechnicienMail($user,$password));
            Mail::to(['h.jlidat@neweracom.ma'])->send(new NewStrCreated($user, $password));

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
    public function editStr()
    {
        $this->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'nullable|string|min:8',
            'cpassword' => 'nullable|string|min:8|same:password',
        ],[
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'L\'email doit être unique',
            'cpassword.same' => 'Les mots de passe ne correspondent pas',
        ]);

        try {
            DB::beginTransaction();

            Log::info('Nom');
            Log::info($this->first_name);
            Log::info('prenom');
            Log::info($this->last_name);
            Log::info('email');
            Log::info($this->email);
            Log::info('pass');
            Log::info($this->password);


            // $user = User::find($this->soustraitant->user->id);
            $user = User::where('soustraitant_id',$this->soustraitant->id)->first();
            $str = Soustraitant::find($this->soustraitant->id);
            $str->name = $this->first_name . ' ' . $this->last_name;
            $str->save();
            $user->email = strtolower($this->email);
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            if($this->password){
                $user->password = bcrypt($this->password);
            }
            $user->save();


            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Soustraitant a été modifié avec succès']);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue']);
        }
    }
    public function setStr(){

        $user = User::where('soustraitant_id',$this->soustraitant->id)->first();
        $str = Soustraitant::find($this->soustraitant->id);
        
        // Assurez-vous que le client existe avant de l'assigner aux variables
        if ($user && $str) {
            // Assignation des propriétés Livewire avec les valeurs du SavClient
            $this->email = $user->email;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;

        }
    }
    public function toggleStatus()
{
    try {
        DB::beginTransaction();

        $user = User::where('soustraitant_id', $this->soustraitant->id)->first();
        if ($user) {
            $user->status = $user->status == 1 ? 0 : 1;
            $user->save();
        }

        DB::commit();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Le statut du sous-traitant a été mis à jour avec succès']);
    } catch (\Throwable $th) {
        DB::rollback();
        $this->emit('error');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue']);
    }
}

    public function render()
    {
        $user = User::where('soustraitant_id',$this->soustraitant->id)->first();
        $cities = City::get();
        $clients = SoustraitantService::KpisSoustraitant($this->start_date, $this->end_date, $this->soustraitant->id,$this->city_id);
        $allClient = SoustraitantService::returnClientSoustraitant($this->start_date, $this->end_date, $this->soustraitant->id,$this->city_id,$this->search);
        $allClientSAV = SoustraitantService::returnClientSoustraitantSAV($this->start_date, $this->end_date, $this->soustraitant->id, $this->search_term);
        return view('livewire.backoffice.profile-soustraitant-page', compact(['clients', 'allClient','cities','allClientSAV','user']))->layout('layouts.app', [
            'title' => $this->soustraitant->name,
        ]);
    }
}
