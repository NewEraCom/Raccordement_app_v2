<?php

namespace App\Http\Livewire\Sav;

use App\Exports\ClientSav;
use App\Imports\ClientsImport;
use App\Exports\SavClientExport;
use App\Exports\SavExport;
use App\Models\Affectation;
use App\Models\City;
use App\Models\Blocage;
use App\Models\BlocageSav;
use App\Models\Client;
use App\Models\ClientSav as ModelsClientSav;
use App\Models\Plaque;
use App\Models\SavClient;
use App\Models\savhistory;
use App\Models\SavTicket;
use App\Models\Soustraitant;
use App\Models\Technicien;
use App\Services\web\ClientSavService;
use App\Services\web\ClientsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel; 

class ClientSavPage extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $client_name = '', $client_sip = '', $client_status = '', $technicien = '', $start_date = '', $end_date = '';
    public $client_id = '', $selectedItems = [] ,$searchTerm = ''; // Declare the search term
    public $file;
    public $new_login_internet, $new_activites, $new_description, $new_type_prob;
    public $technicien_affectation, $cause, $resetPage = false;
    public $soustraitant_affectation ;

    public $new_debit, $new_sip, $new_phone, $new_name, $new_id, $new_type, $new_offre, $new_routeur;
    public $e_address, $e_debit, $e_sip, $e_phone, $e_name, $e_id, $e_city, $e_type, $e_offre, $e_routeur, $e_login_internet, $e_activites, $e_description, $e_type_prob;
    public $search, $status_client, $causeDeblocage;
    public $deblocage_start_date, $deblocage_end_date;
    public $new_id_case1, $new_network_access1, $new_line_number1, $new_full_name1, $new_contact_number1, $new_service_activities1,$new_address1, $new_comment1 ,$new_city_id1 , $new_dmd_date1,$new_plaque1;
    public $new_id_case, $new_network_access, $new_line_number, $new_full_name, $new_contact_number, $new_service_activities,$new_address, $new_comment ,$new_city_id,$new_dmd_date,$new_plaque;
    public $filteredSousTraitant = [], $sousTraitant; // Filtered list
    public $plaques , $searchPlaque;
    public $filteredPlaques = [], $selectedPlaque = null;
    
   




    public function export()
    {
        $this->emit('success');

        return (new ClientSav($this->technicien, $this->start_date, $this->end_date))->download('clients_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
    }

    public function delete()
    {
        Client::find($this->client_id)->delete();
        Affectation::where('client_id', $this->client_id)->delete();

        SavTicket::where('client_id', $this->client_id)->delete();

        $this->client_id = null;
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Client supprimé avec succès.']);
    }

    public function deleteAll()
    {
        Client::whereIn('id', $this->selectedItems)->delete();
        Affectation::whereIn('client_id', $this->selectedItems)->delete();
        
        SavTicket::whereIn('client_id', $this->selectedItems)->delete();

        $this->selectedItems = [];
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Clients supprimés avec succès.']);
    }



    public function affectation()
    {
        $this->validate([
            'soustraitant_affectation' => 'required',
            'selectedItems' => 'required',
        ], [
            'soustraitant_affectation.required' => 'Veuillez choisir un Sous-traitant pour continuer.',
            'selectedItems.required' => 'Veuillez choisir au moins un client pour continuer.',
        ]);

        try {

            DB::beginTransaction();
            $count = 0;
            foreach ($this->selectedItems as $item) {
                $client = SavClient::find($item);
                $affectation = SavTicket::updateOrCreate(
                    [
                        'client_id' => $item,
                        'id_case' => $client->n_case,
                    ],
                    [
                        'status' => 'Affecté',
                        'soustraitant_id' => $this->soustraitant_affectation,
                        'technicien_id' => null,
                        'affected_by' => Auth::user()->id,
                        'service_activity' => $client->service_activities,
                    ]
                );
                if ($client) {
                    $client->update([
                        'status' => 'Affecté',  // Properly update statusSav
                    ]);
                }
                Savhistory::create([
                    'savticket_id' => $affectation->id,
                    'technicien_id' => null,
                    'soustraitant_id' => $this->soustraitant_affectation ,
                    'status' => 'Affecté',
                    'description' => 'Affectation du ticket au Soustraitant',
                ]);

                // if ($this->selectedTech != null) {
                //     $affectation->update([

                //         'technicien_id' => $this->selectedTech,

                //     ]);
            //    }
                // if ($this->selectedTech) {
                //     # code...
                // }
                $count++;
            }

            DB::commit();

            $this->selectedItems = [];
            $this->soustraitant_affectation = null;
            $this->cause = '';
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Client affecté avec succès.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            Log::channel('error')->error('Function Affectation in AffectationsPage.php : ' . $th->getMessage());
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
        }
    }


    public function edit()
    {
        $data = $this->validate([
            'new_id_case' => 'required',
            'new_network_access' => 'required',
           // 'new_line_number' => 'required',
            'new_full_name' => 'required',
            'new_city_id' => 'required',
            'new_contact_number' => 'required',
            'new_service_activities' => 'required',
            'new_address' => 'required',
            'new_comment' => 'required',
        ]);
        Log::info($this->client_id);
        Log::info( $data);
        $address = $this->new_address;
        $gps = ClientsService::mapSurvey($this->new_plaque1);
        if (isset($gps->latitude) && isset($gps->longitude)) {
            $lat = $gps->latitude;
            $lng = $gps->longitude;
        } else {
            Log::error('Failed to fetch GPS coordinates', ['address' => $address, 'gps' => $gps]);
            // Handle the error appropriately, e.g., set default values or show an error message
            $lat = null;
            $lng = null;
        }
        $client = ModelsClientSav::find($this->client_id);
        $client->update([
            'n_case' => $data['new_id_case'] ?? '0',
            // 'login' => $data['new_network_access'],
            // 'sip' => $data['new_line_number'],
            'sip' => $data['new_network_access'],
            'address' => $data['new_address'],
            'new_city_id' => $data['new_city_id'],
            'client_name' => $data['new_full_name'],
            'contact' => $data['new_contact_number'],
            'comment' => $data['new_comment'],
            'service_activities' => $data['new_service_activities'],
            'lat' => $lat,
            'lng' => $lng,
      
        ]);
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectation effectuée avec succès.']);
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
        return ClientSavService::importAuto();
    }

    public function relance()
    {
        try {
            DB::beginTransaction();

            SavClient::find($this->client_id)->update([
                'status' => 'Saisie',
                'cause' => $this->cause,
                'technicien_id' => null,
            ]);


            $affectation = SavTicket::where('client_id', $this->client_id)->first();
            if ($affectation != null) {
                BlocageSav::where('sav_ticket_id', $affectation->id)->delete();
               $affectation->delete();
            }
            Savhistory::create([
                'savticket_id' => $affectation->id,
                'technicien_id' => null,
                'status' => 'Saisie',
                'description' => 'Relance du ticket',
            ]); 
         
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
   
    public function Insert()
    {

        $validatedData = $this->validate([
            'new_id_case1' => 'required|string|max:255',
            'new_network_access1' => 'required|string|max:255',
           // 'new_line_number1' => 'required|string|max:255',
            'new_dmd_date1'=>'required|date',
            'new_full_name1' => 'required|string|max:255',
            'new_contact_number1' => 'required|string|max:15',
            'new_service_activities1' => 'required|string|max:255',
            'new_address1' => 'required|string|max:500',
            'new_comment1' => 'nullable|string|max:1000',
             'new_city_id1' => 'required|exists:cities,id',
            'new_plaque1' => 'required|string|max:255'
        ]);
    
        $address = $this->new_address1;
        Log::info('Fetching GPS coordinates for address: ' . $address);

        

        $gps = ClientsService::mapSurvey($this->new_plaque1);
        if (isset($gps->latitude) && isset($gps->longitude)) {
            $lat = $gps->latitude;
            $lng = $gps->longitude;
        } else {
            Log::error('Failed to fetch GPS coordinates', ['address' => $address, 'gps' => $gps]);
            // Handle the error appropriately, e.g., set default values or show an error message
            $lat = null;
            $lng = null;
        }
                // Log the plaque code being searched
        Log::info('Searching for plaque with code: ' . $this->new_plaque1);
        
        $plaque = Plaque::where('code_plaque', $this->new_plaque1)->first();
        
        // Log the result of the plaque search
        Log::info('Plaque found: ', ['plaque' => $plaque]);
        
        if (!$plaque) {
            // Log that the default plaque is being used
            Log::info('Using default plaque for city_id 12');
            $plaque = Plaque::where('city_id', 12)->first();
        }
        
        // ModelsClientSav::create([
        //     'n_case' => $this->new_id_case1,
        //     'login' => $this->new_network_access1,
        //     'sip' => $this->new_line_number1,
        //     'address' => $this->new_address1,
        //     'client_name' => $this->new_full_name1,
        //     'contact' => $this->new_contact_number1,
        //     'date_demande' => $this->new_dmd_date1,
        //     'city_id' => $this->new_city_id1,
        //     'plaque_id' => $plaque->id,
        //     'lat' => $lat,
        //     'lng' => $lng,
        //     'status' => 'Saisie',
        //     'created_by' => auth()->user()->id,
        //     'comment' => $this->new_comment1,
        //     'service_activities' => $this->new_service_activities1,
        // ]);
$clientSav = new SavClient();
$clientSav->n_case = $this->new_id_case1;
//$clientSav->login = $this->new_network_access1;
//$clientSav->sip = $this->new_line_number1;
$clientSav->sip = $this->new_network_access1;
$clientSav->address = $this->new_address1;
$clientSav->client_name = $this->new_full_name1;
$clientSav->contact = $this->new_contact_number1;
$clientSav->date_demande = $this->new_dmd_date1;
$clientSav->city_id = $this->new_city_id1;
$clientSav->plaque_id = $plaque->id;
$clientSav->lat = $lat;
$clientSav->lng = $lng;
$clientSav->status = 'Saisie';
$clientSav->created_by = auth()->user()->id;
$clientSav->comment = $this->new_comment1;
$clientSav->service_activities = $this->new_service_activities1;
$clientSav->save();
      
    
        // Réinitialiser les champs du formulaire
        $this->reset([
            'new_id_case1',
            'new_network_access1', 
           // 'new_line_number1',
            'new_address1',
            'new_dmd_date1',
            'new_full_name1', 
            'new_contact_number1',
            'new_comment1',
            'new_service_activities1',
            'new_city_id1', // Reset the city field as well
        ]);

        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Client ajouté avec succès']);
    
    }

    public function deleteSavClient()
    {
        ModelsClientSav::find($this->client_id)->delete();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Sav est supprimé avec succès.']);
    }
    public function setClient($id){

        $SavClient = ModelsClientSav::find($id);
        
        // Assurez-vous que le client existe avant de l'assigner aux variables
        if ($SavClient) {
            // Assignation des propriétés Livewire avec les valeurs du SavClient
            $this->client_id = $id;                             // Assurez-vous de l'id du SavClient
            $this->new_id_case = $SavClient->n_case;               // ID CASE
         //   $this->new_network_access = $SavClient->login;         // Accès réseau (login)
         $this->new_network_access = $SavClient->sip;              // N° de ligne (sip)
            $this->new_address = $SavClient->address;              // Adresse
            $this->new_full_name = $SavClient->client_name;        // Nom complet du SavClient
            $this->new_contact_number = $SavClient->contact;       // Numéro de contact
            $this->new_comment = $SavClient->comment;              // Commentaire
            $this->new_service_activities = $SavClient->service_activities; // Activités de service
            $this->new_dmd_date = $SavClient->date_demande;        // Date demande
            $this->new_city_id = $SavClient->city_id;              // ID de la ville
            $this->new_plaque = $SavClient->plaque->code_plaque; // Plaque
        }
    }



    public function add()
    {   
        $this->validate([
            'new_name' => 'required',
            'new_address' => 'required',
            'new_sip' => 'required',
            'new_id' => 'required',
            'new_id_case' => 'required',
            'new_type' => 'required',
            // 'new_description' => 'required',
            // 'new_debit' => 'required',
            // 'new_routeur' => 'required',
            'new_type_prob' => 'required'
        ]);

        DB::beginTransaction();
        $address = $this->new_address;
        $array_code = Plaque::where('is_ppi', 1)->pluck('code_plaque')->toArray();
        $tech = null;
        $cityIds = [];
        try {
            preg_match('/\d{2}\.\d\.\d{2}\.\d{1,3}/', $address, $code);
            preg_match('/\d{2}\.\d\.\d{2}/', $address, $plaq_sp);
            if (in_array($plaq_sp[0], $array_code)) {
                $tech = 91;
            }
            preg_match('/\d{2}\.\d\.\d{2}/', $this->new_address, $plaque); 
            $plaque = Plaque::with('city')->where('code_plaque', $plaque[0])->first();

            $client = Client::firstOrCreate(
                [
                    'name' => ucfirst(strtolower(trim($this->new_name))), 
                ],
                [
                    'uuid' => Str::uuid(),
                    'client_id' => $this->new_id,
                    'name' => ucfirst(strtolower(trim($this->new_name))),
                    'lat' => 0,
                    'lng' => 0,
                    'statusSav' => 'Down',
                    'plaque_id' => $plaque != null ? $plaque->id : 114,
                    'city_id' => $plaque != null ?  $plaque->city->id : 12,
                    'technicien_id' => $tech == null ? null : $tech,
                    'address' => $this->new_address,
                    'debit' => $this->new_debit ?? 0,
                    'sip' => $this->new_sip,
                    'phone_no' => $this->new_phone,
                    'status' => '-',
                    'created_by' => auth()->user()->id,
                    'promoteur' => $tech == null ? 0 : 1,
                    'type' => $this->new_type,

                ]
            );


            $ticket = SavTicket::create([
                'client_id' => $client->id,
                'id_case' => $this->new_id_case,
                'type_prob' => $this->new_type_prob,
                'description' => $this->new_description,
                    'service_activity' => $this->new_type_prob,
                'debit' => $this->new_debit,
                'service_activity' => $this->new_activites,
                'type' => $this->new_type_prob
            ]);

            Savhistory::create([
                'savticket_id' => $ticket->id,
                'technicien_id' => null,
                'status' => 'Down',
                'description' => 'Création du ticket',
            ]);

            $cityIds[] = $client->city_id;

            DB::commit();

            /*$techniciens = Technicien::whereHas('cities', function ($query) use ($cityIds) {
                $query->whereIn('city_id', $cityIds);
            })->get();
            $techniciensWithMultipleCities = collect();
            foreach ($techniciens as $technicien) {
                if ($technicien->cities->count() > 1) {
                    foreach ($technicien->cities as $city) {
                        $techniciensWithMultipleCities->push($technicien->replicate()->setRelation('cities', collect([$city])));
                    }
                } else {
                    $techniciensWithMultipleCities->push($technicien);
                }
            }
            foreach ($techniciensWithMultipleCities as $technicien) {
                $fieldsh['include_player_ids'] = [$technicien->player_id];
                $notificationMsgi = 'Nouveaux clients disponibles dans votre zone.';
                OneSignal::sendPush($fieldsh, $notificationMsgi);
            }*/

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

    public function exportToCsv(){
        try {
        $this->emit('success');
        return (new SavExport($this->technicien, $this->start_date, $this->end_date))->download('Ticket_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
    } catch (\Throwable $th) {
        dd($th->getMessage());
    }
    }
    public function mount()     
{
    $this->sousTraitant = Soustraitant::all();
    $this->filteredSousTraitant = $this->sousTraitant; // Initialize with all subcontractors
    $this->filteredPlaques = Plaque::with('city')
    ->where('status', 1)
    ->take(6) // Limit results to 20
    ->get();
   // $this->filteredPlaques = $this->plaques;
}
public function updatedSearchPlaque($value)
{
    // Dynamically filter plaques based on the search term
    $this->filteredPlaques = Plaque::with('city')
        ->where('code_plaque', 'like', '%' . $value . '%')
        ->orWhereHas('city', function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        })
        ->take(6) // Limit results
        ->get();
}
public function selectPlaque($code_plaque)
{
    $this->new_plaque1 = $code_plaque; // Store the selected plaque code
    $this->searchPlaque = $code_plaque; // Reflect the selected value in the search input
}


    public function updatedSearchTerm()
    {
        if (!empty($this->searchTerm)) {
            $this->filteredSousTraitant = $this->sousTraitant->filter(function ($item) {
                return stripos($item->name, $this->searchTerm) !== false;
            });
        } else {
            $this->filteredSousTraitant = $this->sousTraitant; // Reset to full list if no search term
        }
    }
    



    public function render()
    {

        $savClients = SavTicket::whereNotNull('status')->whereDate('created_at',now())->get();
        $client_Affecte = Client::where('statusSav','Affecté')->get();
        $clientBloque = SavTicket::where('status','Bloqué')->get();
        $kpisData = [
            'Sav_Client' => $savClients->count(),
            'Client_Affecte' => $client_Affecte->count(),
            'Client_Bloque' => $clientBloque->count(),
        ];

        $clientsCount = 0;
     $filteredPlaques = $this->filteredPlaques;
        $clients = ClientSavService::getClients($this->search, $this->client_status, $this->start_date, $this->end_date);
        $problem = 0;
        //$clients = SavClient::orderBy('date_demande','desc')->paginate(15);  //ClientSavService::index($this->start_date, $this->end_date, $this->search, $this->client_status)->paginate(15);
        $clientsCount = SavClient::count();
        $data = ClientSavService::getClientsSavStatistic();
        $techniciens = Technicien::with('user')->get();
        $this->sousTraitant = Soustraitant::all();
        if (empty($this->searchTerm)) {
            $this->filteredSousTraitant = $this->sousTraitant;
        }
        $cities = City::get(['id', 'name']);
        $blocages = Blocage::groupBy('cause')->get('cause');


        return view('livewire.sav.client-sav-page', compact(['clients', 'techniciens', 'cities', 'clientsCount', 'problem', 'blocages','kpisData','filteredPlaques']), ['data' => $data])->layout('layouts.app', [
            'title' => 'Clients',
        ]);
    }
}
