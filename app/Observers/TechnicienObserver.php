<?php

namespace App\Observers;

use App\Mail\NewTechnicienMail;
use App\Mail\TechnicienMailNewAccount;
use App\Models\Technicien;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class TechnicienObserver
{
    /**
     * Handle the Technicien "created" event.
     *
     * @param  \App\Models\Technicien  $technicien
     * @return void
     */
    public function created(Technicien $technicien)
    {
        User::find($technicien->user_id)->update(['technicien_id' => $technicien->id]);
    }

    /**
     * Handle the Technicien "updated" event.
     *
     * @param  \App\Models\Technicien  $technicien
     * @return void
     */
    public function updated(Technicien $technicien)
    {
        //
    }

    /**
     * Handle the Technicien "deleted" event.
     *
     * @param  \App\Models\Technicien  $technicien
     * @return void
     */
    public function deleted(Technicien $technicien)
    {
        $technicien->user->delete();
    }

    /**
     * Handle the Technicien "restored" event.
     *
     * @param  \App\Models\Technicien  $technicien
     * @return void
     */
    public function restored(Technicien $technicien)
    {
        //
    }

    /**
     * Handle the Technicien "force deleted" event.
     *
     * @param  \App\Models\Technicien  $technicien
     * @return void
     */
    public function forceDeleted(Technicien $technicien)
    {
        //
    }
}
