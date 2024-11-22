<?php

namespace App\Services\API;

use App\Models\Blocage;
use App\Models\Declaration;
use App\Models\Technicien;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ValidationService
{




    public function getValidationApi($id)
    {
        $Declaration = Validation::where("affectation_id",$id)->first();
        return  $Declaration;
    }


    static public function validation(Request $request)
    {

        $validation = Validation::create([
            'uuid' => Str::uuid(),

            'test_debit' => $request->input('test_debit'),
            'test_debit_via_cable_image' =>  $request->input('test_debit_via_cable_image'),
            'photo_test_debit_via_wifi_image' =>  $request->input('photo_test_debit_via_wifi_image'),
            'etiquetage_image' =>  $request->input('etiquetage_image'),
            'fiche_installation_image' =>  $request->input('fiche_installation_image'),
            'pv_image' =>  $request->input('pv_image'),
            'router_tel_image' =>  $request->input('router_tel_image'),
                      'cin_description' =>  $request->input('cin_description'), 
                                'image_cin' =>  $request->input('image_cin'),
                                     'cin_justification' =>  $request->input('cin_justification'), 
            'affectation_id' => $request->input('affectation_id'),
                 'lat' =>  $request->input('lat'),
                  'lng' =>  $request->input('lng')

        ]);


        return $validation;
        // response()->json(['updated' => $user->update(), 'user' => $user,], 200);

        // else {
        //     return response(['created' => false, 'message' => 'user already exists'], 401);
        // }

    }
    
    
    static public function updateValidationApi(Request $request)
    {

       $validation = Validation::find($request->input('id')); 


        $validation->update([
    'test_debit' => $request->input('test_debit'),
    'test_debit_via_cable_image' => $request->input('test_debit_via_cable_image'),
    'photo_test_debit_via_wifi_image' => $request->input('photo_test_debit_via_wifi_image'),
    'etiquetage_image' => $request->input('etiquetage_image'),
    'fiche_installation_image' => $request->input('fiche_installation_image'),
    'pv_image' => $request->input('pv_image'),
    'router_tel_image' => $request->input('router_tel_image'),
    
              'cin_description' =>  $request->input('cin_description'), 
                                'image_cin' =>  $request->input('image_cin'),
                                     'cin_justification' =>  $request->input('cin_justification'), 
         'lat' =>  $request->input('lat'),
                  'lng' =>  $request->input('lng')
]);


        return $validation;
        // response()->json(['updated' => $user->update(), 'user' => $user,], 200);

        // else {
        //     return response(['created' => false, 'message' => 'user already exists'], 401);
        // }

    }
    
}
