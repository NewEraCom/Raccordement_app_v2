<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\ClientService;
use Illuminate\Http\Request;
use App\Models\AppVersion;
use App\Models\Technicien;
use App\Models\City;


class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }


    public function getClientsAncien($cityId)
    {

        $client =  $this->clientService->getClientApi($cityId);




        //$compteur = City::where('id', $cityId)->pluck('compteur')->first();



        $technicien = Technicien::where('id', $cityId)->first();


        return response()->json(['Clients' => $client, 'Compteur' =>      $technicien->conteur], 200);
    }


    public function getClients($technicienId, $nbBuild)
    {
        $technicien = Technicien::with('user')->find($technicienId);


   // if ($technicien->user->status == 0) {
        //     return response()->json(['Succes' => "false", "Message" => "Votre compte est bloqué."], 409);
        // } else {
        //     $appVersion = AppVersion::orderBy('id', 'desc')->first();
        //     // if($appVersion->build == $nbBuild )
        //     if ( $nbBuild  ==32 || $nbBuild  ==35) {

        //         $compteur = City::whereHas('techniciens', function ($query) use ($technicienId) {
        //             $query->where('technicien_id', $technicienId);
        //         })->pluck('compteur')->first;

        //         $client =  $this->clientService->getClientApi($technicienId);
        //         $technicien = Technicien::where('id', $technicienId)->first();

        //         return response()->json(['Clients' => $client, 'Compteur' => $technicien->conteur], 200);
        //     }

        //     return response()->json(['Succes' => "false", "Message" => "Merci d'installer la dernière version."], 409);
        // }
        
            return response()->json(['Succes' => "false", "Message" => "Contacter support."], 411);
    }


    public function getClientsThecnicien($id)
    {

        $clients =  $this->clientService->getClientThecnicienApi($id);

        return response()->json(['Clients' => $clients], 200);
    }
}
