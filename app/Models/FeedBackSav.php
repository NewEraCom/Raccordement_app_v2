<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBackSav extends Model
{
    use HasFactory;
    protected $table = "feedback_sav";
    protected $fillable = ['sav_ticket_id', 'root_cause', 'unite', 'type', 'before_picture', 'after_picture'];
    public function savTicket()
    {
        return $this->belongsTo(SavTicket::class);
    }
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
}
