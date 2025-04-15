<?php

namespace App\Http\Livewire\Backoffice;

use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use App\Imports\PipeImport;
use App\Models\Affectation;
use App\Models\City;
use App\Models\Blocage;
use App\Models\Client;
use App\Models\Pipe;
use App\Models\Plaque;
use App\Models\Soustraitant;
use App\Models\Technicien;
use Carbon\Carbon;
use App\Services\web\ClientsService;
use App\Services\web\ClientsSupervisorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use OneSignal;
use App\Models\Notification;


class ClientsPage extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $client_name = '', $client_sip = '', $client_status = '', $technicien = '', $start_date = '', $end_date = '', $city_id = '', $plaque_id = '';
    public $client_id = '', $selectedItems = [];
    public $file;
    public $technicien_affectation, $cause, $resetPage = false;

    public $new_address, $new_debit, $new_sip, $new_phone, $new_name, $new_id, $new_type, $new_offre, $new_routeur;
    public $e_address, $e_debit, $e_sip, $e_phone, $e_name, $e_id, $e_city, $e_type, $e_offre, $e_routeur;
    public $search, $status_client, $causeDeblocage;
    public $deblocage_start_date, $deblocage_end_date;
    public $searchTerm = '';
    public $selectedTechnicianName; 
    public $selectedSoustraitant ;
    public $soustraitants = [];
    public $soustraitant_affectation = false; // Determines if a subcontractor is assigned
    public $selectedSoustraitantName ;
    public $search_term = '';
    public $affectation_id;

    public function mount()
    {
        $this->city_id = request()->query('city', '');
        $this->plaque_id = request()->query('plaque', '');
    }
    public function export()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $this->emit('success');
        return (new ClientsExport($this->technicien, $this->start_date, $this->end_date,$this->plaque_id,$this->city_id))->download('clients_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
    }

    public function delete()
    {
        Client::find($this->client_id)->delete();
        Affectation::where('client_id', $this->client_id)->delete();
        $this->client_id = null;
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Client supprimé avec succès.']);
    }

    public function deleteAll()
    {
        Client::whereIn('id', $this->selectedItems)->delete();
        Affectation::whereIn('client_id', $this->selectedItems)->delete();
        $this->selectedItems = [];
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Clients supprimés avec succès.']);
    }

    public function setClient($id)
    {
        $client = Client::find($id);
        $this->client_id = $id;
        $this->e_name = $client->name;
        $this->e_id = $client->client_id;
        $this->e_address = $client->address;
        $this->e_debit = $client->debit;
        $this->e_sip = $client->sip;
        $this->e_phone = $client->phone_no;
        $this->e_type = $client->type;
        $this->e_offre = $client->offre;
        $this->e_routeur = $client->routeur_type;
        $this->e_debit = $client->debit;
    }
