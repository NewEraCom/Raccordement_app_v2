<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\ValidationService;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }
    public function validation(Request $request)
    {
        
        $blocage = $this->validationService->validation($request);
        return response()->json(['Validation' => $blocage], 200);
    }
       public function updateValidation(Request $request)
    {
        
        $blocage = $this->validationService->updateValidationApi($request);
        return response()->json(['Validation' => $blocage], 200);
    }
    
    
    public function getValidation($id)
    {
        
        $validation = $this->validationService->getValidationApi($id);
        return response()->json(['Validation' => $validation], 200);
    }
}
