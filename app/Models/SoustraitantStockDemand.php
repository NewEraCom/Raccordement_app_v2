<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoustraitantStockDemand extends Model
{
    use HasFactory;

    protected $fillable = [
        'soustraitant_id',
        'created_by',
        'validate_by',
        'pto',
        'f680',
        'f6600',
        'cable',
        'jarretiere',
        'fix',
        'splitter',
        'validation_date',
        'status',
    ];

    public function soustraitant()
    {
        return $this->belongsTo(Soustraitant::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }    

    public function validatedBy(){
        return $this->belongsTo(User::class, 'validate_by');
    }
}
