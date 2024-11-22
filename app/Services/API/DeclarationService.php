<?php

namespace App\Services\API;

use App\Models\Blocage;
use App\Models\Declaration;
use App\Models\Technicien;
use Illuminate\Support\Str;

use Illuminate\Http\Request;


class DeclarationService
{
    public function getDeclarationsApi()
    {
        $Declaration = Declaration::with(['client'])->get();
        return  $Declaration;
    }

    public function getDeclarationApi($id)
    {
        $Declaration = Declaration::where("affectation_id", $id)->first();
        return  $Declaration;
    }

    static public function declaration(Request $request)
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



        $declaration = Declaration::create([

            'uuid' => Str::uuid(),
            'affectation_id' => $request->input('affectation_id'),
            'pto' =>  $request->input('pto'),

            'routeur_id' =>  $request->routeur_id,

            'test_signal' =>  $request->input('test_signal'),
            'image_test_signal' =>  $request->input('image_test_signal'),
            'image_pbo_before' =>  $request->input('image_pbo_before'),
            'image_pbo_after' =>  $request->input('image_pbo_after'),
            'image_pbi_after' =>  $request->input('image_pbi_after'),
            'image_pbi_before' =>  $request->input('image_pbi_before'),
           'image_splitter' =>  $request->input('image_splitter'),
            'type_passage' =>  $request->input('type_passage'),
            'image_passage_1' =>  $request->input('image_passage_1'),
            'image_passage_2' =>  $request->input('image_passage_2'),
            'image_passage_3' =>  $request->input('image_passage_3'),
            'sn_telephone' =>  $request->input('sn_telephone'),
            'nbr_jarretieres' =>  $request->input('nbr_jarretieres'),
            'cable_metre' =>  $request->input('cable_metre'),
            'lat' =>  $request->input('lat'),
            'lng' =>  $request->input('lng')
        ]);
        $declaration->affectation->client->routeur_type =  $request->input('routeur_type');





        $declaration->save();



        return $declaration;
    }



    static public function updateDeclarationApi(Request $request)
    {

        $declaration = Declaration::find($request->input('id'));
        $declaration->update([
        
          


            'pto' =>  $request->input('pto'),
            'lat' =>  $request->input('lat'),
            'lng' =>  $request->input('lng')
        ]);




        return $declaration;
    }
}
