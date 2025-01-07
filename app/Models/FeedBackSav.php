<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBackSav extends Model
{
    use HasFactory;
    protected $fillable = ['sav_ticket_id', 'root_cause', 'unite', 'type', 'before_picture', 'after_picture'];
    public function savTicket()
    {
        return $this->belongsTo(SavTicket::class);
    }
}
