<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'code',
        'status',
        'compteur',
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function plaques()
    {
        return $this->hasMany(Plaque::class);
    }
    public function clientsav()
    {
        return $this->hasMany(ClientSav::class);
    }

    public function techniciens()
    {
        return $this->belongsToMany(Technicien::class, 'technicien_cities');
    }

     public function declarations()
    {
        return $this->hasManyDeep(Declaration::class,[Client::class, Affectation::class]);
    }

    public function validations()
    {
        return $this->hasManyDeep(Validation::class,[Client::class, Affectation::class]);
    }

    public function blocages()
    {
        return $this->hasManyDeep(Blocage::class,[Client::class, Affectation::class]);
    }
}
