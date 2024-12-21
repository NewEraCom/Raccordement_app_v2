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

        $validation = $this->validationService->validation($request);
        return response()->json(['validation' => $validation], 200);
    }
    public function updateValidation(Request $request, $id)
    {

        $validation = $this->validationService->updateValidation($request, $id);
        return response()->json(['validation' => $validation], 200);
    }


    public function getValidation($id)
    {

        $validation = $this->validationService->getValidationApi($id);
        return response()->json(['validation' => $validation], 200);
    }
}
