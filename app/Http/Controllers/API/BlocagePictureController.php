<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\BlocagePicture;
use App\Services\API\BlocagePictureService;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlocagePictureController extends Controller
{
    protected $blocagePictureService;

    // public function __construct(BlocagePictureService $blocagePictureService)
    // {
    //     $this->blocagePictureService = $blocagePictureService;
    // }
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
        // $blocage = $this->blocagePictureService->storeImageBlocage($request);
        return response()->json(['Blocage' =>" blocage"], 200);

    }
}