// the right one created by chahid 
    // public function affectation()
    // {
    //     $data = $this->validate([
    //         'technicien_affectation' => 'required',
    //         'selectedItems' => 'required',
    //     ], [
    //         'technicien_affectation.required' => 'Veuillez choisir un technicien pour continuer.',
    //         'selectedItems.required' => 'Veuillez choisir au moins un client pour continuer.',
    //     ]);

    //     $return = ClientsService::newAffecttion($data);

    //     $this->selectedItems = [];
    //     $this->emit('success');
    //     if ($return) {
    //         $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectation effectuée avec succès.']);
    //     } else {
    //         Log::channel('error')->error('Function affectation in ClientsPage.php : ' . $return->getMessage());
    //         $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
    //     }
    // }


    public function affectation()
    {
        $data = $this->validate([
            'soustraitant_affectation' => 'required',
            'selectedItems' => 'required',
        ], [
            'soustraitant_affectation.required' => 'Veuillez choisir un Sous-traitant pour continuer.',
            'selectedItems.required' => 'Veuillez choisir au moins un client pour continuer.',
        ]);
        $return = ClientsService::newAffecttion($data);

        $this->selectedItems = [];
        $this->emit('success');
        if ($return) {
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectation effectuée avec succès.']);
        } else {
            Log::channel('error')->error('Function affectation in ClientsPage.php : ' . $return->getMessage());
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
        }
    }
    public function edit()
    {
        $data = $this->validate([
            'e_address' => 'required',
            'e_name' => 'required',
            'e_sip' => 'required',
            'e_id' => 'required',
            'e_phone' => 'required',
            'e_type' => 'required',
            'e_offre' => 'required',
            'e_debit' => 'required',
            'e_routeur' => 'required',
        ]);

        $return = ClientsService::edit($data, $this->client_id);
        $this->emit('success');
        if ($return) {
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Modification avec success']);
        } else {
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Un erreur est survenue.']);
        }
    }

    public function importManual()
    {
        $this->validate([
            'file' => 'required',
        ], [
            'file.required' => 'Le fichier est obligatoire',
        ]);


        try {
            Excel::import(new ClientsImport, $this->file);
            $this->file = null;
            Log::channel('mylog')->info(ClientsImport::getNumImported() . ' Clients have been imported');
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => ClientsImport::getNumImported() . ' Clients importés avec succès.']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
            Log::channel('importation')->error('Function importManual in ClientsPage.php : ' . $th);
        }
    }

    public function importAuto()
    {
        //try {
        $return = ClientsService::importAuto();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => $return != 0 ? $return . ' Clients importés avec succès.' :  'Aucun client importé.']);
        /* } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
            Log::channel('importation')->error('Function importAuto in ClientsPage.php : ' . $th);
        } */
    }

    public function relance()
    {
        try {
            DB::beginTransaction();

            Client::find($this->client_id)->update([
                'status' => 'Créé',
                'cause' => $this->cause,
                'technicien_id' => null,
            ]);

            $affectation = Affectation::where('client_id', $this->client_id)->first();
            if ($affectation != null) {
                Blocage::where('affectation_id', $affectation->id)->delete();
                $affectation->delete();
            }

            DB::commit();
            $this->cause = null;
            $this->client_id = null;
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => ' Clients rejouer avec succès.']);
        } catch (\Throwable $th) {
            DB::rollback();
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
            Log::channel('error')->error('Function Relance in ClientsPage.php : ' . $th->getMessage());
        }
    }

   

    public function debloque()
    {
        $this->validate([
            'affectation_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $affectation = Affectation::find($this->affectation_id);

            $text = 'En cours';

            // if ($affectation->declarations->count() != 0) {
            //     $text = $affectation->status;
            // }

            $affectation->update([
                'status' => $text,
            ]);

            Blocage::where('affectation_id', $this->affectation_id)->update([
                'resolue' => 1,
            ]);

            DB::commit();

            $technicien = Technicien::find($affectation->technicien_id);
            $filedsh['include_player_ids'] = [$technicien->player_id];
            $message = 'Le blocage de client ' . $affectation->client->sip . ' a été débloquer.';
            OneSignal::sendPush($filedsh, $message);
            Notification::create([
                'uuid' => Str::uuid(),
                'title' => 'Deblocage',
                'data' => $message,
                'user_id' => $technicien->user_id,
                'affectation_id' => $this->affectation_id
            ]);
            
            $this->affectation_id = null;
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Client débloquer avec succès.']);
           
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('error')->error('Function Relance in ClientsPage.php : ' . $th->getMessage());
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
        }
    }

    public function add()
    {
        $this->validate([
            'new_address' => 'required',
            'new_name' => 'required',
            'new_debit' => 'required',
            'new_sip' => 'required',
            'new_id' => 'required',
            'new_phone' => 'required',
            'new_type' => 'required',
            'new_offre' => 'required',
            'new_routeur' => 'required',
        ]);

        DB::beginTransaction();
        $address = $this->new_address;
        $array_code = Plaque::where('is_ppi', 1)->pluck('code_plaque')->toArray();
        $tech = null;
        $cityIds = [];
        try {
            preg_match('/\d{2}\.\d\.\d{2}\.\d{1,3}/', $address, $code);
            $gps = ClientsService::mapSurvey($code[0]);
            $lat = $gps->latitude;
            $lng = $gps->longitude;

            preg_match('/\d{2}\.\d\.\d{2}/', $address, $plaq_sp);
            if (in_array($plaq_sp[0], $array_code)) {
                $tech = 91;
            }        
            preg_match('/\d{2}\.\d\.\d{2}/', $this->new_address, $plaque);
            $plaque = Plaque::with('city')->where('code_plaque', $plaque[0])->first();

            $client = Client::firstOrCreate(
                [
                    'sip' => $this->new_sip,
                    'offre' => $this->new_offre,
                    'address' => $this->new_address,
                ],
                [
                    'uuid' => Str::uuid(),
                    'client_id' => $this->new_id,
                    'type' => $this->new_type,
                    'name' => ucfirst(strtolower(trim($this->new_name))),
                    'lat' => $lat,
                    'lng' => $lng,
                    'plaque_id' => $plaque != null ? $plaque->id : 114,
                    'city_id' => $plaque != null ?  $plaque->city->id : 12,
                    'technicien_id' => $tech == null ? null : $tech,
                    'address' => $this->new_address,
                    'debit' => $this->new_debit,
                    'sip' => $this->new_sip,
                    'phone_no' => $this->new_phone,
                    'offre' => $this->new_offre,
                    'routeur_type' => $this->new_routeur,
                    'status' =>  $tech == null ? 'Créé' : 'Affecté',
                    'created_by' => auth()->user()->id,
                    'promoteur' => $tech == null ? 0 : 1,
                ]
            );

            $cityIds[] = $client->city_id;

            DB::commit();
                        
            $this->new_address = null;
            $this->new_name = null;
            $this->new_debit = null;
            $this->new_sip = null;
            $this->new_id = null;
            $this->new_phone = null;
            $this->new_offre = null;
            $this->new_type = null;
            $this->new_routeur = null;
            $this->emit('success');
            $message = $client->wasRecentlyCreated ? 'Client ajouté avec succès.' : 'Client existe déjà.';
            $this->dispatchBrowserEvent('contentChanged', ['item' => $message]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('mylog')->error('Function add in ClientsPage.php : ' . $e->getMessage());
            dd($e->getMessage());
            $this->emit('error');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
        }
    }

    public function pipe()
    {
        set_time_limit(0);
        try {
            DB::beginTransaction();
            Excel::import(new PipeImport, $this->file);
            Pipe::create([
                'total' => PipeImport::getNumImported(),
            ]);
            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Clients importés avec succès.']);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            Log::channel('mylog')->error('Function pipe in ClientsPage.php : ' . $th->getMessage());
        }
    }

    public function rejouerBlocage()
    {

        try {
            $array_code = Plaque::where('is_ppi', 1)->pluck('code_plaque')->toArray();
            $blocages = Blocage::where('cause', '=', $this->causeDeblocage)->where('resolue', 0)->whereBetween('created_at', [Carbon::parse($this->deblocage_start_date)->startOfDay(), Carbon::parse($this->deblocage_end_date)->endOfDay(),])->where('deleted_at', null)->get();
            foreach ($blocages as $item) {
                $tech = null;
                if ($item->affectation != null) {
                    DB::beginTransaction();
                    $client = Client::find($item->affectation->client_id);
                    if (in_array($client->plaque->code_plaque, $array_code)) {
                        $tech = 91;
                    }
                    Client::find($item->affectation->client_id)->update([
                        'status' =>  $tech == null ? 'Saisie' : 'Affecté',
                        'technicien_id' => $tech == null ? null : $tech,
                    ]);

                    Affectation::where('client_id', $item->affectation->client_id)->delete();
                    Blocage::find($item->id)->delete();
                    DB::commit();
                }
            }
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => ' Clients rejouer avec succès.']);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            Log::channel('mylog')->error('Function rejouerBlocage in ClientsPage.php : ' . $th->getMessage());
        }
    }
    public function render()
    {
        $clientsCount = 0;
        $problem = 0;
        switch (Auth::user()->roles->first()->name) {
            case 'admin':
                $clients = ClientsService::getClients(
                    $this->search_term, 
                    $this->client_status, 
                    $this->technicien, 
                    $this->start_date, 
                    $this->end_date, 
                    null  // Retirez $this->client_id ici pour éviter la perte de données
                )
                ->when($this->city_id, function($query) {
                    return $query->where('city_id', $this->city_id);
                })
                ->when($this->plaque_id, function($query) {
                    return $query->where('plaque_id', $this->plaque_id);
                })
                ->paginate(15);
                break;
            case 'supervisor':
                $clientsCount = ClientsSupervisorService::countClient($this->start_date, $this->end_date);
                $clients = ClientsSupervisorService::index($this->start_date, $this->end_date, $this->search, $this->client_status)->paginate(15);
                $problem = ClientsSupervisorService::blocage($this->start_date, $this->end_date);
                break;
            default:
                $clients = ClientsService::getClients(
                    $this->client_name, 
                    $this->client_sip, 
                    $this->client_status, 
                    $this->technicien, 
                    $this->start_date, 
                    $this->end_date,
                    $this->affectation
                )->paginate(15);
                break;
        }
    
        $data = ClientsService::getClientsStatistic();
        $techniciens = Technicien::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 1);
            })
            ->get();
            $this->soustraitants = Soustraitant::where('status', 1)->get(['id', 'name']);
        $cities = City::get(['id', 'name']);
        $blocages = Blocage::groupBy('cause')->get('cause');
    
        return view('livewire.backoffice.clients-page', [
            'clients' => $clients,
            'techniciens' => $techniciens,
            'cities' => $cities,
            'clientsCount' => $clientsCount,
            'problem' => $problem,
            'blocages' => $blocages,
            'data' => $data,
            'soustraitants' => $this->soustraitants,
        ])->layout('layouts.app', [
            'title' => 'Clients',
        ]);
    }


    // public function selectTechnician($id)
    // {
    //     $this->technicien_affectation = $id;
    //     $technician = Technicien::find($id); // Assuming you have a Technicien model
    //     $this->selectedTechnicianName = $technician->user->getFullname(); // Get the full name
    //     $this->searchTerm = ''; // Clear the search term
    // }
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
    public function selectSoustraitant($id)
    {

        $soustraitant = Soustraitant::find($id);
        $this->soustraitant_affectation = $id;
        $this->selectedSoustraitantName = $soustraitant->name;  // Store the name of the selected subcontractor
    }
    public function resetSoustraitant(){
        $this->soustraitant_affectation = null;
        $this->searchTerm = ''; 
    }

 

  
}
