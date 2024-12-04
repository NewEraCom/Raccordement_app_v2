<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Affectation;
use App\Models\Client;

use App\Models\Technicien;
use App\Models\TechnicienLog;

use App\Services\API\AffectationService;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use DateTime;
use Illuminate\Support\Facades\DB;






class AffectationController extends Controller
{



    protected $affectationService;

    public function __construct(AffectationService $affectationService)
    {
        $this->affectationService = $affectationService;
    }



    public function setAffectation()
    {
        $client = Client::where('status', 'Saisie')->where('client_id')->first();
    }



    public function getAffectation($id)
    {

        $affectation =  $this->affectationService->getAffectationApi($id);

        return response()->json(
            [
                'success' => true,
                'message' => 'The data has been successfully returned.',
                'affectations' => $affectation
            ],
            200


        );
    }

    public function getAffectationPromoteurApi($id)
    {

        $affectation =  $this->affectationService->getAffectationPromoteurService($id);

        return response()->json([

            'success' => true,
            'message' => 'The data has been successfully returned.',
            'affectations' => $affectation
        ], 200);
    }




    public function getAffectationPlanifier($id)
    {

        $affectation =  $this->affectationService->getAffectationPlanifierApi($id);

        return response()->json(


            [
                'success' => true,
                'message' => 'The data has been successfully returned.',
                'affectations' => $affectation
            ],

            200
        );
    }
    public function getAffectationValider($id)
    {

        $affectation =  $this->affectationService->getAffectationValiderApi($id);

        return response()->json(['Affectations' => $affectation], 200);
    }
    public function getAffectationDeclarer($id)
    {

        $affectation =  $this->affectationService->getAffectationDeclarerApi($id);

        return response()->json(['Affectations' => $affectation], 200);
    }
    public function getAffectationBlocage($id)
    {

        $affectation =  $this->affectationService->getAffectationBlocageApi($id);

        return response()->json(

            [
                'success' => true,
                'message' => 'The data has been successfully returned.',
                'blocages' => $affectation
            ],
            200
        );
    }


    public function getAffectationBlocageAfterDeclared($id)
    {

        $affectation =  $this->affectationService->getAffectationBlocageAfterDeclaredApi($id);

        return response()->json(['Affectations' => $affectation], 200);
    }

    public function createAffectation(Request $request)
    {

        $affectation =  Affectation::firstOrCreate(
            [
                'client_id' =>  $request->input('client_id'),
            ],
            [
                'uuid' => Str::uuid(),
                'client_id' =>  $request->input('client_id'),
                'technicien_id' =>  $request->input('technicien_id'),
                'status' => 'En cours',
                'lat' =>  $request->input('lat'),
                'lng' =>  $request->input('lng'),



            ]
        );

        return response()->json(['Affectations' => $affectation], 200);
    }


    public function createLogTechnicien(Request $request)
    {

        $technicienLog =  TechnicienLog::create(
            [
                'uuid' => Str::uuid(),
                'technicien_id' =>  $request->input('technicien_id'),
                'nb_affectation' =>  $request->input('nb_affectation'),
                'lat' => $request->input('lat'),
                'lng' => $request->input('lng'),
                'build' => $request->input('build')
            ]
        );

        return response()->json(['TechnicienLog' => $technicienLog], 200);
    }



    public function planifierAffectation(Request $request)
    {
        $check = Technicien::find($request->input('technicien_id'));
        $checkNbModification =  Affectation::find($request->input('id'));
        $affectationCount = Affectation::where('technicien_id', $check->id)->where('status', 'Planifié')->count();


        if ($checkNbModification->nb_modification_planification < 2 && $checkNbModification->nb_modification_planification != 0) {
            $affectation =    Affectation::find($request->input('id'))->update([
                'status' => 'Planifié',
                'planification_date' => Carbon::parse($request->input('planification_date'))->format('Y-m-d H:i:s'),
                'nb_modification_planification' => $checkNbModification->nb_modification_planification + 1,
            ]);
        } else {
            if ($check->planification_count > $affectationCount) {
                $affectation =    Affectation::find($request->input('id'))->update([
                    'status' => 'Planifié',
                    'planification_date' => Carbon::parse($request->input('planification_date'))->format('Y-m-d H:i:s'),
                    'nb_modification_planification' => $checkNbModification->nb_modification_planification + 1,
                ]);
            } else {
                return response()->json(['Affectations' =>  ''], 409);
            }
        }

        return response()->json(['Affectations' =>  $affectation], 200);
    }


    public function setAffectationAuto(Request $request)
    {
        try {
            $client = Client::where(DB::raw('TRIM(client_id)'), 'LIKE', '%' . trim($request->input('id_client')) . '%')->where(DB::raw('TRIM(phone_no)'), 'LIKE', '%' . trim($request->input('phoneNumber')) . '%')->where('status', 'Saisie')
                ->first();
            if ($client != null) {
                DB::beginTransaction();
                $client->update([
                    'type_affectation' => 'Affectation Par App',
                ]);
                $affectation = Affectation::firstOrCreate([
                    'client_id' => $client->id,
                ], [
                    'uuid' => Str::uuid(),
                    'client_id' => $client->id,
                    'technicien_id' => $request->input('id_technicien'),
                    'status' => 'En cours',
                ]);
                if ($affectation->wasRecentlyCreated) {
                    $affectation->load('client');
                    $affectation->refresh('client');
                    DB::commit();
                    return response()->json([
                        'message' => $affectation
                    ], 200);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'message' => 'Already exist',
                    ], 401);
                }
            } else {
                return response()->json([
                    'message' => 'Client not found',
                ], 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function uploadImages(Request $request)
    {
        try {
            // Validate the input
            $validated = $request->validate([
                'image_1' => 'required|image|mimes:jpeg,png,jpg|max:10048',
                'image_2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'image_3' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'image_4' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'image_5' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'image_6' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'image_7' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'image_8' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'image_9' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Process the images
            $paths = [];
            foreach (['image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6', 'image_7', 'image_8', 'image_9'] as $imageField) {
                if ($request->hasFile($imageField)) {
                    $paths[$imageField] = $request->file($imageField)->store('uploads', 'public');
                }
            }

            return response()->json([
                'message' => 'Images uploaded successfully',
                'paths' => $paths,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails, return error messages
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(), // Contains detailed validation error messages for each field
            ], 422);
        }
    }
}
