<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavClient extends Model
{
    use HasFactory;

    protected $table = 'sav_client';


    protected $fillable = [
        'id',
        'n_case',
        'sip',
        'login',
        'address',
        'client_name',
        'contact',
        'date_demande',
        'city_id',
        'plaque_id',
        'created_at',
        'updated_at',
    ];


    public function returnPhoneNumber()
    {
        $input = $this->contact;
        return substr($input, 0, 2) . ' ' . substr($input, 2, 2) . ' ' . substr($input, 4, 2) . ' ' . substr($input, 6, 2) . ' ' . substr($input, 8, 2);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function plaque()
    {
        return $this->belongsTo(Plaque::class);
    }



}
