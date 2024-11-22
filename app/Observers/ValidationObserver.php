<?php

namespace App\Observers;
use App\Models\Affectation;
use App\Models\Client;
use App\Models\Blocage;
use App\Models\Validation;
use App\Models\AffectationHistory;

class ValidationObserver
{
    /**
     * Handle the Validation "created" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function created(Validation $validation)
    {
       $affectation = Affectation::find($validation->affectation_id);
      //  $affectation->status = 'Terminé';
      //  $affectation->save();
        
     
        Affectation::where("id",$validation->affectation_id)->update([
        'status' => 'Terminé',    
         ]);
         
     
     
           Blocage::where("affectation_id",$validation->affectation_id)->update([
        'declared' => 'Validé',    
         ]);
         
          
         
         
        Client::find($affectation->client->id)->update([
          'status' => 'Validé',
            'routeur_id' => $validation->routeur_id,   
        ]);
        
        AffectationHistory::create([
            'affectation_id' => $validation->affectation_id,
            'technicien_id' => $affectation->technicien_id,
            'status' => 'Terminé',
        ]);
         
        
        
    }

    /**
     * Handle the Validation "updated" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function updated(Validation $validation)
    {
       
    }

    /**
     * Handle the Validation "deleted" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function deleted(Validation $validation)
    {
        //
    }

    /**
     * Handle the Validation "restored" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function restored(Validation $validation)
    {
        //
    }

    /**
     * Handle the Validation "force deleted" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function forceDeleted(Validation $validation)
    {
        //
    }
}
