<?php

namespace App\Http\Livewire\Backoffice;

use App\Exports\AffectationExport;
use App\Exports\AffectationsAll;
use App\Models\Affectation;
use App\Models\AffectationHistory;
use App\Models\Blocage;
use App\Models\Notification;
use App\Models\Technicien;
use App\Services\web\AffectationsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use OneSignal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Traits\SendSmsTrait;
use Carbon\Carbon;


class AffectationsPage extends Component
{
    use WithPagination;
    use SendSmsTrait;
    protected $paginationTheme = 'bootstrap';

    public $start_date = '', $end_date = '', $client_name, $client_sip, $client_status, $technicien;
    public $affectation_id, $selectedItems = [];
    public $technicien_affectation, $cause, $blocage_type;
    public $searchTerm = '';
    public $selectedTechnicianName; 
    

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function export()
    {
        try {
            $this->emit('success');
            return (new AffectationExport($this->technicien,$this->start_date, $this->end_date))->download('Affectation_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
        } catch (\Throwable $th) {
            dd('Error');
        }
    }

    public function delete()
    {
        Affectation::find($this->affectation_id)->delete();
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectation supprimé avec succès.']);
    }

    public function deleteAll()
    {
        Affectation::whereIn('id', $this->selectedItems)->delete();
        $this->selectedItems = [];
        $this->emit('success');
        $this->dispatchBrowserEvent('contentChanged', ['item' => 'Affectations supprimés avec succès.']);
    }

    public function affectation()
    {
        $this->validate([
            'selectedItems' => 'required',
            'technicien_affectation' => 'required',
        ], [
            'technicien_affectation.required' => 'Veuillez choisir un technicien pour continuer.',
            'selectedItems.required' => 'Veuillez choisir au moins un client pour continuer.',
        ]);

        try {

            DB::beginTransaction();
            $count = 0;
            foreach ($this->selectedItems as $item) {
                $affectation =  Affectation::find($item);
                $affectation->update([
                    'technicien_id' => $this->technicien_affectation,
                    'status' => 'En cours',
                    'affected_by' => Auth::user()->id,
                ]);
                $count++;
            }

            DB::commit();
            $technicien = Technicien::with('user')->find($this->technicien_affectation);
            $filedsh['include_player_ids'] = [$technicien->player_id];
            $message = $count > 1 ? $count . ' clients vous ont été affectés.' : 'Un client vous a été affecté.';
            /* OneSignal::sendPush($filedsh, $message);
            Notification::create([
                'uuid' => Str::uuid(),
                'title' => 'Affectation',
                'data' => $message,
                'user_id' => $technicien->user_id,
            ]); */
            $this->selectedItems = [];
            $this->technicien_affectation = null;
            $this->cause = '';
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Client affecté avec succès.']);

            $this->sendSms('+212'.$technicien->user->phone_no, $message);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            Log::channel('error')->error('Function Affectation in AffectationsPage.php : ' . $th->getMessage());
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Une erreur est survenue.']);
        }
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
        $data = AffectationsService::getAffectationsStatistic($this->client_status, $this->start_date, $this->end_date);
        $techniciens = Technicien::with('user')
        ->whereHas('user', function ($query) {
            $query->where('status', 1); // Ensure that the user's status is 1
        })
        ->get();
        $blocages = Blocage::groupBy('cause')->get('cause');
        $affectations = AffectationsService::getAffectations($this->client_name, $this->client_status, $this->technicien, $this->start_date, $this->end_date, $this->blocage_type)->paginate(10);

        return view('livewire.backoffice.affectations-page',compact('data','techniciens','blocages','affectations'))->layout('layouts.app', [
            'title' => 'Affectations',
        ]);
    }
    // public function selectTechnician($id)
    // {
    //     $this->technicien_affectation = $id;
    //     $technician = Technicien::find($id); // Assuming you have a Technicien model
    //     if ($technician) {
    //         $this->selectedTechnicianName = $technician->user->getFullname(); // Get the full name
    //     }
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
//     public function clearSelection()
// {
//     $this->technicien_affectation = null; // Reset the selected technician
//     $this->searchTerm = ''; // Optionally clear the search term
//     $this->selectedTechnicianName = null; // Reset the displayed name
// }
}
