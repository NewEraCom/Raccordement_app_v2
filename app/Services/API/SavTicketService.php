<?php

namespace App\Services\API;

use App\Models\SavTicket;
use App\Models\Blocage;
use App\Models\Technicien;
use App\Models\BlocageSav;
use App\Services\API\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class SavTicketService
{
    public function getSavTicketApi($id)
    {
        $affectation = SavTicket::with(['client'])->where('status', 'En cours')->get();
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

    public function planifierAffectationSav(Request $request)
    {
        // Récupérer les technicien et affectation en fonction des données du request
        $technicien = Technicien::find($request->input('technicien_id'));
        $affectation = SavTicket::find($request->input('id'));

        // Vérification si le technicien ou l'affectation n'existe pas
        if (!$technicien || !$affectation) {
            return response()->json(['error' => 'Technicien ou affectation introuvable.'], 404);
        }

        // Vérifier le nombre d'affectations planifiées pour ce technicien
        // $affectationCount = SavTicket::where('technicien_id', $technicien->id)
        //     ->where('status', 'Planifié')
        //     ->count();

        // Vérifier si le technicien n'a pas atteint le seuil maximal de planifications
        // if ($technicien->planification_count > $affectationCount) {
        //     // Si le technicien peut encore accepter une affectation
        //     $affectation->update([
        //         'status' => 'Planifié',
        //         'planification_date' => Carbon::parse($request->input('planification_date'))->format('Y-m-d H:i:s'),
        //     ]);
        // } else {
        //     // Si le technicien a atteint son quota de planifications
        //     return response()->json(['error' => 'Nombre maximal de planifications atteint pour ce technicien.'], 409);
        // }

        $affectation->update([
            'status' => 'Planifié',
            'planification_date' => Carbon::parse($request->input('planification_date'))->format('Y-m-d H:i:s'),
        ]);

        // Retourner la réponse avec l'affectation mise à jour
        return response()->json(['Affectation' => $affectation], 200);
    }


    public function declarationBlocageSav(Request $request)
    {
        return response()->json([
            'message' => 'Une erreur inattendue est survenue.',
        ], 200);
    }
}
