<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlocageSav extends Model
{
    use HasFactory;

    protected $fillable = ['sav_ticket_id', 'cause', 'justification','comment','resolue'];
    
    public function savTicket()
    {
        return $this->belongsTo(SavTicket::class);
    }
}
