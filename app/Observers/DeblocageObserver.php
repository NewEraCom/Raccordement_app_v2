<?php

namespace App\Observers;
use App\Models\Affectation;
use App\Models\Client;
use App\Models\Blocage;
use App\Models\Deblocage;

class DeblocageObserver
{
    /**
     * Handle the Validation "created" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function created(Deblocage $deblocage)
    {
      //  $affectation->status = 'Terminé';
      //  $affectation->save();
        
     
        Affectation::where("id",$deblocage->affectation_id)->update([
        'status' => 'En cours',    
         ]);
         
        
        
    }

    /**
     * Handle the Validation "updated" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function updated(Deblocage $deblocage)
    {
       
    }

    /**
     * Handle the Validation "deleted" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function deleted(Deblocage $deblocage)
    {
        //
    }

    /**
     * Handle the Validation "restored" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function restored(Deblocage $deblocage)
    {
        //
    }

    /**
     * Handle the Validation "force deleted" event.
     *
     * @param  \App\Models\Validation  $validation
     * @return void
     */
    public function forceDeleted(Deblocage $deblocage)
    {
        //
    }
}
