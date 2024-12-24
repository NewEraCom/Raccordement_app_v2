<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'data',
        'user_id',
        'affectation_id'
    ];
    
    
       public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function affectation()
{
    return $this->belongsTo(Affectation::class);
}
}
