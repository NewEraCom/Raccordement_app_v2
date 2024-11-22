<?php

namespace App\Http\Controllers\API;

use App\Services\API\DeclarationService;
use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;

class DeclartionController extends Controller
{
    protected $declarationService;

    public function __construct(DeclarationService $declarationService)
    {
        $this->declarationService = $declarationService;
    }
    public function declarationAffectation(Request $request)
    {
        
        $blocage = $this->declarationService->declaration($request);
        return response()->json(['Declaration' => $blocage], 200);
    }
    
      public function updateDeclaration(Request $request)
    {
        
 
        return response()->json(['Declaration' =>''], 200);
    }
    
    
     public function getDeclaration($id)
    {
        
        $blocage = $this->declarationService->getDeclarationApi($id);
        return response()->json(['Declaration' => $blocage], 200);
    }
}
