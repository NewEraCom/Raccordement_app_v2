<?php


declare(strict_types=1);

namespace App\Services\web;

use App\Models\Affectation;
use App\Models\Client;
use App\Models\SavTicket;
use Carbon\Carbon;

class AffectationsService
{

    static public function getAffectations($client_name, $client_status, $technicien, $start_date, $end_date, $blocage_type)
    {
        return Affectation::with(['client', 'client.city', 'technicien.user'])
            ->when($client_name, function ($q, $client_name) {
                $q->whereHas('client', function ($q) use ($client_name) {
                    $q->where('name', 'like', '%' . $client_name . '%')->orWhere('sip', 'like', '%' . $client_name . '%')->orWhereHas('city', function ($q) use ($client_name) {
                        $q->where('name', 'like', '%' . $client_name . '%');
                    });
                });
            })
            ->when($client_status, function ($q, $client_status) {
                $q->where('status', $client_status);
            })
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })
            ->when($technicien, function ($q, $technicien) {
                $q->where('technicien_id', $technicien);
            })->when($blocage_type, function ($q, $blocage_type) {
                $q->whereHas('blocages', function ($q) use ($blocage_type) {
                    $q->where('cause', $blocage_type);
                });
            })
            ->orderByDesc('updated_at');
    }
    static public function getTickets($client_name, $client_status, $technicien)
    {
        return SavTicket::with(['client', 'client.city', 'technicien.user'])
            ->when($client_name, function ($q, $client_name) {
                $q->whereHas('client', function ($q) use ($client_name) {
                    $q->where('name', 'like', '%' . $client_name . '%')->orWhere('sip', 'like', '%' . $client_name . '%')->orWhereHas('city', function ($q) use ($client_name) {
                        $q->where('name', 'like', '%' . $client_name . '%');
                    });
                });
            })
            ->when($client_status, function ($q, $client_status) {
                $q->when('statusSav', $client_status);
            })

            ->when($technicien, function ($q, $technicien) {
                $q->where('technicien_id', $technicien);
            })
            ->orderByDesc('updated_at');
    }



    public static function getAffectationsStatistic($status, $start_date, $end_date): array
    {
        return [
            'affectationsOfTheDay' => Affectation::whereDate('created_at', today())->count(),
            'totalAffectations' => Affectation::count(),
            'totalDeclaration' => Affectation::where('status', 'Declare')->count(),
            'totalNoAffecte' => Client::where('status', 'Saisie')->count(),
            'totalAffectationsEnCours' => Affectation::where('status', 'En cours')->count(),
            'totalAffectationsEnCoursOfTheDay' => Affectation::where('status', 'En cours')->whereDate('created_at', today())->count(),
            'totalAffectationsBlocked' => Affectation::where('status', 'Bloqué')->whereHas('blocages', function ($q) {
                $q->where('resolue', false);
            })->count(),
            'totalAffectationsBlockedOfTheDay' => Affectation::where('status', 'Bloqué')->whereHas('blocages', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()])->where('resolue', false);
            })->count(),
            'totalAffectationsPlanned' => Affectation::where('status', 'Planifié')->count(),
            'totalAffectationsPlannedOfTheDay' => Affectation::where('status', 'Planifié')->whereDate('planification_date', today())->count(),
            'totalAffectationsDone' => Affectation::where('status', 'Terminé')->count(),
            'totalAffectationsDoneOfTheDay' => Affectation::where('status', 'Terminé')->whereHas('declarations', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            })->count(),
            /* 'affectations' => Affectation::with('client')->when($status, function ($query, $status) {
                $query->where('status', $status);
            })->get(),            
            'affectationsOfTheDay' => Affectation::whereDate('created_at', today())->count(),
            
            'totalAffectationsPlanned' => Affectation::where('status', 'Planifié')->count(),
            
            'totalAffectationsPlannedOfTheDay' => Affectation::where('status', 'Planifié')->whereDate('planification_date', today())->count(),
             */
        ];
    }
    public static function getSavAffectationsStatistic($start_date, $end_date): array
    {
        return [
            'affectations' => SavTicket::with('client')->get(),
            'affectationsOfTheDay' => SavTicket::whereDate('created_at', today())->count(),
            'totalAffectations' => SavTicket::count(),
            'totalDeclaration' => SavTicket::where('status', 'Declare')->count(),
            'totalNoAffecte' => Client::where('status', 'Saisie')->count(),
            'totalAffectationsEnCours' => SavTicket::where('status', 'En cours')->count(),
            'totalAffectationsBlocked' => SavTicket::where('status', 'Bloqué')->whereHas('blocages', function ($q) {
                $q->where('resolue', false);
            })->count(),
            'totalAffectationsPlanned' => SavTicket::where('status', 'Planifié')->count(),
            'totalAffectationsDone' => SavTicket::where('status', 'Terminé')->count(),
            'totalAffectationsEnCoursOfTheDay' => SavTicket::where('status', 'En cours')->whereDate('created_at', today())->count(),
            'totalAffectationsBlockedOfTheDay' => SavTicket::where('status', 'Bloqué')->whereHas('blocages', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()])->where('resolue', false);
            })->count(),
            // 'totalAffectationsPlannedOfTheDay' => SavTicket::where('status', 'Planifié')->whereDate('planification_date', today())->count(),
            // 'totalAffectationsDoneOfTheDay' => SavTicket::where('status', 'Terminé')->whereHas('declarations', function ($query) use ($start_date, $end_date) {
            //     $query->whereBetween('created_at', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->endOfDay()]);
            // })->count(),
        ];
    }

    public static function attachUnique()
    {
    }
}
