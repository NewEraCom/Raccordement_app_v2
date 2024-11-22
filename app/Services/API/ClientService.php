<?php

namespace App\Services\API;
use App\Models\City;
use App\Models\Client;
use App\Models\Technicien;

class ClientService 
{
    public function getClientApi($id)
    {
        
        
        $cityIds = City::whereHas('techniciens', function ($query) use ($id){
    $query->where('technicien_id', $id);
      })->pluck('id');
        
        
        $client = Client::where("status","Saisie")->where('promoteur', 0)->whereIn("city_id",   $cityIds)->get();
        return  $client ;
    }
    


    public function getThecnincenAfectationCouteurApi($id)
    {
        
        

        
        $count =  Client::where("status","Saisie")->where("technicien_id",$id)->count();
        return $count; 
    }

    public function getClientThecnicienApi($id)
    {
        $clients = Client::where("technicien_id",$id)->get();
        return  $clients ;
    }
    



}
