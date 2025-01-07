<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavTicket extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'client_id',
        'id_case',
        'type',
        'description',
        'debit',
        'technicien_id',
        'soustraitant_id',
        'status',
        'service_activity',
        'created_at',
        'updated_at',
        'deleted_at',
        'affected_by',
        'planification_date',
        
    ];
    public function client(){
        return $this->belongsTo(ClientSav::class, 'client_id');
    }

    public function clientSav(){
        return $this->belongsTo(SavClient::class,'sav_client_id');
    }

    public function blocage()
    {
        return $this->belongsTo(Blocage::class);
    }

    public function blocages()
    {
        return $this->hasMany(Blocage::class);
    }
    // public function technicien(){
    //     return $this->belongsTo(Technicien::class , 'technicien_id');
    // }

    public function technicien()
    {
        return $this->belongsTo(Technicien::class);
    }
    public function sousTraitant(){
        return $this->belongsTo(Soustraitant::class , 'soustraitant_id');
    }


    public function getStatusColor()
    {
        $data = 'success';
        switch ($this->status) {
            case 'En cours':
                $data = 'primary';
                break;
            case 'Planifié':
                $data = 'warning';
                break;
            case 'Bloqué':
                $data = 'danger';
                break;
            case 'Terminé':
                $data = 'success';
                break;
            default:
                $data = 'dark';
                break;
        }
        return $data;
    }
    public function affectedBy(){
        return $this->belongsTo(User::class,'affected_by');
    }

    public function feedback(){
        return $this->hasMany(feedback::class);
    }
    public function savhistories(){
        return $this->hasMany(Savhistory::class,'savticket_id','id');
    }
}



