<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackRapport extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'feedback',
        'note',
        'created_by',
    ];
}
