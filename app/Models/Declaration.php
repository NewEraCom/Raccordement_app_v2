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
        'image_test_signal',
        'image_pbo_before',
        'image_pbo_after',
        'image_pbi_after',
        'image_pbi_before',
        'image_splitter',
        'type_passage',
        'image_passage_1',
        'image_passage_2',
        'image_passage_3',
        'sn_telephone',
        'nbr_jarretieres',
        'cable_metre',
        'pto',
        'routeur_id',
        'lat', 
        'lng',
        'cin_justification',
        'image_cin',
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
