<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Declaration;
use App\Models\feedback;
use App\Models\SavTicket;
use App\Models\savhistory; 
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{

    public function addFeedback(Request $request){
        try {
            
            $declaration =  feedback::updateOrCreate(
                [
                    'sav_ticket_id' => $request->input('sav_ticket_id')

                ],
                [
                    'description' => $request->input('description'),
                    'test_signal'=>$request->input('test_signal'),
                    'type' => "Validé",
                    'sav_ticket_id' => $request->input('sav_ticket_id'),
                    'image_facultatif'=>$request->input('image_facultatif'),




                ]
            );
             
            $declaration->save();
           $savTicket = SavTicket::find($request->input('sav_ticket_id'));
           $savTicket->status = 'Validé';
              Savhistory::create([
                        'savticket_id' =>$request->input('sav_ticket_id'),
                        'technicien_id' => $savTicket->technicien->id,
                        'status' => 'Connecté',
                        'description' => 'Feedback Complet',
                    ]);
           $savTicket->save();
           $client =  $savTicket->client;
           $client->statusSav = "Connecté";
           $client->save();
           $savHistory->save();
           
              
              


        return   response()->json('Added successfully', 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
            //throw $th;
        }



    }


    public function addFeedbackBlocakge(Request $request){
       try {
        $declaration =  feedback::updateOrCreate(
            [
                'sav_ticket_id' => $request->input('sav_ticket_id')
            ],
            [
                'type' => "Bloqué",
                'image_facultatif'=>$request->input('image_facultatif'),
                'sav_ticket_id' => $request->input('sav_ticket_id'),
                'type_blockage' => $request->input('type_blockage'),
            ]
        );
        $declaration->save();
       $savTicket = SavTicket::find($request->input('sav_ticket_id'));
       $savTicket->status = 'Bloqué';
       $savTicket->save();
             Savhistory::create([
                        'savticket_id' =>$request->input('sav_ticket_id'),
                        'technicien_id' => $savTicket->technicien->id,
                        'status' => 'Down',
                        'description' => 'Feedback Blocage',
                    ]);
       $client =  $savTicket->client;
    //    $client->statusSav = "Down";
       $client->save();


       return   response()->json('Added successfully', 200);
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json($th->getMessage(), 500);
       }
    }


    public function addPlanned(Request $request){
     try {
        $savTicket = SavTicket::find($request->input('sav_ticket_id'));
        $savTicket->status = 'Planifié';
        $savTicket->planification_date =
        Carbon::parse($request->input('planification_date'))->format('Y-m-d H:i:s');
        
     
        $savTicket->save();
         Savhistory::create([
                        'savticket_id' =>$request->input('sav_ticket_id'),
                        'technicien_id' => $savTicket->technicien->id,
                        'status' => 'Affecté',
                        'description' => 'Feedback Planifié',
                    ]);
        $client =  $savTicket->client;
        $client->statusSav = "Down";
        $client->save();


     return   response()->json('Added successfully', 200);
     } catch (\Throwable $th) {
        //throw $th;
        return response()->json($th->getMessage(), 500);
     }
    }

}
