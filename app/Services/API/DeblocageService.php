<?php

namespace App\Services\API;

use App\Models\Blocage;
use App\Models\Deblocage;
use App\Models\Technicien;
use Illuminate\Support\Str;

use Illuminate\Http\Request;


class DeblocageService
{



  static public function Deblocage(Request $request)
  {


  

    $deblocage = Deblocage::create([
    'uuid' => Str::uuid(),
    
        'affectation_id' => $request->input('affectation_id'),
    'photo_spliter_before' => $request->input('photo_spliter_before'),
    'photo_spliter_after' => $request->input('photo_spliter_after'),
    'photo_facade' => $request->input('photo_facade'),
    'photo_chambre' =>$request->input('photo_chambre'),
    'photo_signal' => $request->input('photo_signal')  ,
             'lat' => $request->input('lat'),
           'lng' => $request->input('lng')
         
    ]);
    
    
    return $deblocage;
  }



  static public function updateDeclarationApi(Request $request)
  {

    $declaration = Declaration::find($request->input('id'));
    $declaration->update([
      'affectation_id' => $request->input('affectation_id'),
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
      'routeur_id' =>  $request->input('routeur_id'),
      'pto' =>  $request->input('pto')
    ]);




    return $declaration;
  }
}
