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
        'test_debit_via_cable',
        'test_debit_via_wifi',
        // 'test_debit_image',
        // 'test_debit_via_cable_image',
        // 'photo_test_debit_via_wifi_image',
        // 'etiquetage_image',
        // 'fiche_installation_image',
        'affectation_id',
        // 'router_tel_image',
        'pv_image_url',
        'lat',
        'lng',
        'cin_justification',
        'cin_description',
        // 'image_cin',
        'feedback_bo',
        'test_debit_image_url',
        'test_debit_via_cable_image_url',
        'photo_test_debit_via_wifi_image_url',
        'etiquetage_image_url',
        'fiche_installation_image_url',
        'image_cin_url',
        'router_tel_image_url',

    ];
}
