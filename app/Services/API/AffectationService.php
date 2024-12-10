<?php

namespace App\Services\API;

use App\Models\Affectation;
use App\Models\Technicien;
use App\Models\Blocage;
use Illuminate\Http\Request;


class AffectationService
{
    public function getAffectationApi($id)
    {
        $affectation = Affectation::with(['client'])->where('technicien_id', $id)->where('status', 'En cours')->whereHas('client', function ($query) {
            $query->where('promoteur', 0);
        })->orderBy('id', 'desc')->get();
        return  $affectation;
    }

    public function getAffectationPromoteurService($id)
    {
        $affectation = Affectation::with(['client'])->where('status', 'En cours')->whereHas('client', function ($query) {
            $query->where('promoteur', 1);
        })->limit(10)->get();
        return  $affectation;
    }
    public function getAffectationPromoteurPlanifierApi($id)
    {

        $affectation = Affectation::with(['client'])->where('technicien_id', $id)->orderBy('planification_date', 'asc')->where('status', 'Planifié')->whereHas('client', function ($query) {
            $query->where('promoteur', 1);
        })->limit(10)->get();
        return  $affectation;
    }


    public function getAffectationPlanifierApi($id)
    {
        $affectation = Affectation::with(['client'])->where('technicien_id', $id)->orderBy('planification_date', 'asc')->where('status', 'Planifié')->get();
        return  $affectation;
    }
    public function getAffectationDeclarerApi($id)
    {
        $affectation = Affectation::with(['client'])->where('status', 'Déclaré')->where('technicien_id', $id)->get();
        return  $affectation;
    }
    public function getAffectationValiderApi($id)
    {
        $affectation = Affectation::with(['client'])->where('technicien_id', $id)->where('status', 'Terminé')->orderBy('id', 'desc')->get();
        return  $affectation;
    }
    public function getAffectationBlocageApi($id)
    {
        $affectation = Blocage::whereHas('affectation', function ($query)  use ($id) {
            $query->where('technicien_id', $id)->where('status', "Bloqué");
        })->with(
            'affectation',
            function ($query) {
                $query->with(['client']);
            }

        )



            ->where('declared', null)->where('resolue', 0)->orderBy('id', 'desc')->get();
        return  $affectation;
    }


    public function getAffectationBlocageAfterDeclaredApi($id)
    {
        $affectation = Blocage::whereHas('affectation', function ($query)  use ($id) {
            $query->where('technicien_id', $id);
        })->with(
            'affectation',
            function ($query) {
                $query->with(
                    'client',
                    function ($query) {
                        $query->with(['blocages']);
                    }
                );
            }

        )
            ->where('declared', 'Déclaré')->orderBy('id', 'desc')->get();
        return  $affectation;
    }
    public function getThecnincenAfectationCouteurApi()
    {
        $count = Technicien::where("id", 1)->count();
        return  $count;
    }

    public function setAffectationAuto($id_client, $id_technicien)
    {
        try {
            $client = Client::where('client_id', $id_client)->first()->update([
                'type_affectation' => 'Affectation Par App',
            ]);
            $affectation = Affectation::updateOrCreate([
                'client_id' => $client->id,
            ], [
                'uuid' => Str::uuid(),
                'client_id' => $client->id,
                'technicien_id' => $id_technicien,
                'status' => 'En cours',
            ]);
            return response()->json([
                'message' => $affectation
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
