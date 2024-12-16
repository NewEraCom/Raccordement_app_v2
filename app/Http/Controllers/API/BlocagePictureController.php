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
        // Validate the incoming request (adjust validation rules as needed)
        $validated = $request->validate([
            'image_url' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240', // Ensure it's an image with max size 10MB

            'blocage_id' => 'required|string',
        ]);  // Example validation for additional fields        ]);

        // Handle uploaded images using the static helper method
        $imagePaths = self::handleUploadedImages($request, ['image_url' => $request->file('image_url')]);

        // Create a new BlocagePicture entry using validated data
        $blocagePicture = BlocagePicture::create([
            'uuid' => Str::uuid(),
            'image_url' => $imagePaths['image_url'],  // Store the path of the uploaded image
            'image' => $request->input('image'),
            'blocage_id' =>  $request->input('blocage_id')
        ]);

        // Save the BlocagePicture record
        if ($blocagePicture->save()) {
            return response()->json(['images' => $blocagePicture], 200);
        }

        return response()->json(['error' => 'Failed to save image'], 500);
    }

    // Static method to handle image uploads
    protected static function handleUploadedImages(Request $request, array $validated): array
    {
        $imagePaths = [];
        foreach ($validated as $fieldName => $file) {
            if ($request->hasFile($fieldName)) {
                // Store image in 'public/uploads' directory
                $imagePaths[$fieldName] = $request->file($fieldName)->store('uploads', 'public');
            }
        }
        return $imagePaths;
    }
}
