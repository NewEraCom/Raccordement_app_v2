<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Declaration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'uuid',
        'affectation_id',
        'test_signal',
        'image_test_signal_url',
        'image_pbo_before_url',
        'image_pbo_after_url',
        'image_pbi_after_url',
        'image_pbi_before_url',
        'image_splitter_url',
        'type_passage',
        'image_passage_1_url',
        'image_passage_2_url',
        'image_passage_3_url',
        'sn_telephone',
        'nbr_jarretieres',
        'cable_metre',
        'pto',
        'routeur_id',
        'lat',
        'lng',
        'cin_justification',
        'image_cin_url',
        'feedback_bo',
        'type_routeur'

    ];

    public function affectation()
    {
        return $this->belongsTo(Affectation::class);
    }

    public function routeur()
    {
        return $this->belongsTo(Routeur::class);
    }
}
