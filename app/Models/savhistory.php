<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Savhistory extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        'savticket_id',
        'technicien_id',
        'soustraitant_id',
        'status',
        'description',
    ];
    public function soustraitant()
    {
        return $this->belongsTo(Soustraitant::class, 'soustraitant_id');
    }
    
    public function technicien(){
        return $this->belongsTo(Technicien::class);
    }

    public function Ticket(){
        return $this->belongsTo(SavTicket::class);
    }

    public function getStatusSavColor($status){
        $data = 'success';
        switch ($status) {
            case 'Affecté':
                $data = 'warning';
                break;
                
            case 'En cours':
                $data = 'info';
                break;
                    
            case 'Planifié':
                $data = 'warning';
                break;
            case 'Bloqué':
                $data = 'danger';
                break;
            case 'Validé':
                $data = 'success';
                break;
            default:
                $data = 'dark';
                break;
            case 'Saisie': 
                $data = 'primary'; 
                break;
        }
        return $data;
    }
}
