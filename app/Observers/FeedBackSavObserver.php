<?php

namespace App\Observers;

use App\Models\FeedBackSav;
use App\Models\SavClient;
use App\Models\SavTicket;

class FeedBackSavObserver
{
    /**
     * Handle the FeedBackSav "created" event.
     *
     * @param  \App\Models\FeedBackSav  $feedBackSav
     * @return void
     */
    public function created(FeedBackSav $feedBackSav)
    {
        $savTiket_id = $feedBackSav->sav_ticket_id ;
        $savTicket = SavTicket::find($savTiket_id);
        if ($savTicket) {
            $savTicket->update(['status' => 'Validé']);
            }
            $clientId = $savTicket->client_id;
    
            // Update the statut of the client in the SavClient table
            if ($clientId) {
                $client = SavClient::find($clientId);
                if ($client) {
                    $client->update(['status' => 'Validé']);
                }
            }
    }

    /**
     * Handle the FeedBackSav "updated" event.
     *
     * @param  \App\Models\FeedBackSav  $feedBackSav
     * @return void
     */
    public function updated(FeedBackSav $feedBackSav)
    {
        //
    }

    /**
     * Handle the FeedBackSav "deleted" event.
     *
     * @param  \App\Models\FeedBackSav  $feedBackSav
     * @return void
     */
    public function deleted(FeedBackSav $feedBackSav)
    {
        //
    }

    /**
     * Handle the FeedBackSav "restored" event.
     *
     * @param  \App\Models\FeedBackSav  $feedBackSav
     * @return void
     */
    public function restored(FeedBackSav $feedBackSav)
    {
        //
    }

    /**
     * Handle the FeedBackSav "force deleted" event.
     *
     * @param  \App\Models\FeedBackSav  $feedBackSav
     * @return void
     */
    public function forceDeleted(FeedBackSav $feedBackSav)
    {
        //
    }
}
