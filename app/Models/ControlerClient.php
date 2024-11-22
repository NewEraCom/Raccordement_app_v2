<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlerClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'note',
        'comment',
        'second_comment',
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
