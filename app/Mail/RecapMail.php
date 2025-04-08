<?php

namespace App\Mail;

use App\Models\Affectation;
use App\Models\Blocage;
use App\Models\Client;
use App\Models\Declaration;
use App\Models\Validation;
use App\Models\Pipe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecapMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $todays = today()->subDay();
        $new_clients = Client::whereDate('created_at',  today()->subDay())->count();
        $clients_declarations = Declaration::whereDate('created_at',  today()->subDay())->count();
        $clients_validations = Affectation::where('status', 'Terminé')->whereHas('declarations', function ($query) {
            $query->whereDate('created_at', today()->subDay());
        })->count();

        $client_no_validations = Blocage::whereIn('cause',['Retard d\'activation','PORTA','Pas de ticket','Activation bloque','Demenagement','Id errone'])->whereDate('created_at',today()->subDay())->where('resolue',0)->count();
        $blocage_technique = Blocage::whereDate('created_at', today()->subDay())->where('resolue', false)->whereIn('cause', ['Câble transport dégradés', 'Manque Cable transport', 'Gpon saturé', 'Non Eligible', 'Cabel transport saturé', 'Splitter saturé', 'Pas Signal','Gpon satur'])->count();
        $blocage_clients = Blocage::whereDate('created_at', today()->subDay())->where('resolue', false)->whereIn('cause', ['Demande en double', 'Adresse erronée non déployée','Adresse erronée déployée', 'Blocage de passage coté appartement', 'Blocage de passage coté Syndic', 'Client a annulé sa demande', 'Contact Erronee', 'Indisponible', 'Injoignable/SMS', 'Manque ID'])->count();
        $blocage_cancel_client = Blocage::whereDate('created_at', today()->subDay())->where('resolue', false)->where('cause', 'Client a annulé sa demande')->count();
        $blocage_injoignable = Blocage::whereDate('created_at','>=',now()->subDays(2))->where('resolue', false)->where('cause', 'Injoignable/SMS')->count();
        $clients_planned = Affectation::whereDate('planification_date',  today())->count();
        $clients_planned_all = Affectation::where('status', 'Planifié')->count();
        $pipe_orange = Pipe::whereDate('created_at', today()->subDay())->get('total');
        $pipe_app = Client::where('status', 'Saisie')->count() + Affectation::where('status', 'Bloqué')->count() + Affectation::where('status', 'Terminé')->count() + Affectation::where('status', 'Planifié')->count();
        $client_horsPlaque = Client::where('status', 'Hors Plaque')->count();
        return $this->markdown('emails.recap-mail', compact('client_no_validations','todays', 'new_clients', 'clients_declarations', 'clients_validations', 'blocage_technique', 'blocage_clients', 'blocage_cancel_client', 'blocage_injoignable', 'clients_planned', 'clients_planned_all', 'pipe_orange', 'pipe_app','client_horsPlaque'))->subject('Récapitulatif de l\'activité de raccordement (' . date('d-m-Y', strtotime(today()->subDay())) . ')')->from("declaration@neweracom.ma", "Neweraconnect");
    }
}
