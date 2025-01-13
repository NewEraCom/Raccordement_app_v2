<?php

namespace App\Observers;

use App\Models\BlocageSav;
use App\Models\SavClient;
use App\Models\Savhistory;
use App\Models\SavTicket;

class BlocageSavObserver
{
    /**
     * Handle the BlocageSav "created" event.
     *
     * @param  \App\Models\BlocageSav  $blocageSav
     * @return void
     */
    public function created(BlocageSav $blocageSav)
    {
          // Fetch the related SavTicket
          $savTicket = SavTicket::find($blocageSav->sav_ticket_id);
          $client = $savTicket->client;

          if ($savTicket) {
              // Update the status of the SavTicket to "Bloqué"
              $savTicket->update(['status' => 'Bloqué']);
          }
          $clientId = $savTicket->client_id;

          if ($clientId) {
              // Update the statut of the client in the SavClient table
              $client = SavClient::find($clientId);
              if ($client) {
                  $client->update(['status' => 'Bloqué']);
              }
          }

          Savhistory::create([
            'savticket_id' => $blocageSav->sav_ticket_id,
            'status' => 'Bloqué',
            'description' => 'Blocage du client ' . $client->sip,
            'technicien_id' => $savTicket->technicien_id,
            'soustraitant_id'=> $savTicket->soustraitant_id
        ]);
    }
    /**
     * Handle the BlocageSav "updated" event.
     *
     * @param  \App\Models\BlocageSav  $blocageSav
     * @return void
     */
    public function updated(BlocageSav $blocageSav)
    {
        //
    }

    /**
     * Handle the BlocageSav "deleted" event.
     *
     * @param  \App\Models\BlocageSav  $blocageSav
     * @return void
     */
    public function deleted(BlocageSav $blocageSav)
    {
        //
    }

    /**
     * Handle the BlocageSav "restored" event.
     *
     * @param  \App\Models\BlocageSav  $blocageSav
     * @return void
     */
    public function restored(BlocageSav $blocageSav)
    {
        //
    }

    /**
     * Handle the BlocageSav "force deleted" event.
     *
     * @param  \App\Models\BlocageSav  $blocageSav
     * @return void
     */
    public function forceDeleted(BlocageSav $blocageSav)
    {
        //
    }
}
