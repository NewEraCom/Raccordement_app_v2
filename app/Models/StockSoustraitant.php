<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSoustraitant extends Model
{
    use HasFactory;

    public function soustraitant()
    {
        return $this->belongsTo(Soustraitant::class);
    }
}
