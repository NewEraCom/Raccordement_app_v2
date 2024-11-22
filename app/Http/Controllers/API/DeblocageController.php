<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\API\DeblocageService;


class DeblocageController extends Controller
{
    protected $deblocageService;

    public function __construct(DeblocageService $deblocageService)
    {
        $this->deblocageService = $deblocageService;
    }
    public function deblocage(Request $request)
    {
        
        $deblocage = $this->deblocageService->deblocage($request);
        return response()->json(['Deblocage' => $deblocage], 200);
    }
 
    
    
   
}
