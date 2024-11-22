<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plaque extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'city_id',
        'code_plaque',
        'status',
        'is_ppi',
        'created_at',
        'updated_at',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function techniciens()
    {
        return $this->belongsToMany(Technicien::class, 'plaque_techniciens');
    }
}
