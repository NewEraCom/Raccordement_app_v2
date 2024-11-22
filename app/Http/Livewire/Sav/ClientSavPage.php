<?php

namespace App\Http\Livewire\Sav;

use App\Exports\ClientSav;
use App\Imports\ClientsImport;
use App\Exports\SavClientExport;
use App\Models\Affectation;
use App\Models\City;
use App\Models\Blocage;
use App\Models\Client;
use App\Models\Plaque;
use App\Models\SavClient;
use App\Models\savhistory;
use App\Models\SavTicket;
use App\Models\Technicien;
use App\Services\web\ClientSavService;
use App\Services\web\ClientsService;
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
    public $client_id = '', $selectedItems = [];
    public $file;
    public $new_id_case,  $new_login_internet, $new_activites, $new_description, $new_type_prob;
    public $technicien_affectation, $cause, $resetPage = false;

    public $new_address, $new_debit, $new_sip, $new_phone, $new_name, $new_id, $new_type, $new_offre, $new_routeur;
    public $e_address, $e_debit, $e_sip, $e_phone, $e_name, $e_id, $e_city, $e_type, $e_offre, $e_routeur, $e_login_internet, $e_activites, $e_description, $e_type_prob;
    public $search, $status_client, $causeDeblocage;
    public $deblocage_start_date, $deblocage_end_date;

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
        $this->e_login_internet = $client->login_internet;
        $this->e_activites = $client->activites;
        $this->e_description = $client->savTicket->last()->description;
        $this->e_city = $client->city_id;
        $this->e_type_prob = $client->savTicket->last()->type;
    }

    public function affectation()
    {
        $data = $this->validate([
            'technicien_affectation' => 'required',
            'selectedItems' => 'required',
        ], [
            'technicien_affectation.required' => 'Veuillez choisir un technicien pour continuer.',
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
            'e_phone' => 'required',
            'e_type' => 'required',
            'e_type_prob' => 'required',
            'e_description' => 'required',
            'e_debit' => 'required',
            'e_routeur' => 'required',
        ]);

        if (ClientSavService::edit($data, $this->client_id)) {
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectation effectuée avec succès.']);
        } else {
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectation effectuée avec succès.']);
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
        return ClientSavService::importAuto();
    }

    public function relance()
    {
        try {
            DB::beginTransaction();

            Client::find($this->client_id)->update([
                'status' => '-',
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
            return (new SavClientExport())->download('Ticket_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
        $problem = 0;
        $clients = SavClient::orderBy('date_demande','desc')->paginate(15);  //ClientSavService::index($this->start_date, $this->end_date, $this->search, $this->client_status)->paginate(15);
        $clientsCount = SavClient::count();
        $data = ClientSavService::getClientsSavStatistic();
        $techniciens = Technicien::with('user')->get();
        
        $cities = City::get(['id', 'name']);
        $blocages = Blocage::groupBy('cause')->get('cause');


        return view('livewire.sav.client-sav-page', compact(['clients', 'techniciens', 'cities', 'clientsCount', 'problem', 'blocages','kpisData']), ['data' => $data])->layout('layouts.app', [
            'title' => 'Clients',
        ]);
    }
}
