<?php

declare(strict_types=1);

namespace App\Services\API;

use App\Models\Client;
use App\Models\User;
use App\Models\Technicien;

use Illuminate\Support\Facades\Auth;

class UserService
{

    static public function updateDeviseKey($id, $deviseKey)
    {

        $user = User::find($id);

        $user->device_key = $deviseKey;


        if ($user->update()) {

            return $user;
        }
    }


    static public function deconnectUserService($id)
    {

        $user = User::find($id);

        $user->device_key = null;
        $user->is_online = 0;
        $user->technicien->player_id = null;
        $user->technicien->save();


        if ($user->update()) {

            return $user;
        }
    }


    static public function updatePlayerId($id, $playeriId)
    {

        $technicien = Technicien::find($id);

        $technicien->player_id = $playeriId;


        if ($technicien->update()) {

            return $technicien;
        }
    }





    public function getThecnincenAfectationCouteurApi($id)
    {
        $count =  Client::where("status", "active")->where("thecnicien_id", $id)->count();
        return $count;
    }



    public function chectechnicienIsBlocked($userId)
    {


        $isBlocked = User::where('id', $userId)->whereNull("device_key")->exists();
        
        
        return $isBlocked;
    }




    static public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
