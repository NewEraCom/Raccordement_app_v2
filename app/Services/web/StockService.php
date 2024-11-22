<?php

declare(strict_types=1);

namespace App\Services\web;

use App\Models\NewStock;
use App\Models\StockHistory;
use App\Models\SoustraitantStock;
use App\Models\SoustraitantStockDemand;
use App\Models\StockSav;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StockService
{

    public static function KpisStock(): array
    {

        $stock = SoustraitantStockDemand::select(DB::raw('SUM(pto) as pto'), DB::raw('SUM(f680) as f680'),DB::raw('SUM(f6600) as f6600'), DB::raw('SUM(cable) as cable'), DB::raw('SUM(fix) as fix'), DB::raw('SUM(splitter) as splitter'), DB::raw('SUM(jarretiere) as jarretiere'))
            ->where('status', 0)
            ->first();
        return [
            'pto' => $stock->pto ?? 0,
            'f680' => $stock->f680 ?? 0,
            'f6600' => $stock->f6600 ?? 0,
            'jarretiere' => $stock->jarretiere ?? 0,
            'splitter' => $stock->splitter ?? 0,
            'cable' => $stock->cable ?? 0,
            'fix' => $stock->fix ?? 0,
        ];
    }

    public static function getStock($soustraitant, $status, $start_date, $end_date)
    {
        return SoustraitantStockDemand::with('soustraitant')->when($soustraitant, function ($query) use ($soustraitant) {
            $query->where('soustraitant_id', $soustraitant);
        })->when($status, function ($query) use ($status) {
            $query->where('status', $status == 'NaN' ? 0 : 1);
        })->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
        });
    }

    public static function getDetailsStock()
    {
        $stock = NewStock::select(DB::raw('SUM(pto) as pto'), DB::raw('SUM(f680) as f680'), DB::raw('SUM(f6600) as f6600'), DB::raw('SUM(jarretiere) as jarretiere'), DB::raw('SUM(cable) as cable'), DB::raw('SUM(fix) as fix'), DB::raw('SUM(splitter) as splitter'))
            ->get();
        return [
            'pto' => $stock[0]->pto ?? 0,
            'f680' => $stock[0]->f680 ?? 0,
            'f6600' => $stock[0]->f6600 ?? 0,
            'jarretiere' => $stock[0]->jarretiere ?? 0,
            'cable' => $stock[0]->cable ?? 0,
            'splitter' => $stock[0]->splitter ?? 0,
            'fix' => $stock[0]->fix ?? 0,
        ];
    } 

    public static function getSoustraitantStock($soustraitant)
    {
        return SoustraitantStock::with('soustraitant')->when($soustraitant, function ($query) use ($soustraitant) {
            $query->whereHas('soustraitant', function ($query) use ($soustraitant) {
                $query->where('name', 'like', '%' . $soustraitant . '%');
            });
        })->paginate(25);
    }


    public static function getSoustraitantStockSav($soustraitant)
    {
        return StockSav::with('soustraitant')->when($soustraitant, function ($query) use ($soustraitant) {
            $query->whereHas('soustraitant', function ($query) use ($soustraitant) {
                $query->where('name', 'like', '%' . $soustraitant . '%');
            });
        })->paginate(25);
    }

    static function StockHistoric($start_date, $end_date): array
    {

        $stock = StockHistory::select(DB::raw('SUM(pto) as pto'), DB::raw('SUM(routeur) as routeur'), DB::raw('SUM(cable_indoor) as cable_indoor'), DB::raw('SUM(cable_outdoor) as cable_outdoor'), DB::raw('SUM(splitter) as splitter'), DB::raw('SUM(jarretier) as jarretier'), DB::raw('SUM(fix) as fix'))
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })
            ->get();

        return [
            'pto' => $stock[0]->pto ?? 0,
            'routeur' => $stock[0]->routeur ?? 0,
            'jarretier' => $stock[0]->jarretier ?? 0,
            'splitter' => $stock[0]->splitter ?? 0,
            'cable_indoor' => $stock[0]->cable_indoor ?? 0,
            'cable_outdoor' => $stock[0]->cable_outdoor ?? 0,
            'fix' => $stock[0]->fix ?? 0,
        ];
    }

    static function GetStockHistoric($start_date, $end_date)
    {
        return StockHistory::when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
        })->orderBy('created_at','DESC')->paginate(25);
    }
}
