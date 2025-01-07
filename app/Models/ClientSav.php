<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSav extends Model
{
    use HasFactory;

    protected $table = 'sav_client';

    // Attributs qui peuvent être remplis en masse (Mass Assignment)
    protected $fillable = [
        'n_case',             
        'login',               
        'sip',                 
        'address',           
        'client_name',       
        'contact',          
        'date_demande',      
        'city_id',           
        'plaque_id',          
        'lat',                 
        'lng',                 
        'comment',             
        'service_activities', 
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function plaque()
    {
        return $this->belongsTo(Plaque::class);
    }

}
