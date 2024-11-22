<?php

namespace App\Http\Livewire\Controller;

use App\Mail\ControlleFeedback;
use Livewire\Component;
use App\Models\Client;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\ControlerClient;
use Illuminate\Support\Facades\Mail; 

class PlanificationPage extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search,$client_status,$start_date,$end_date;
    public $comment, $planification_time, $planification_date;

    public $feedback_blocage,$client_id;

    public function feedback(){
        $this->validate([
            'feedback_blocage' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $client = Client::find($this->client_id);

            $comm = ControlerClient::create([
                'client_id' => $this->client_id,
                'note' => $this->feedback_blocage,
            ]);

            $client->update([
                'controler_client_id' => $comm->id,
            ]);

            DB::commit();

            Mail::to(['a.chahid@neweracom.ma'])->send(new ControlleFeedback($client, $this->feedback_blocage));

            $this->feedback_blocage = $this->client_id = null;
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Votre commentaire a été envoyé.']);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
        }
    }
    public function render()
    {
        $planification = Client::where('flagged', true)
            ->whereHas('affectations', function ($query) {
                $query->where('status', 'Planifié')->orWhere('status', 'Terminé')->orWhere('status', 'En cours')->orWhere('status', 'Bloqué');
            })
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $searchTerm = '%' . $this->search . '%';
                    $query->where('name', 'like', $searchTerm)
                        ->orWhere('sip', 'like', $searchTerm)
                        ->orWhere('phone_no', 'like', $searchTerm)
                        ->orWhereHas('city', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', $searchTerm);
                        });
                });
            })->when($this->client_status, function ($query) {
                $query->whereHas('affectations', function ($query) {
                    $query->where('status', $this->client_status);
                });
            })->when($this->start_date && $this->end_date,function($query){
                $query->whereHas('affectations', function ($query) {
                    $query->whereBetween('created_at',[Carbon::parse($this->start_date)->startOfDay(),Carbon::parse($this->end_date)->endOfDay()]);
                });
            })
            ->paginate(15);

        return view('livewire.controller.planification-page', compact('planification'))->layout('layouts.app', ['title' => 'Planification']);
    }
}
