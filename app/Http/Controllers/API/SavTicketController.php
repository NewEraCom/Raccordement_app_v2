<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SavTicket;
use App\Services\API\SavTicketService;
use Illuminate\Http\Request;

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
    public function getSavTicketSavBlocage($id)
    {
        $ticket = $this->ticketService->getSavTicketSavBlocageApi($id);

        return response()->json(


            [
                'success' => true,
                'message' => 'The data has been successfully returned.',
                'blocages' => $ticket
            ],


            200
        );
    }
    public function getPlanifiedTicket($id)
    {
        $ticket = $this->ticketService->getSavTicketPlanApi($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'The data has been successfully returned.',
                'affectations' => $ticket
            ],


            200
        );
    }
    public function planifierAffectationSav(Request $request)
    {
        return  $this->ticketService->planifierAffectationSav($request);
    }
    public function declarationBlocageSav(Request $request)
    {
        return    $this->ticketService->declarationBlocageSav($request);
    }
    public function updateBlocageSav(Request $request)
    {
        return    $this->ticketService->updateBlocageSav($request);
    }
    public function feedbackSav(Request $request)
    {
        return    $this->ticketService->feedbackSav($request);
    }
    public function updateFeedbackSav(Request $request)
    {
        return    $this->ticketService->updateFeedbackSav($request);
    }
    public function getFeedbackSav($id)
    {
        return    $this->ticketService->getFeedbackSav($id);
    }
    public function storeImageBlocageSav(Request $request)
    {
        return    $this->ticketService->storeImageBlocageSav($request);
    }
}
