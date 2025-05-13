<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Blocage;

class BlocageController extends Controller
{
    public function __invoke(Blocage $blocage)
    {
        $imageOrder = [
            'Photo façade',
            'PBI (Fermé)',
            'PBI (Ouvert)',
            'Splitter 1',
            'Splitter 2',
            'PBO (Fermé)',
            'PBO (Ouvert)',
            'Splitter 3',
            'Splitter 4',
            'Chambre (Fermé)',
            'Chambre (Ouvert)',
        ];
        $pdf = PDF::loadView('blocage-report',compact('blocage','imageOrder'));
        return $pdf->download('RAPPORT_BLOCAGE_'.$blocage->affectation->client->name.'_'.$blocage->affectation->client->sip.'.pdf');
    }
}
