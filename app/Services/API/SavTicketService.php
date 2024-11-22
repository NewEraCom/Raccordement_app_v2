<?php

namespace App\Services\API;

use App\Models\SavTicket;

class SavTicketService
{
    public function getSavTicketApi($id)
    {
        $affectation = SavTicket::with(['client'])->where('technicien_id',$id)->where('status','En cours')->get();
        return  $affectation ;
    }

    public function getSavTicketPlanApi($id)
    {
        $affectation = SavTicket::with(['client'])->where('technicien_id',$id)->where('status','Planifié')->get();
        return  $affectation ;
    }





}
