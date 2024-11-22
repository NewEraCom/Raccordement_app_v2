<?php


declare(strict_types=1);

namespace App\Services\web;

use App\Models\Technicien;
use Carbon\Carbon;

class TechniciensService
{

    static function returnTechniciens($filtrage_name, $soustraitant, $status, $start_date, $end_date)
    {
        return Technicien::withCount(['affectations', 'declarations', 'blocages'])->with(['user', 'soustraitant'])
            ->when($soustraitant, function ($query, $soustraitant) {
                $query->where('soustraitant_id', '=', $soustraitant);
            })->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })->when($filtrage_name, function ($query, $filtrage_name) {
                $query->whereHas('user', function ($q) use ($filtrage_name) {
                    $q->whereRaw("CONCAT(first_name,' ',last_name) LIKE ?", '%' . trim($filtrage_name) . '%');
                });
            })
            ->orderBy('created_at', 'desc');
    }

    static function kpisTechniciens()
    {
        return [
            'total_technicien' => Technicien::count(),
            'technicien_actif' => Technicien::whereHas('user', function ($q) {
                $q->where('status', true);
            })->count(),
            'technicien_inactif' => Technicien::whereHas('user', function ($q) {
                $q->where('status', false);
            })->count(),
            'total_connecte' => Technicien::whereHas('user', function ($q) {
                $q->where('status', true)->where('device_key','!=',null);
            })->count(),
        ];
    }
}
