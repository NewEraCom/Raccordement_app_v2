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
        $user =  $this->loginService->loginApi($request->input('email'),$request->input('password'));
        
        
        
          if(empty($user))
          {
                  return response()->json([
                'success' => false,
                'message' => 'User authentication failed.',
            ], 401);
          }
          else
          {
                return response()->json([
            
                 'success' => true,
                'message' => 'User authentication success.',
            
            'User' => $user], 200);
          }
          
          
      
        
        
       
    }
    
    public function getCurrentUser(Request $request){
        try{
                $user = User::with('technicien')->find($request->id);
        return response()->json(['user'=>$user],200);    
        }catch (RequestException $e) {
            
        return response()->json(['user'=>$e->getMessage()],401);   
    }

    }


    
    public function registerApi(Request $request)
    {


        $user =  $this->loginService->loginApi($request->input('email'),$request->input('password'));

    
        return response()->json(['User' => $user], 200);
    }
}
