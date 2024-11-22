<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Affectation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'client_id',
        'technicien_id',
        'planification_date',
        'status',
        'validation_complet',
        'blocage',
        'nb_modification_planification',
        'lat',
        'lng',
        'affected_by',
        'soustraitant_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    
    public function blocage()
    {
        return $this->belongsTo(Blocage::class);
    }
    
    public function blocages()
    {
        return $this->hasMany(Blocage::class);
    }
    
    public function declarations()
    {
        return $this->hasMany(Declaration::class);
    }

    public function history()
    {
        return $this->hasMany(AffectationHistory::class);
    }

    public function technicien()
    {
        return $this->belongsTo(Technicien::class);
    }

    public function getStatusColor()
    {
        $data = 'success';
        switch ($this->status) {
            case 'En cours':
                $data = 'primary';
                break;
                case 'Affecté':
                    $data = 'warning';
                    break;
            case 'Planifié':
                $data = 'warning';
                break;
            case 'Bloqué':
                $data = 'danger';
                break;
            case 'Terminé':
                $data = 'success';
                break;
            default:
                $data = 'dark';
                break;
        }
        return $data;
    }

    public function affectedBy(){
        return $this->belongsTo(User::class,'affected_by');
    }

    public function soustraitant(){
        return $this->belongsTo(Soustraitant::class, 'soustraitant_id');
    }
    
}
