<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Routeur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'sn_gpon',
        'sn_mac',
        'status',
        'client_id',
        'technicien_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function technicien()
    {
        return $this->belongsTo(Technicien::class);
    }

    public function returnClientSip()
    {
        return $this->client->sip ?? '-';
    }

    public function returnClientName()
    {
        return $this->client->name ?? '-';
    }

    public function returnTechnicienName()
    {
        return $this->technicien ?  $this->technicien->user->getFullname() : '-';
    }

    public function getStatusColor()
    {
        $data = 'success';
        switch ($this->status) {
            case 1:
                $data = 'success';
                break;
            case 0:
                $data = 'warning';
                break;
            case 2:
                $data = 'danger';
                break;
            default:
                $data = 'dark';
                break;
        }
        return $data;
    }
}
