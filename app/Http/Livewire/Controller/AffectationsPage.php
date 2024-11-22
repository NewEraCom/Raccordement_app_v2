<?php

namespace App\Http\Livewire\Controller;

use App\Exports\ControllerQualiteExport;
use App\Mail\ClientDecline;
use App\Mail\ScheduleClient;
use Livewire\Component;
use App\Models\Affectation;
use App\Models\Client;
use App\Models\ControlerClient;
use App\Services\web\ClientsService;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AffectationsPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $start_date, $end_date, $client_status, $text, $client_feedback, $planification_date, $planification_time, $custom_feedback, $comment, $client_id;

    public function edit()
    {
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Vous avez planifié un client']);
    }

    public function export(){
        return (new ControllerQualiteExport($this->start_date,$this->end_date))->download('ControllerQualite.xlsx');
    }

    public function planifier()
    {
        $this->validate([
            'planification_date' => 'required',
            'planification_time' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $client = Client::find($this->client_id);
            $old_technicien = $client->technicien;
            $old_blocage = $client->affectations->last()->blocages->last()->cause;


            if ($this->comment) {
                $comm = ControlerClient::create([
                    'client_id' => $this->client_id,
                    'note' => $this->comment,
                ]);
            }

            $client->update([
                'status' => 'Affecté',
                'technicien_id' => 97,
                'flagged' => true,
                'controler_client_id' => $comm->id ?? null,
            ]);

            Affectation::where('client_id', $this->client_id)->delete();

            Affectation::create([
                'uuid' => Str::uuid(),
                'client_id' => $this->client_id,
                'technicien_id' => 97,
                'status' => 'Planifié',
                'planification_date' => $this->planification_date . ' ' . $this->planification_time . ':00',
            ]);
            $new_date = $this->planification_date . ' ' . $this->planification_time . ':00';

            DB::commit();
            Mail::to(['k.oubellouch@neweracom.ma','r.akraou@neweracom.ma','h.jlidat@neweracom.ma','a.chahid@neweracom.ma','a.khyari@neweracom.ma','b.chabab@neweracom.ma','a.benyassine@neweracom.ma','y.laarabi@neweracom.ma'])->send(new ScheduleClient($client, $old_technicien, $old_blocage,$new_date));

            $this->planification_date = null;
            $this->planification_time = null;
            $this->client_id = null;

            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Vous avez planifié un client']);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function feedback()
    {
        $this->validate([
            'client_feedback' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $client = Client::find($this->client_id);

            $comm = ControlerClient::create([
                'client_id' => $this->client_id,
                'note' => $this->comment,
                'comment' => $this->client_feedback,
                'second_comment' => $this->custom_feedback,
            ]);

            $client->update([
                'flagged' => true,
                'controler_client_id' => $comm->id,
            ]);

            //Mail::to(['a.chahid@neweracom.ma','a.khyari@neweracom.ma','b.chabab@neweracom.ma','a.benyassine@neweracom.ma','y.laarabi@neweracom.ma'])->send(new ClientDecline($client, $old_technicien, $old_blocage));
            DB::commit();

            $this->client_feedback = null;
            $this->comment = null;
            $this->custom_feedback = null;
            $this->client_id = null;

            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Votre commentaire a été envoyé.']);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function render()
    {
        $data = ClientsService::kpisController();
        $affectations = Affectation::with('client', 'technicien')->where('status', 'Bloqué')->whereHas('blocages', function ($q) {
            $q->whereIn('cause', ['Client  a annulé sa demande', 'Injoignable/SMS', 'Indisponible']);
        })->when($this->client_status, function ($query) {
            $query->whereHas('blocages', function ($query) {
                $query->where('cause', $this->client_status)->where('resolue', false);
            });
        })->when($this->start_date && $this->end_date, function ($query) {
            $query->whereHas('blocages', function ($query) {
                $query->whereBetween('blocages.created_at', [Carbon::parse($this->start_date)->startOfDay(), Carbon::parse($this->end_date)->endOfDay()])->where('resolue', false);
            });
        })->when($this->text, function ($query) {
            $query->whereHas('client', function ($q) {
                $q->where('sip', 'LIKE', '%' . $this->text . '%')->orWhere('phone_no', 'LIKE', '%' . $this->text . '%')->orWhereHas('city', function ($q) {
                    $q->where('name', 'LIKE', '%' . $this->text . '%');
                })->orWhereHas('plaque', function ($q) {
                    $q->where('code_plaque', 'LIKE', '%' . $this->text . '%');
                });
            });
        })->orderBy('created_at', 'ASC')->paginate(15);

        return view('livewire.controller.affectations-page', compact('affectations', 'data'))->layout('layouts.app', ['title' => 'Clients']);
    }
}
