<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;
     protected $fillable = [
        'id',
        'uuid',
        'test_debit',
        'test_debit_image',
        'test_debit_via_cable_image',
        'photo_test_debit_via_wifi_image',
        'etiquetage_image',
        'fiche_installation_image',
        'affectation_id',
        'router_tel_image',
        'pv_image',
        'lat',
        'lng',
        'cin_justification',
        'cin_description',
        'image_cin',
        'feedback_bo',
    ];
}
