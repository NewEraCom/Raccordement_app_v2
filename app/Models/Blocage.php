<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blocage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'affectation_id',
        'sav_ticket_id',
        'cause',
        'lat',
        'lng',
        'justification',
        'resolue',
        'gps_link'
    ];

    public function affectation()
    {
        return $this->belongsTo(Affectation::class);
    }
    public function savTicket()
    {
        return $this->belongsTo(SavTicket::class);
    }

    public function blocagePictures()
    {
        return $this->hasMany(BlocagePicture::class);
    }

    public function client()
    {
        return $this->hasOneThrough(Client::class, Affectation::class);
    }
}
