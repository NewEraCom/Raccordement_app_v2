<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Affectation;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Technicien;
use OneSignal;
use App\Models\Notification;

class ControleQaulitePage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $start_date, $end_date, $status, $search;

    public $selectedItems = [], $technicien_affectation;

    public function updatingSearch()
    {
        $this->resetPage();
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
            $technicien =Technicien::find($this->technicien_affectation);
            $filedsh['include_player_ids'] = [$technicien->player_id];
            $message = $count > 1 ? $count . ' clients vous ont été affectés.' : 'Un client vous a été affecté.';
            OneSignal::sendPush($filedsh, $message);
            Notification::create([
                'uuid' => Str::uuid(),
                'title' => 'Affectation',
                'data' => $message,
                'user_id' => $technicien->user_id,
            ]);
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

    public function render()
    {
        $data = [
            'en_cours' => Affectation::with('client')->whereHas('client', function ($query) {
                $query->where('flagged', true);
            })->where('status', 'En cours')->count(),
            'planifie' => Affectation::with('client')->whereHas('client', function ($query) {
                $query->where('flagged', true);
            })->where('status', 'Planifié')->count(),
            'bloque' => Affectation::with('client')->whereHas('client', function ($query) {
                $query->where('flagged', true);
            })->where('status', 'Bloqué')->count(),
            'termine' => Affectation::with('client')->whereHas('client', function ($query) {
                $query->where('flagged', true);
            })->where('status', 'Terminé')->count(),
        ];


        $clients = Affectation::with('client')->whereHas('client', function ($query) {
            $query->where('flagged', true);
        })->when($this->status, function ($query) {
            $query->where('status', 'like', $this->status);
        })->when($this->start_date && $this->end_date,function($query){
            $query->whereBetween('created_at',[Carbon::parse($this->start_date)->startOfDay(),Carbon::parse($this->end_date)->endOfDay()]);
        })->when($this->search,function($query){
            $query->whereHas('client',function($query){
                $query->where('name','like','%'.$this->search.'%')->orWhere('sip','like','%'.$this->search.'%')->orWhere('phone_no','like','%'.$this->search.'%')->orWhereHas('city',function($query){
                    $query->where('name','like','%'.$this->search.'%');
                });
            });
        })->orderBy('affectations.created_at', 'desc')->paginate(10);


        $techniciens = Technicien::with('user','soustraitant')->get();
        return view('livewire.backoffice.controle-qaulite-page', compact('clients', 'data','techniciens'))->layout('layouts.app', ['title' => 'Controle de Qualité']);
    }
}
