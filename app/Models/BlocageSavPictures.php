<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlocageSavPictures extends Model
{
    use HasFactory;

    protected $fillable = ['blocage_sav_id', 'description', 'attachement'];
    public function blocageSav()
    {
        return $this->belongsTo(BlocageSav::class);
    }
}
