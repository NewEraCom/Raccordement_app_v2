<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }



    public function getUser(Request $request)
    {
        $user = $this->userService->getUser($request->input('id'));

        if ($user === null) {
            return response()->json(['error' => 'User not found'], 404); // Return error if user is not found
        }

        return response()->json(['user' => $user], 200); // Return the user object if found
    }

    public function updateDeviseKey(Request $request)
    {

        $this->userService->updateDeviseKey($request->input('id'), $request->input('deviseKey'));
    }
    public function deconnectUser(Request $request)
    {

        $this->userService->deconnectUserService($request->input('id'));
    }
    public function updatePlayerId(Request $request)
    {

        $this->userService->updatePlayerId($request->input('id'), $request->input('playeriId'));
    }



    public function chectechnicienIsBlocked($userId)
    {

        $check =    $this->userService->chectechnicienIsBlocked($userId);

        if ($check) {


            return response()->json(['is blocked' => $check], 409);
        } else {


            return response()->json(['is not blocked' => $check], 200);
        }
    }
}
