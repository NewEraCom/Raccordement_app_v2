<?php

namespace App\Http\Livewire\Backoffice;

use Livewire\Component;
use App\Models\Client;
use App\Models\Declaration;
use App\Models\FeedbackRapport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Technicien;
use App\Models\Notification;
use App\Models\Validation;
use Illuminate\Support\Str;
use OneSignal;

class ReportsPreviewPage extends Component
{

    public $client, $checkboxs = [],$feedback,$note,$commentaire = [];

    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function valider()
    {
        try {
            DB::beginTransaction();
            Client::find($this->client->id)->update([
                'phase_one' => true,
            ]);
            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Le rapport a été validé.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function refuser()
    {
        try {
            $declaration = ['Test Signal', 'Image Splitter', 'Image PBO avant', 'Image PBO après', 'Image PBI avant', 'Image PBI après'];
            $validation = ['Image test debit via cable', 'Image test debit via wifi', 'Image Etiquetage', 'Image de routeur/tel', 'Image PV'];
            $feedbackValidation = null;
            $feedbackDeclaration = null;

            DB::beginTransaction();

            foreach ($this->checkboxs as $value) {
                if (in_array($value, $declaration)) {
                    $feedbackDeclaration .= $value . '-';
                }
                if (in_array($value, $validation)) {
                    $feedbackValidation .= $value . '-';
                }
            }
            
            if ($feedbackDeclaration) {
                Declaration::where('affectation_id',$this->client->affectations->last()->id)->update([
                    'feedback_bo' => $feedbackDeclaration,
                ]);
            }if ($feedbackValidation){
                Validation::where('affectation_id',$this->client->affectations->last()->id)->update([
                    'feedback_bo' => $feedbackValidation,
                ]);
            }
            $technicien =Technicien::find($this->client->technicien_id);
            $filedsh['include_player_ids'] = [$technicien->player_id];
            $message = 'Veuillez vérifier la déclaration et la validation du client '.$this->client->sip.'.';
            OneSignal::sendPush($filedsh, $message);
            Notification::create([
                'uuid' => Str::uuid(),
                'title' => 'Modification',
                'data' => $message,
                'user_id' => $technicien->user_id,
            ]);

            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Votre commentaire a été envoyé.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function feedback(){
        $this->validate([
            'commentaire' => 'required',
            'note' => 'required|string',
        ]);

        try {
         

            DB::beginTransaction();
            Client::find($this->client->id)->update([
                'phase_two' => true,
            ]);

            FeedbackRapport::create([
                'client_id' => $this->client->id,
                'feedback' => implode(', ', $this->commentaire),
                'note' => $this->note,
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();
            $this->emit('success');
            $this->dispatchBrowserEvent('contentChanged', ['item' => 'Votre commentaire a été envoyé.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backoffice.reports-preview-page')->layout('layouts.app', [
            'title' => 'Rapport : ' . $this->client->name,
        ]);
    }
}
