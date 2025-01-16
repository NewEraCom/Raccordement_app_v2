<?php

namespace App\Observers;

use App\Models\SavClient;
use App\Models\Savhistory;
use App\Models\SavTicket;
use App\Models\Technicien;
use Illuminate\Support\Facades\Log;

class SavTicketObserver
{
    /**
     * Handle the SavTicket "created" event.
     *
     * @param  \App\Models\SavTicket  $savTicket
     * @return void
     */
    public function created(SavTicket $savTicket)
    {
        //
    }

    /**
     * Handle the SavTicket "updated" event.
     *
     * @param  \App\Models\SavTicket  $savTicket
     * @return void
     */
    public function updated(SavTicket $savTicket)
    {
        $text = null;
    
        if ($savTicket->isDirty('status') && $savTicket->status === 'Planifié') {
            $text = $savTicket->planification_date;
    
            $clientId = $savTicket->client_id;
    
            // Update the statut of the client in the SavClient table
            if ($clientId) {
                $client = SavClient::find($clientId);
                if ($client) {
                    $client->update(['status' => 'Planifié']);
                }
            }
    
            // Fetch technicien and client information
            $technicien = Technicien::find($savTicket->technicien_id);
            $technicienName = $technicien ? $technicien->user->getFullName() : 'N/A';
            $client = SavClient::find($clientId);
            $clientSip = $client ? $client->sip : 'N/A';
    
            // Include the planification date in the description
            $description = sprintf(
                'Le technicien %s a planifié un rendez-vous avec le client %s le %s.',
                $technicienName,
                $clientSip,
                \Carbon\Carbon::parse($text)->format('d/m/Y à H:i')
            );
    
            // Create the Savhistory entry
            $savHistory = Savhistory::create([
                'savticket_id' => $savTicket->id,
                'technicien_id' => $savTicket->technicien_id,
                'soustraitant_id' => $savTicket->soustraitant_id,
                'status' => $savTicket->status,
                'cause' => $text,
                'description' => $description,
            ]);
        }



         // Check if the status has changed to "Validé"
    if ($savTicket->isDirty('status') && $savTicket->status === 'Validé') {
        // Fetch client and technicien details
        $client = SavClient::find($savTicket->client_id);
        $technicien = Technicien::find($savTicket->technicien_id);

        $technicienName = $technicien ? $technicien->user->getFullName() : 'N/A';
        $clientSip = $client ? $client->sip : 'N/A';

        // Generate description for the validation
        $description = sprintf(
            'Le technicien %s a validé le ticket SAV pour le client %s.',
            $technicienName,
            $clientSip
        );

        // Create the Savhistory entry
        Savhistory::create([
            'savticket_id' => $savTicket->id,
            'technicien_id' => $savTicket->technicien_id,
            'soustraitant_id' => $savTicket->soustraitant_id,
            'status' => $savTicket->status,
            'description' => $description,
        ]);

        // Optionally, update the client status
        if ($client) {
            $client->update(['status' => 'Validé']);
        }
    }
    }
    

    /**
     * Handle the SavTicket "deleted" event.
     *
     * @param  \App\Models\SavTicket  $savTicket
     * @return void
     */
    public function deleted(SavTicket $savTicket)
    {
        //
    }

    /**
     * Handle the SavTicket "restored" event.
     *
     * @param  \App\Models\SavTicket  $savTicket
     * @return void
     */
    public function restored(SavTicket $savTicket)
    {
        //
    }

    /**
     * Handle the SavTicket "force deleted" event.
     *
     * @param  \App\Models\SavTicket  $savTicket
     * @return void
     */
    public function forceDeleted(SavTicket $savTicket)
    {
        //
    }
}
