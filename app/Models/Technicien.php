<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technicien extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'soustraitant_id',
        'user_id',
        'city_id',
        'planification_count',
        'player_id',
        'type_tech',
        'conteur',
    ];


    protected $appends = ['counter'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function soustraitant()
    {
        return $this->belongsTo(Soustraitant::class);
    }

    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }

    public function tickets()
    {
        return $this->hasMany(SavTicket::class);
    }

    public function declarations()
    {
        return $this->hasManyThrough(Declaration::class, Affectation::class);
    }

    public function blocages()
    {
        return $this->hasManyThrough(Blocage::class, Affectation::class);
    }

    public function plaques()
    {
        return $this->belongsToMany(Plaque::class, 'plaque_techniciens');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function cityAndSoustraitant()
    {
        return $this->city->name . ' - ' . $this->soustraitant->name;
    }


    public function getCounterAttribute()
    {

        return  Affectation::where("technicien_id", $this->id)->where("status", "En cours")->count();
    }

    public function routeurs()
    {
        return $this->hasMany(Routeur::class);
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'technicien_cities');
    }

    public function logs()
    {
        return $this->hasMany(TechnicienLog::class);
    }

    public function clientSaisie()
    {
        return $this->hasManyThrough(Affectation::class, Client::class)->where('affectations.status', 'En cours');
    }

    public function planifications()
    {
        return $this->hasManyThrough(Affectation::class, Client::class)->where('affectations.status', 'Planifié');
    }

    public function getStatus()
    {
        $status = ['danger', 'Racco'];

        switch ($this->type_tech) {
            case 1:
                $status = ['danger', 'Racco'];
                break;
            case 2:
                $status = ['success', 'SAV'];
                break;
            case 3:
                $status = ['warning', 'Racco/SAV'];
                break;
            default:
            $status = ['primary', 'Null'];
            break;
        }

        return $status;
    }

}
