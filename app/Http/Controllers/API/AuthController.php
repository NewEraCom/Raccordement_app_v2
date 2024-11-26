<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\API\AuthService;


class AuthController extends Controller
{



    protected $loginService;

    public function __construct(AuthService $loginService)
    {
        $this->loginService = $loginService;
    }


    public function loginApi(Request $request)
    {
        // $user = $this->loginService->loginApi(
        //     $request
        // );

        // if (!$user) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'User authentication failed.',
        //         'user' => [],

        //     ], 401);
        // }

        // return response()->json([
        //     'success' => true,
        //     'message' => 'User authentication succeeded.',
        //     'user' =>  $user,
        //     // Renamed to lowercase to align with common JSON key conventions
        // ], 200);
        return    $this->loginService->loginApi(
            $request
        );
    }

    public function getCurrentUser(Request $request)
    {
        try {
            $user = User::with('technicien')->find($request->id);
            return response()->json(['user' => $user], 200);
        } catch (RequestException $e) {

            return response()->json(['user' => $e->getMessage()], 401);
        }
    }



    public function registerApi(Request $request)
    {


        $user =  $this->loginService->loginApi($request->input('email'), $request->input('password'));


        return response()->json(['User' => $user], 200);
    }
}
