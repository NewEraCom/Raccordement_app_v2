<?php

namespace App\Observers;

use App\Models\Affectation;
use App\Models\AffectationHistory;
use App\Models\Client;
use App\Models\Blocage;

class AffectationObserver
{

    public function created(Affectation $affectation)
    {
        AffectationHistory::create([
            'affectation_id' => $affectation->id,
            //'technicien_id' => $affectation->technicien_id,
            'soustraitant_id'=> $affectation->soustraitant_id,
          //  'status' => 'Affecté',
         'status' => $affectation->status,
            'cause' => $affectation->status == 'Planifié' ? $affectation->planification_date : null,
        ]);
        
        Client::where('id',$affectation->client_id)->update([
            'status' => 'Affecté',
            'technicien_id' => $affectation->technicien_id,
        ]);
    
    }


    public function updated(Affectation $affectation)
    {
        $text = null;
        if($affectation->status == 'Bloqué'){
            $blocage = Blocage::where('affectation_id',$affectation->id)->where('resolue',0)->get()->last();
            $text = $blocage->cause;
        }
        if($affectation->status == 'Planifié'){
            $text = $affectation->planification_date;
        }
        
        // AffectationHistory::firstOrCreate([
        //     'affectation_id' => $affectation->id,
        //     'technicien_id' => $affectation->technicien_id,
        //     'status' => $affectation->status,
        //     'cause' => $text,
        // ],[
        //     'affectation_id' => $affectation->id,
        //     'technicien_id' => $affectation->technicien_id,
        //     'status' => $affectation->status,
        //     'cause' => $text,
        // ]);
        // $affectationHistory = AffectationHistory::find($affectation->id);
   
        // $affectationHistory->update([
        //     'affectation_id' => $affectation->id,
        //     'technicien_id' => $affectation->technicien_id,
        //     'status' => $affectation->status,
        //     'cause' => $text,
        // ]);
            // Check if AffectationHistory exists, if not create it
    // $affectationHistory = AffectationHistory::firstOrCreate([
    //     'affectation_id' => $affectation->id,
    // ]);
    $affectationHistory = AffectationHistory::create([
        'affectation_id' => $affectation->id,
        'technicien_id' => $affectation->technicien_id,
        'soustraitant_id' => $affectation->soustraitant_id,
    //    'status' => 'En cours',
    'status' => $affectation->status,
        'cause' => $text,
    ]);
    
    // Update the AffectationHistory
    // $affectationHistory->update([
    //     'technicien_id' => $affectation->technicien_id,
    //     'status' => 'Affecté',
    //     'cause' => $text,
    // ]);
        
         Client::where('id',$affectation->client_id)->update([
            'status' => 'Affecté',
            'technicien_id' => $affectation->technicien_id,
        ]);
        
        if ($affectation->status == 'Terminé') {
            Client::where('id',$affectation->client_id)->update([
                'status' => 'Déclaré',
            ]);
        }
    }

    public function deleted(Affectation $affectation)
    {
        //
    }


    public function restored(Affectation $affectation)
    {
        //
    }


    public function forceDeleted(Affectation $affectation)
    {
        //
    }
}
