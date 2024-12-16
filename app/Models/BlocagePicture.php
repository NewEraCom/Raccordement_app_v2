<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlocagePicture extends Model
{
    use HasFactory;


    protected $fillable = [
        'uuid',
        'image',
        'image_data',
        'image_url',
        'blocage_id'
    ];
}
