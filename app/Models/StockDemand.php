<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDemand extends Model
{
    use HasFactory;

    protected $fillable = [
        'soustraitant_id',
        'created_by',
        'pto',
        'routeur',
        'cable_indoor',
        'cable_outdoor',
        'splitter',
        'jarretier',
        'type_jarretier',
        'fix',
    ];

    public function soustraitant()
    {
        return $this->belongsTo(Soustraitant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
