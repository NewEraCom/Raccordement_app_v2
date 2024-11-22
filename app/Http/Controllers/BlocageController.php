<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Blocage;

class BlocageController extends Controller
{
    public function __invoke(Blocage $blocage)
    {
        $pdf = PDF::loadView('blocage-report',compact('blocage'));

        return $pdf->download('RAPPORT_BLOCAGE_'.$blocage->affectation->client->name.'_'.$blocage->affectation->client->sip.'.pdf');
    }
}
