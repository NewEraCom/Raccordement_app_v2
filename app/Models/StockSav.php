<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSav extends Model
{
    use HasFactory;

    protected $fillable = [
        'soustraitant_id',
        'f680',
        'f6600',
        'pto',
        'cable',
        'fix',
        'jarretiere',
        'splitter',
        'racco',
    ];

    public function soustraitant()
    {
        return $this->belongsTo(Soustraitant::class);
    }
}
