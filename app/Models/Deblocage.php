<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deblocage extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'affectation_id',
        'photo_spliter_before',
        'photo_spliter_after',
        'photo_facade',
        'photo_chambre',
        'photo_signal',
         'lat',
        'lng'
        
    ];
}
