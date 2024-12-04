<?php

namespace App\Observers;

use App\Mail\DeclarationMail;
use App\Models\Affectation;
use App\Models\AffectationHistory;
use App\Models\Declaration;
use App\Models\MailList;
use DOMXPath;
use Illuminate\Support\Facades\Mail;
use App\Models\Client;
use App\Models\SoustraitantStock;

class DeclarationObserver
{
    /**
     * Handle the Declaration "created" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function created(Declaration $declaration)
    {
        $affectation = Affectation::find($declaration->affectation_id);

        Client::find($affectation->client_id)->update([
            'status' => 'Déclaré',
        ]);

        $affectation->update([
            'status' => 'En cours',
        ]);

        AffectationHistory::create([
            'affectation_id' => $affectation->id,
            'technicien_id' => $affectation->technicien_id,
            'status' => 'Déclaré',
        ]);

        // // DECREMENT STOCK
        $soustraitant = SoustraitantStock::where('soustraitant_id', $affectation->technicien->soustraitant_id)->first();
        $soustraitant->decrement('pto', $declaration->pto); // Decrement the value by 1
        $soustraitant->decrement('cable', $declaration->cable_metre); // Decrement the value by 1
        if ($declaration->sn_telephone != null) {
            $soustraitant->decrement('fix', 1);
        }
        $soustraitant->decrement('jarretiere', 1); // Decrement the value by 1

        if ($affectation->client->routeur_type == 'ZTE F6600') {
            $soustraitant->decrement('f6600', 1);
        } else {
            $soustraitant->decrement('f680', 1);
        }
        $soustraitant->save();



        if ($affectation->client->sip != 'TEST') {
            Mail::to(MailList::where([['type', 'orange'], ['status', 1]])->get('email'))->cc(MailList::where([['type', 'declaration'], ['status', 1]])->get('email'))->send(new DeclarationMail($declaration));
        }
    }

    /**
     * Handle the Declaration "updated" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function updated(Declaration $declaration)
    {
        $affectation = Affectation::find($declaration->affectation_id);

        if ($affectation->client->sip != 'TEST') {
            Mail::to(MailList::where([['type', 'orange'], ['status', 1]])->get('email'))->cc(MailList::where([['type', 'declaration'], ['status', 1]])->get('email'))->send(new DeclarationMail($declaration));
        }
    }

    /**
     * Handle the Declaration "deleted" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function deleted(Declaration $declaration)
    {
        //
    }

    /**
     * Handle the Declaration "restored" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function restored(Declaration $declaration)
    {
        //
    }

    /**
     * Handle the Declaration "force deleted" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function forceDeleted(Declaration $declaration)
    {
        //
    }
}
