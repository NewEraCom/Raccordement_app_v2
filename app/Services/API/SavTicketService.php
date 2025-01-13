<?php

namespace App\Services\API;

use App\Models\SavTicket;
use App\Models\Blocage;
use App\Models\Technicien;
use App\Models\BlocageSav;
use App\Models\BlocageSavPictures;
use App\Models\FeedBackSav;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class SavTicketService
{
    public function getSavTicketApi($id)
    {
        $affectation = SavTicket::with(['client'])->where('technicien_id', $id)->where('status', 'En cours')->get();
        return  $affectation;
    }

    public function getSavTicketSavBlocageApi($id)
    {
        $affectation = BlocageSav::whereHas('savTicket', function ($query)  use ($id) {
            $query->where('technicien_id', $id)->where('status', "Bloqué");
        })->with(
            'savTicket',
            function ($query) {
                $query->with(['client']);
            }

        )->where('declared', null)->where('resolue', 0)->orderBy('id', 'desc')->get();
        return  $affectation;
    }

    public function getSavTicketPlanApi($id)
    {
        $affectation = SavTicket::with(['client'])->where('technicien_id', $id)->where('status', 'Planifié')->get();
        return  $affectation;
    }

    public function planifierAffectationSav(Request $request)
    {
        // Récupérer les technicien et affectation en fonction des données du request
        $technicien = Technicien::find($request->input('technicien_id'));
        $affectation = SavTicket::find($request->input('id'));

        // Vérification si le technicien ou l'affectation n'existe pas
        if (!$technicien || !$affectation) {
            return response()->json(['error' => 'Technicien ou affectation introuvable.'], 404);
        }

        // Vérifier le nombre d'affectations planifiées pour ce technicien
        // $affectationCount = SavTicket::where('technicien_id', $technicien->id)
        //     ->where('status', 'Planifié')
        //     ->count();

        // Vérifier si le technicien n'a pas atteint le seuil maximal de planifications
        // if ($technicien->planification_count > $affectationCount) {
        //     // Si le technicien peut encore accepter une affectation
        //     $affectation->update([
        //         'status' => 'Planifié',
        //         'planification_date' => Carbon::parse($request->input('planification_date'))->format('Y-m-d H:i:s'),
        //     ]);
        // } else {
        //     // Si le technicien a atteint son quota de planifications
        //     return response()->json(['error' => 'Nombre maximal de planifications atteint pour ce technicien.'], 409);
        // }

        $affectation->update([
            'status' => 'Planifié',
            'planification_date' => Carbon::parse($request->input('planification_date'))->format('Y-m-d H:i:s'),
        ]);

        // Retourner la réponse avec l'affectation mise à jour
        return response()->json(['Affectation' => $affectation], 200);
    }


    static public function declarationBlocageSav(Request $request)
    {

        try {
            // Automatically validate the input data
            $validated = $request->validate([
                'sav_ticket_id' => 'required|integer',
                'cause' => 'required|string|max:255',
                'justification' => 'nullable|string|max:500',
            ]);



            // If validation passes, proceed to create the blocage
            $blocage = BlocageSav::create([
                'uuid' => Str::uuid(),
                'sav_ticket_id' => $validated['sav_ticket_id'],
                'cause' => $validated['cause'],
                'justification' => $validated['justification'] ?? null,
            ]);

            // Return the created blocage object with a 200 OK status
            return response()->json(['blocage' => $blocage], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors


            // Return validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {

            // Return a generic error response
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }






    public function storeImageBlocageSav(Request $request)
    {
        // Validate the incoming request
        // $validated = $request->validate([
        //     'image' => 'nullable|string|max:255', // Optional description
        //     'image_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validate file type and size
        //     'blocage_sav_id' => 'required|integer|exists:blocage_savs,id', // Ensure blocage_sav_id exists
        // ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('image_file')) {
            $filePath = $request->file('image_file')->store('uploads', 'public');
        }

        // Create the record in the database
        $blocagePicture = BlocageSavPictures::create([
            'uuid' => Str::uuid(),
            'description' => $request->input('image'),
            'attachement' => $filePath, // Save the file path in the database
            'blocage_sav_id' => $request->input('blocage_sav_id'),
        ]);

        // Return success response
        return response()->json(['images' => $blocagePicture], 200);
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

    static public function feedbackSav(Request $request)
    {

        try {


            // Validate the request
            $validated = $request->validate([
                'before_picture' => 'image|mimes:jpeg,png,jpg|max:10240',
                'after_picture' => 'image|mimes:jpeg,png,jpg|max:10240',

            ]);

            // Process and store uploaded images
            $imagePaths = self::handleUploadedImages($request, $validated);



            // Automatically validate the input data
            $validated = $request->validate([
                'sav_ticket_id' => 'required|integer',
                'root_cause' => 'required|string|max:255',
                'unite' => 'nullable|string|max:500',
            ]);



            // If validation passes, proceed to create the blocage
            $feedBackSav = FeedBackSav::create([
                'uuid' => Str::uuid(),
                'sav_ticket_id' => $validated['sav_ticket_id'],
                'root_cause' => $validated['root_cause'],
                'unite' => $validated['unite'] ?? null,
                'after_picture' =>     $imagePaths['after_picture'] ?? null,
                'before_picture' =>     $imagePaths['before_picture'] ?? null,


            ]);

            // Return the created blocage object with a 200 OK status
            return response()->json(['feedBackSav' => $feedBackSav], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors


            // Return validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {

            // Return a generic error response
            return response()->json(['error' => $e], 500);
        }
    }
}
