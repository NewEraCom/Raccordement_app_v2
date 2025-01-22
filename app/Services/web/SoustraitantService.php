<?php

declare(strict_types=1);

namespace App\Services\web;

use App\Enums\ClientStatusEnum;
use App\Models\Client;
use App\Models\SavTicket;
use Carbon\Carbon;

class SoustraitantService
{
    static public function KpisSoustraitant($start_date, $end_date, $id, $city_id): array
    {
        $clients = Client::whereHas('technicien.soustraitant', function ($query) use ($id) {
            $query->where('id', $id);
        });

        return [
            'declarations' => $clients->where('status', 'Déclaré')->count(),
            'blocages' => $clients->whereHas('affectations', function ($query) {
                $query->where('status', 'Bloqué');
            })->count(),

            'clientsByDate' => Client::whereHas('technicien.soustraitant', function ($query) use ($id) {
                $query->where('id', $id);
            })->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })->when($city_id, function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            })->count(),

            'clientDeclarationByDate' => Client::when($city_id, function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            })->whereHas('technicien.soustraitant', function ($query) use ($id) {
                $query->where('id', $id);
            })->where('status', 'Déclaré')->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()])->count(),

            'clientValidationByDate' => Client::when($city_id, function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            })->whereHas('technicien.soustraitant', function ($query) use ($id) {
                $query->where('id', $id);
            })->where('status', 'Validé')->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })->when($city_id, function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            })->count(),

            'clientBlockedByDate' => Client::whereHas('technicien.soustraitant', function ($query) use ($id) {
                $query->where('id', $id);
            })->whereHas('affectations', function ($query) {
                $query->where('status', 'Bloqué');
            })->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })->when($city_id, function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            })->count(),
        ];
    }

    static public function returnClientSoustraitant($start_date, $end_date, $id, $city_id, $search = null)
    {
        return Client::with('city', 'technicien', 'technicien.user')
            ->whereHas('technicien.soustraitant', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })
            ->when($city_id, function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('phone_no', 'like', "%{$search}%")
                          ->orWhere('client_id', 'like', "%{$search}%")
                          ->orWhere('sip', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
    
    static public function returnClientSoustraitantSAV($start_date, $end_date, $id, $search_term = null)
    {
        return SavTicket::with('technicien', 'technicien.user', 'client.city')
            ->where('soustraitant_id', $id)
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })
            ->when($search_term, function ($q) use ($search_term) {
                $q->where(function ($query) use ($search_term) {
                    $query->where('id_case', 'like', "%{$search_term}%")
                          ->orWhereHas('client', function ($subQuery) use ($search_term) {
                              $subQuery->where('client_name', 'like', "%{$search_term}%")
                                       ->orWhere('contact', 'like', "%{$search_term}%")
                                       ->orWhere('address', 'like', "%{$search_term}%");
                          });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
}
