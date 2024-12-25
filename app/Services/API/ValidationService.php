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
        $validation = Validation::where("affectation_id", $id)->first();
        return  $validation;
    }


    static public function validation(Request $request)
    {


        // Validate the request
        $validated = $request->validate([
            'test_debit_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'test_debit_via_cable_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'photo_test_debit_via_wifi_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'etiquetage_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'fiche_installation_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_cin_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'router_tel_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'pv_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        // Process and store uploaded images
        $imagePaths = self::handleUploadedImages($request, $validated);


        // Create a new validation entry
        $validation = Validation::create([
            'uuid' => Str::uuid(),
            'test_debit' => $request->input('test_debit'),
            'test_debit_via_cable' => $request->input('test_debit_via_cable'),
            'test_debit_via_wifi' => $request->input('test_debit_via_wifi'),




            'test_debit_via_cable_image_url' => $imagePaths['test_debit_via_cable_image_url'] ?? null,
            'photo_test_debit_via_wifi_image_url' => $imagePaths['photo_test_debit_via_wifi_image_url'] ?? null,
            'etiquetage_image_url' => $imagePaths['etiquetage_image_url'] ?? null,
            'fiche_installation_image_url' => $imagePaths['fiche_installation_image_url'] ?? null,
            'pv_image_url' => $imagePaths['pv_image_url'] ?? null,
            'router_tel_image_url' => $imagePaths['router_tel_image_url'] ?? null,
            'cin_description' => $request->input('cin_description'),
            'image_cin_url' => $imagePaths['image_cin_url'] ?? null,
            'cin_justification' => $request->input('cin_justification'),
            'affectation_id' => $request->input('affectation_id'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
        ]);

        return $validation;
        // response()->json(['updated' => $user->update(), 'user' => $user,], 200);

        // else {
        //     return response(['created' => false, 'message' => 'user already exists'], 401);
        // }

    }



    static public function updateValidation(Request $request, $id)
    {
        // Find the validation entry by ID
        $validation = Validation::find($id);

        if (!$validation) {
            return response()->json(['message' => 'Validation not found'], 404);
        }

        // Validate the request
        $validated = $request->validate([
            'test_debit_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'test_debit_via_cable_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'photo_test_debit_via_wifi_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'etiquetage_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'fiche_installation_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_cin_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'router_tel_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'pv_image_url' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        // Process and store uploaded images
        $imagePaths = self::handleUploadedImages($request, $validated);

        // Update the validation entry
        $validation->update([
            'test_debit' => $request->input('test_debit', $validation->test_debit),
            'test_debit_via_cable' => $request->input('test_debit_via_cable', $validation->test_debit_via_cable),
            'test_debit_via_wifi' => $request->input('test_debit_via_wifi', $validation->test_debit_via_wifi),
            'test_debit_via_cable_image_url' => $imagePaths['test_debit_via_cable_image_url'] ?? $validation->test_debit_via_cable_image_url,
            'photo_test_debit_via_wifi_image_url' => $imagePaths['photo_test_debit_via_wifi_image_url'] ?? $validation->photo_test_debit_via_wifi_image_url,
            'etiquetage_image_url' => $imagePaths['etiquetage_image_url'] ?? $validation->etiquetage_image_url,
            'fiche_installation_image_url' => $imagePaths['fiche_installation_image_url'] ?? $validation->fiche_installation_image_url,
            'pv_image_url' => $imagePaths['pv_image_url'] ?? $validation->pv_image_url,
            'router_tel_image_url' => $imagePaths['router_tel_image_url'] ?? $validation->router_tel_image_url,
            'cin_description' => $request->input('cin_description', $validation->cin_description),
            'image_cin_url' => $imagePaths['image_cin_url'] ?? $validation->image_cin_url,
            'cin_justification' => $request->input('cin_justification', $validation->cin_justification),
            // 'affectation_id' => $request->input('affectation_id', $validation->affectation_id),
            'lat' => $request->input('lat', $validation->lat),
            'lng' => $request->input('lng', $validation->lng),
        ]);

        return response()->json([
            'message' => 'Validation updated successfully',
            'validation' => $validation,
        ], 200);
    }



    /**
     * Handles the upload and storage of images.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $validated
     * @return array
     */
    protected static function handleUploadedImages(Request $request, array $validated): array
    {
        $imagePaths = [];
        foreach ($validated as $fieldName => $file) {
            if ($request->hasFile($fieldName)) {
                $imagePaths[$fieldName] = $request->file($fieldName)->store('uploads', 'public');
            }
        }
        return $imagePaths;
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
