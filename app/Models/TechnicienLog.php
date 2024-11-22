<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicienLog extends Model
{
    use HasFactory;
    
       protected $fillable = [
        'technicien_id',
        'lat',
        'lng',
        'nb_affectation',
        'build'
    ];

    public function technicien(){
        return $this->belongsTo(Technicien::class);
    }
}
