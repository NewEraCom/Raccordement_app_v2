<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlocageSav extends Model
{
    use HasFactory;
    protected $table = 'blocages_sav';

    protected $fillable = ['sav_ticket_id', 'cause', 'justification','comment','resolue'];
    
    public function savTicket()
    {
        return $this->belongsTo(SavTicket::class);
    }
    public function pictures()
    {
        return $this->hasMany(BlocageSavPictures::class, 'blocage_sav_id');
    }
}
