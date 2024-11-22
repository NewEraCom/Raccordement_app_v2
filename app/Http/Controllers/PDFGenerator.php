<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Client;


class PDFGenerator extends Controller
{
    public function __invoke(Client $client)
    {
        $pdf = PDF::loadView('pdf-rapport',compact('client'));

        return $pdf->download('RAPPORT_'.$client->name.'_'.$client->sip.'.pdf');
    }
}
