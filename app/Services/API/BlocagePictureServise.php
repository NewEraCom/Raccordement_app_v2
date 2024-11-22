<?php

namespace App\Services\API;


use App\Models\BlocagePicture;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BlocagePictureService
{





    public function storeImageBlocage(Request $request)
    {






        $blocagePicture = BlocagePicture::create([
            'uuid' => Str::uuid(),
            'image' => $request->input('image'),
            'image_data' => $request->input('image_data'),
            'blocage_id' =>  $request->input('blocage_id')


        ]);




        if ($blocagePicture->save()) {
            return response()->json(['images' => $blocagePicture], 200);
        }
    }
}
