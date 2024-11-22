<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\BlocageService;
use Illuminate\Http\Request;

class BlocageController extends Controller
{



    protected $blocageService;

    public function __construct(BlocageService $blocageService)
    {
        $this->blocageService = $blocageService;
    }
    public function declarationBlocage(Request $request)
    {
        
        $blocage = $this->blocageService->declarationBlocage($request);
        return response()->json(['Blocage' => $blocage], 200);
    }
    
      public function getAffectationBlocageAfterDeclared($id)
    {
        
        $blocage = $this->blocageService->getAffectationBlocageAfterDeclaredApi($id);
        return response()->json(['Blocage' => $blocage], 200);
    }
  
    
}
