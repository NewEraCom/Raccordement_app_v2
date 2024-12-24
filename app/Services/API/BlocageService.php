<?php

namespace App\Services\API;

use App\Models\Affectation;
use App\Models\Technicien;
use App\Models\Blocage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BlocageService
{
    public function getAffectationApi()
    {
        $affectation = Affectation::with(['client'])->get();
        return  $affectation;
    }
    public function getThecnincenAfectationCouteurApi()
    {
        $count = Technicien::where("id", 1)->count();
        return  $count;
    }
    static public function declarationBlocage(Request $request)
    {



        // $validator = Validator::make($request->all(), [
        //     'id' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        // $blocage = new Blocage;
        // // $userRating = ($request->input('user_rating') + ($user->user_rating * $user->nb_rating)) / $user->nb_rating + 1;

        // $blocage->uuid = Str::uuid();
        // $blocage->affectation_id = $request->input('affectation_id');
        // $blocage->cause =  $request->input('cause');

        $blocage = Blocage::create([
            'uuid' => Str::uuid(),
            'affectation_id' => $request->input('affectation_id'),
            'cause' =>  $request->input('cause'),
            'justification' =>  $request->input('justification'),
            'gps_link' =>  $request->input('gps_link'),
            'lat' =>  $request->input('lat'),
            'lng' =>  $request->input('lng')
        ]);



        return $blocage;
        // response()->json(['updated' => $user->update(), 'user' => $user,], 200);


        // else {
        //     return response(['created' => false, 'message' => 'user already exists'], 401);
        // }


    }
}
