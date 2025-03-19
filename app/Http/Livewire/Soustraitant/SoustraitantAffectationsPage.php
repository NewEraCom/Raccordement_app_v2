<?php

namespace App\Http\Livewire\Soustraitant;

use App\Exports\AffectationSoustraitant;

use Livewire\Component;
use App\Models\Affectation;
use App\Models\Client;
use App\Models\Soustraitant;
use App\Models\Technicien;
use App\Services\web\ClientsService;
use App\Traits\SendSmsTrait;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SoustraitantAffectationsPage extends Component
{
    use WithPagination;
    use SendSmsTrait;
    protected $paginationTheme = 'bootstrap';

    public $start_date, $end_date, $technicien, $client_status, $client_sip;
    public $selectedTechnicianName; 
    public $technicien_affectation =false;  
    public $searchTerm  = '';
    public $selectedItems = [];
    public $client; // To hold the client details
    public $search_term = '';
      

    public function export(){
        $this->emit('success');
        return (new AffectationSoustraitant($this->technicien,$this->start_date, $this->end_date,Auth::user()->soustraitant_id))->download('Affectation_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
    }


    // Method to set the client details based on the client ID
    public function setClient($clientId)
    {
        $this->client = Client::with('city')->find($clientId);

        // Check if client exists, if not, handle the case (optional)
        if (!$this->client) {
            session()->flash('error', 'Client not found!');
        }
    }

    public function affectation()
    {
        $data = $this->validate([
            'technicien_affectation' => 'required',
            'selectedItems' => 'required',
        ], [
            'technicien_affectation.required' => 'Veuillez choisir un Sous-traitant pour continuer.',
            'selectedItems.required' => 'Veuillez choisir au moins un client pour continuer.',
        ]);
        $return = ClientsService::assigneTechnicien($data);

        $this->selectedItems = [];
        $technician = Technicien::find($this->technicien_affectation);
        $this->sendSms('+212'.$technician->user->phone_no, 'Bonjour ' . $technician->user->getFullname() . ', vous avez une nouvelle affectation.');
        $this->emit('success');
        if ($return) {
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectation effectuée avec succès.']);
        } else {
            Log::channel('error')->error('Function affectation in ClientsPage.php : ' . $return->getMessage());
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
        }
    }
    public function selectTechnician($technicianId)
    {
        $technician = Technicien::find($technicianId); // Adjust this according to your data model
        $this->technicien_affectation = $technicianId; // Set the selected technician's ID
        $this->selectedTechnicianName = $technician->user->getFullname() . ' (' . $technician->soustraitant->name . ')'; // Store the name of the selected technician
    }
    public function resetTechnician()
    {
        $this->technicien_affectation = null; // Reset the selected technician
        $this->searchTerm = ''; // Optionally clear the search term
    }

    public function render()
    {
        $soustraitant = Soustraitant::find(auth()->user()->soustraitant_id);
        $daily_affectations =  $soustraitant->dailyAffectations->count();
        $affectations = $soustraitant->totalAffectations->count();
        $daily_rdv_clients = $soustraitant->dailyPlanifications->count();
        $daily_blocages_clients = $soustraitant->dailyBlocages->count();
        $clients_done = $soustraitant->totalClientDone->count();
        $techniciens = $soustraitant->techniciens;
        
        // $clients = Affectation::with('client')->whereHas('technicien',function($query){
        //     $query->where('soustraitant_id', auth()->user()->soustraitant_id)->when($this->technicien, function ($query) {
        //         $query->where('technicien_id', $this->technicien);
        //     });
        // })->when($this->start_date && $this->end_date,function($query){
        //     $query->whereBetween('created_at',[Carbon::parse($this->start_date)->startOfDay(),Carbon::parse($this->end_date)->endOfDay()]);
        // })->when($this->client_status,function($query){
        //     $query->where('status', $this->client_status);
        // })->when($this->client_sip,function($query){
        //     $query->whereHas('client',function($q){
        //         $q->where('sip', 'LIKE', '%'.$this->client_sip.'%')->orWhere('phone_no', 'LIKE', '%'.$this->client_sip.'%')->orWhere('name', 'LIKE', '%'.$this->client_sip.'%')->whereHas('city', function ($qe) {
        //             $qe->where('name', 'LIKE', '%'.$this->client_sip.'%');
        //         });  
        //     });
        // })
        // ->orderBy('created_at','DESC')->paginate(15);
       

      
      
        // $clients = Affectation::with('client','technicien')->where('soustraitant_id',$soustraitant->id)
        // ->when($this->start_date && $this->end_date,function($query){
        //     $query->whereBetween('created_at',[Carbon::parse($this->start_date)->startOfDay(),Carbon::parse($this->end_date)->endOfDay()]);
        // })->when($this->client_status,function($query){
        //     $query->where('status', $this->client_status);
        // })->when($this->client_sip,function($query){
        //     $query->whereHas('client',function($q){
        //         $q->where('sip', 'LIKE', '%'.$this->client_sip.'%')->orWhere('phone_no', 'LIKE', '%'.$this->client_sip.'%')->orWhere('name', 'LIKE', '%'.$this->client_sip.'%')->whereHas('city', function ($qe) {
        //             $qe->where('name', 'LIKE', '%'.$this->client_sip.'%');
        //         });  
        //     });
        // })
        // ->orderBy('created_at','DESC')->paginate(15);
       
$clients = Affectation::with('client', 'technicien')
->where('soustraitant_id', $soustraitant->id)
->when($this->search_term, function ($query) {
    $query->whereHas('client', function ($q) {
        $q->where('name', 'LIKE', '%' . $this->search_term . '%')
            ->orWhere('sip', 'LIKE', '%' . $this->search_term . '%')
            ->orWhere('phone_no', 'LIKE', '%' . $this->search_term . '%')
            ->orWhereHas('city', function ($qe) {
                $qe->where('name', 'LIKE', '%' . $this->search_term . '%');
            })
            ->orWhere('address', 'LIKE', '%' . $this->search_term . '%')
            ->orWhere('client_id', 'LIKE', '%' . $this->search_term . '%');
    });
})
->when($this->client_status, function ($query) {
    $query->where('status', $this->client_status);
})
->when($this->technicien, function ($query) {
    $query->where('technicien_id', $this->technicien);
})
->when($this->start_date && $this->end_date, function ($query) {
    $query->whereBetween('created_at', [
        Carbon::parse($this->start_date)->startOfDay(),
        Carbon::parse($this->end_date)->endOfDay()
    ]);
})
->orderByDesc('created_at')
->paginate(15);


        return view('livewire.soustraitant.soustraitant-affectations-page', compact('techniciens', 'clients', 'daily_affectations', 'affectations', 'daily_rdv_clients', 'daily_blocages_clients', 'clients_done'))->layout('layouts.app', ['title' => 'Affectations']);
    }
}
