<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SavTicket;
use App\Services\API\SavTicketService;

class SavTicketController extends Controller
{
    protected $ticketService;
    public function __construct(SavTicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function getAllTicket($id)
    {
        $ticket = $this->ticketService->getSavTicketApi($id);

        return response()->json(


            [
                'success' => true,
                'message' => 'The data has been successfully returned.',
                'affectations' => $ticket
            ],


            200
        );
    }
    public function getPlanifiedTicket($id)
    {
        $ticket = $this->ticketService->getSavTicketPlanApi($id);
        return response()->json(['tickets' => $ticket], 200);
    }
}
