<?php

namespace App\Http\Livewire\Sav;

use App\Exports\AffectationExport;
use App\Exports\SavTicketExport;
use App\Models\Affectation;
use App\Models\AffectationHistory;
use App\Models\Blocage;
use App\Models\Client;
use App\Models\Notification;
use App\Models\Savhistory;
use App\Models\SavTicket;
use App\Models\Soustraitant;
use App\Models\Technicien;
use App\Services\web\AffectationsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use OneSignal;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class SavAffectation extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $start_date = '', $end_date = '', $client_name, $client_sip, $client_status, $technicien;
    public $affectation_id, $selectedItems = [];
    public $sTechniciens , $search;
    public $technicien_affectation, $selectedTech,  $cause, $blocage_type;
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete()
    {
        SavTicket::find($this->affectation_id)->delete();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Sav est supprimé avec succès.']);
    }

    public function deleteAll()
    {
        Affectation::whereIn('id', $this->selectedItems)->delete();
        $this->selectedItems = [];
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectations supprimés avec succès.']);
    }

    public function  updatedTechnicienAffectation()
    {
        $this->sTechniciens = Technicien::where('soustraitant_id', $this->technicien_affectation)->get();
    }
    public function unblock(SavTicket $affectation)
    {
        $affectation->update(([
            'status' => 'En cours',
        ]));
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

                $affectation =  SavTicket::find($item);
                $client = $affectation->client;
                Client::find($affectation->client_id)->update([
                    'statusSav' => 'Affecté',
                ]);

                $affectation->update([
                    'status' => 'En cours',
                    'soustraitant_id' => $this->technicien_affectation,
                    'technicien_id' => null,
                    'affected_by' => Auth::user()->id,
                ]);
                if ($this->selectedTech != null) {
                    $affectation->update([

                        'technicien_id' => $this->selectedTech,

                    ]);
                }
                // if ($this->selectedTech) {
                //     # code...
                // }
                $count++;
            }

            DB::commit();

            $this->selectedItems = [];
            $this->technicien_affectation = null;
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

    public function export()
    {
        return (new SavTicketExport)->download('Ticket_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
    }

    public function relance()
    {
        $this->validate([
            'affectation_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $affectation =  Affectation::find($this->affectation_id);

            $text = 'En cours';

            if ($affectation->declarations->count() != 0) {
                $text = $affectation->status;
            }


            Affectation::find($this->affectation_id)->update([
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
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Client relancé avec succès.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            $this->emit('success');
            Log::channel('error')->error('Function Relance in AffectationsPage.php : ' . $th->getMessage());
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
        }
    }

    public function render()
    {
     $affectations = AffectationsService::getTickets($this->client_name, $this->client_status, $this->technicien)->paginate(10);
        $data = AffectationsService::getSavAffectationsStatistic($this->start_date, $this->end_date);
        $techniciens = Technicien::with('user')->get();
        $this->sTechniciens = Technicien::where('soustraitant_id', $this->technicien_affectation)->get();
        $sousTraitant = Soustraitant::all();
        $blocages = Blocage::groupBy('cause')->get('cause');
        return view('livewire.sav.sav-affectation', compact('data', 'techniciens', 'sousTraitant', 'affectations', 'blocages'))->layout('layouts.app', [
            'title' => 'Affectations',
        ]);
    }
}
