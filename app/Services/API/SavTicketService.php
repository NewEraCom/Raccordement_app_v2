<?php

namespace App\Services\API;

use App\Models\SavTicket;
use App\Models\Blocage;


class SavTicketService
{
    public function getSavTicketApi($id)
    {
        $affectation = SavTicket::with(['client'])->where('technicien_id', $id)->where('status', 'En cours')->get();
        return  $affectation;
    }

    public function getSavTicketSavBlocageApi($id)
    {
        $affectation = Blocage::whereHas('savTicket', function ($query)  use ($id) {
            $query->where('technicien_id', $id)->where('status', "Bloqué");
        })->with(
            'savTicket',
            function ($query) {
                $query->with(['client']);
            }

        )->where('declared', null)->where('resolue', 0)->orderBy('id', 'desc')->get();
        return  $affectation;
    }

    public function getSavTicketPlanApi($id)
    {
        $affectation = SavTicket::with(['client'])->where('technicien_id', $id)->where('status', 'Planifié')->get();
        return  $affectation;
    }
}
