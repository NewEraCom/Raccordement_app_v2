<?php

declare(strict_types=1);

namespace App\Services\web;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;

class CitiesServices
{
    public static function getCityData($id, $date)
    {
        return [
            'clients' => Client::where('city_id', $id)->count(),
            'clients_of_the_day' => Client::where('city_id', $id)->whereDate('created_at', today())->count(),
            'clients_delcare' => Client::where('city_id', $id)->whereHas('declarations', function (Builder $query) use ($date) {
                $query->whereBetween('declarations.created_at', $date);
            })->count(),
            'clients_delcare_of_the_day' => Client::where('city_id', $id)->whereHas('declarations', function (Builder $query) {
                $query->whereDate('declarations.created_at', today());
            })->orWhereHas('validations', function (Builder $query) {
                $query->whereDate('validations.created_at', today());
            })->count(),
            'clients_bloque' => Client::where('city_id', $id)->whereHas('blocages', function (Builder $query) use ($date) {
                $query->whereBetween('blocages.created_at', $date);
            })->count(),
            'clients_bloque_of_the_day' => Client::where('city_id', $id)->whereHas('blocages', function (Builder $query) {
                $query->whereDate('blocages.created_at', today());
            })->count(),
            'clients_filtre' => Client::where('city_id',$id)->whereBetween('created_at', $date)->count(),
            'pipe_city' => Client::where('city_id', $id)->whereIn('status', ['Saisie', 'Affecté'])->count(),
            'pipe_city_filtre' => Client::where('city_id', $id)->whereBetween('created_at', $date)->whereIn('status', ['Saisie', 'Affecté'])->count(),
        ];
    }
}
