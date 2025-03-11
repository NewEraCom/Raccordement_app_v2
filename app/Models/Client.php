<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'uuid',
            'client_id',
            'type',
            'offre',
            'name',
            'address',
            'lat',
            'lng',
            'city_id',
            'plaque_id',
            'phone_no',
            'debit',
            'sip',
            'technicien_id', 
            'status',
            'created_by',
            'type',
            'routeur_type',
            'created_at',
            'phase_one',
            'statusSav',
            'phase_two',
            'phase_three',
            'flagged',
            'controler_client_id',
            'promoteur',
            'type_affectation'
    ];

    public function getFullname()
    {
        return $this->name;
    }

    public function feedback()
    {
        return $this->hasOne(ControlerClient::class, 'client_id');
    }

    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }

    public function savTicket()
    {
        return $this->hasMany(SavTicket::class);
    }

    public function declarations()
    {
        return $this->hasManyThrough(Declaration::class, Affectation::class);
    }

    public function validations()
    {
        return $this->hasManyThrough(Validation::class, Affectation::class);
    }

    public function blocages()
    {
        return $this->hasManyThrough(Blocage::class, Affectation::class);
    }

    public function affectationsHistorique()
    {
        return $this->hasManyThrough(AffectationHistory::class, Affectation::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function plaque()
    {
        return $this->belongsTo(Plaque::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function technicien()
    {
        return $this->belongsTo(Technicien::class);
    }
    public function sousTraitant()
    {
        return $this->belongsTo(Soustraitant::class);
    }

    public function routeur()
    {
        return $this->hasOne(Routeur::class);
    }

    public function getStatusColor()
    {
        $data = 'success';
        switch ($this->status) {
            case 'Saisie':
                $data = 'primary';
                break;
            case 'Créé':
                $data = 'primary';
                break;
            case 'Bloqué':
                $data = 'danger';
                break;
            case 'Affecté':
                $data = 'warning';
                break;
            case 'Déclaré':
                $data = 'danger';
                break;
            case 'Validé':
                $data = 'success';
                break;
            default:
                $data = 'dark';
                break;
        }
        return $data;
    }
    public function getStatusSavColor()
    {
        $data = 'success';
        switch ($this->status) {
            case 'Down':
                $data = 'primary';
                break;
            case 'Affecté':
                $data = 'warning';
                break;
            case 'Connecté':
                $data = 'success';
                break;

            default:
                $data = 'warning';
                break;
        }
        return $data;
    }

    public function returnPhoneNumber()
    {
        $input = $this->phone_no;
        return substr($input, 0, 2) . ' ' . substr($input, 2, 2) . ' ' . substr($input, 4, 2) . ' ' . substr($input, 6, 2) . ' ' . substr($input, 8, 2);
    }

    public function relance()
    {
        if ($this->status == 'Validé') {
            return false;
        }
        return true;
    }

    public function reportsFeedback()
    {
        return $this->hasMany(FeedbackRapport::class);
    }
}
