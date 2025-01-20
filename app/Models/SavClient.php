<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavClient extends Model
{
    use HasFactory;

    protected $table = 'sav_client';


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
        'status',
        'created_by',
        'cause',
        'address_installation'
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
    public function getStatusSavColor()
    {
        switch ($this->status) { 
            case 'Affecté':
                return 'warning';
            case 'Saisie':
                return 'primary';
            case 'En cours':
                return 'info';
            case 'Planifié':
                return 'warning';
            case 'Validé':
                return 'success';
            case 'Bloqué':
                return 'danger';
            default:
                return 'secondary';
        }
    }
    public function savTickets()
    {
        return $this->hasMany(SavTicket::class, 'client_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function relance()
    {
        if ($this->status == 'Validé') {
            return false;
        }
        return true;
    }


}
