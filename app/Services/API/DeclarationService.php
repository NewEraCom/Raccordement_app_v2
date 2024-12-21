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
        $Declaration = Declaration::where("affectation_id", $id)->orderBy('id', 'desc')->first();
        return  $Declaration;
    }

    public static function declaration(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'image_test_signal_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_pbo_before_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_pbo_after_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_pbi_after_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_pbi_before_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_splitter_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_passage_1_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_passage_2_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_passage_3_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            ]);

            // Process and store uploaded images
            $imagePaths = self::handleUploadedImages($request, $validated);

            // Create the declaration with the stored image URLs
            $declaration = Declaration::create([
                'uuid' => Str::uuid(),
                'affectation_id' => $request->input('affectation_id'),
                'pto' => $request->input('pto'),
                'routeur_id' => $request->routeur_id,
                'test_signal' => $request->input('test_signal'),
                'type_routeur' => $request->input('type_routeur'),
                'image_test_signal_url' => $imagePaths['image_test_signal_url'] ?? null,
                'image_pbo_before_url' => $imagePaths['image_pbo_before_url'] ?? null,
                'image_pbo_after_url' => $imagePaths['image_pbo_after_url'] ?? null,
                'image_pbi_after_url' => $imagePaths['image_pbi_after_url'] ?? null,
                'image_pbi_before_url' => $imagePaths['image_pbi_before_url'] ?? null,
                'image_splitter_url' => $imagePaths['image_splitter_url'] ?? null,
                'type_passage' => $request->input('type_passage'),
                'image_passage_1_url' => $imagePaths['image_passage_1_url'] ?? null,
                'image_passage_2_url' => $imagePaths['image_passage_2_url'] ?? null,
                'image_passage_3_url' => $imagePaths['image_passage_3_url'] ?? null,
                'sn_telephone' => $request->input('sn_telephone'),
                'nbr_jarretieres' => $request->input('nbr_jarretieres'),
                'cable_metre' => $request->input('cable_metre'),
                'lat' => $request->input('lat'),
                'lng' => $request->input('lng'),
            ]);

            $declaration->affectation->client->routeur_type = $request->input('routeur_type');
            $declaration->save();

            return response()->json($declaration, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
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

    /**
     * Updates existing images for a declaration.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Declaration $declaration
     * @return void
     */
    public static function updateImages(Request $request, Declaration $declaration): void
    {
        $validated = $request->validate([
            'image_test_signal_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_pbo_before_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_pbo_after_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_pbi_after_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_pbi_before_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_splitter_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_passage_1_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_passage_2_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            'image_passage_3_url' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $imagePaths = self::handleUploadedImages($request, $validated);

        foreach ($imagePaths as $fieldName => $path) {
            $declaration->$fieldName = $path;
        }

        $declaration->save();
    }




    public static function updateDeclaration(Request $request, $id)
    {
        try {
            // Find the declaration by ID
            $declaration = Declaration::findOrFail($id);

            // Validate the request
            $validated = $request->validate([
                'image_test_signal_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_pbo_before_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_pbo_after_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_pbi_after_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_pbi_before_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_splitter_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_passage_1_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_passage_2_url' => 'image|mimes:jpeg,png,jpg|max:10240',
                'image_passage_3_url' => 'image|mimes:jpeg,png,jpg|max:10240',
            ]);

            // Process and store uploaded images
            $imagePaths = self::handleUploadedImages($request, $validated);

            // Update the declaration with the stored image URLs and other fields
            $declaration->update([
                // 'affectation_id' => $request->input('affectation_id', $declaration->affectation_id),
                'pto' => $request->input('pto', $declaration->pto),
                'routeur_id' => $request->input('routeur_id', $declaration->routeur_id),
                'test_signal' => $request->input('test_signal', $declaration->test_signal),
                'type_routeur' => $request->input('type_routeur', $declaration->type_routeur),
                'image_test_signal_url' => $imagePaths['image_test_signal_url'] ?? $declaration->image_test_signal_url,
                'image_pbo_before_url' => $imagePaths['image_pbo_before_url'] ?? $declaration->image_pbo_before_url,
                'image_pbo_after_url' => $imagePaths['image_pbo_after_url'] ?? $declaration->image_pbo_after_url,
                'image_pbi_after_url' => $imagePaths['image_pbi_after_url'] ?? $declaration->image_pbi_after_url,
                'image_pbi_before_url' => $imagePaths['image_pbi_before_url'] ?? $declaration->image_pbi_before_url,
                'image_splitter_url' => $imagePaths['image_splitter_url'] ?? $declaration->image_splitter_url,
                'type_passage' => $request->input('type_passage', $declaration->type_passage),
                'image_passage_1_url' => $imagePaths['image_passage_1_url'] ?? $declaration->image_passage_1_url,
                'image_passage_2_url' => $imagePaths['image_passage_2_url'] ?? $declaration->image_passage_2_url,
                'image_passage_3_url' => $imagePaths['image_passage_3_url'] ?? $declaration->image_passage_3_url,
                'sn_telephone' => $request->input('sn_telephone', $declaration->sn_telephone),
                'nbr_jarretieres' => $request->input('nbr_jarretieres', $declaration->nbr_jarretieres),
                'cable_metre' => $request->input('cable_metre', $declaration->cable_metre),
                'lat' => $request->input('lat', $declaration->lat),
                'lng' => $request->input('lng', $declaration->lng),
            ]);

            if ($request->filled('routeur_type')) {
                $declaration->affectation->client->routeur_type = $request->input('routeur_type');
                $declaration->affectation->client->save();
            }

            return response()->json(['declaration' => $declaration], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'message' => 'Failed to update the declaration',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
