<?php

namespace App\Services\web;

use App\Models\Affectation;
use App\Models\Blocage;
use App\Models\Client;
use Carbon\Carbon;

class ClientsSupervisorService
{
    static function index($start_date, $end_date, $search, $status)
    {
        return Client::with(['city','technicien'])->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
        })->when($search, function ($query) use ($search) {
            $query->where('phone_no', 'like', '%' . $search . '%')->orWhere('sip', 'like', '%' . $search . '%')->orWhereHas('city', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        })->when($status,function($query) use ($status){
            $query->where('status',$status);
        })->orderBy('created_at', 'desc');
    }

    static function countClient($start_date, $end_date)
    {
        return Client::with(['city'])->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
        })->orderBy('created_at', 'desc');
    }

    static function blocage($start_date, $end_date)
    {
        return [
            'problemTechnique' => Blocage::where('resolue', false)->whereIn('cause', ['Câble transport dégradés ', 'Manque Cable transport', 'Gpon saturé', 'Non Eligible', 'Cabel transport saturé', 'Splitter saturé', 'Pas Signal'])->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()])->count(),
            'problemClient' => Blocage::where('resolue', false)->whereIn('cause', ['Demande en double','Adresse erronée', 'Blocage de passage coté appartement', 'Blocage de passage coté Syndic', 'Client a annulé sa demande', 'Contact Erronee', 'Indisponible', 'Injoignable/SMS', 'Manque ID'])->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()])->count(),
            'affectationsPlanned' => Affectation::where('status', 'Planifié')->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()])->count(),
        ];
    }
}
