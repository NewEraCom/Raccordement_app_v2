<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'description','test_signal','image_facultatif','type','type_blockage','sav_ticket_id'

    ];

    public function getStatusSavColor($status){
        $data = 'success';
        switch ($status) {
            case 'Down':
                $data = 'primary';
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
        }
        return $data;
    }
    public function savTicket()
    {
        return $this->belongsTo(SavTicket::class,'sav_ticket_id');
    }

}
