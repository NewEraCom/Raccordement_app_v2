<?php

declare(strict_types=1);

namespace App\Services\web;

use App\Models\Routeur;
use App\Models\Soustraitant;
use Carbon\Carbon;

class RouteursService
{
    public static function returnRouteurs($routeur_status, $start_date, $end_date, $routeur,$client)
    {
        return Routeur::with(['client', 'technicien.soustraitant'])
            ->when((int)$routeur_status, function ($query, $routeur_status) {
                return $query->where('status', (int)$routeur_status);
            })
            ->when($routeur, function ($query, $routeur) {
                return $query->where('sn_gpon', 'LIKE', '%' . $routeur . '%')->orWhere('sn_mac', 'LIKE', '%' . $routeur . '%');
            })
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })
            ->when($client, function ($query, $client) {
                return $query->whereHas('client', function ($query) use ($client) {
                    return $query->where('name', 'LIKE', '%' . $client . '%')->orWhere('sip','LIKE', '%' . $client . '%');
                });
            })
            ->orderBy('created_at', 'desc');
    }

    public static function kpisRouteurs()
    {
        return [
            'total' => Routeur::count(),
            'total_active' => Routeur::where('status', 1)->count(),
            'total_inactive' => Routeur::where('status', 0)->count(),
            'total_need_verification' => Routeur::where('status', 2)->count(),
        ];
    }
}
