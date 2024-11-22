<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soustraitant extends Model
{
    use HasFactory, SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = [
        'uuid',
        'name',
    ];

    public function techniciens()
    {
        return $this->hasMany(Technicien::class);
    }

    public function clients()
    {
        return $this->hasManyThrough(Client::class, Technicien::class);
    }

    public function affectations()
    {
        return $this->hasManyThrough(Affectation::class, Technicien::class)->whereMonth('affectations.created_at', now()->month)->whereYear('affectations.created_at', now()->year);
    }    

    public function dailyAffectations()
    {
        return $this->hasMany(Affectation::class)->whereDate('affectations.created_at', today());
    }

    public function declarations()
    {
        return $this->hasManyDeep(Declaration::class, [Technicien::class, Affectation::class])->whereMonth('affectations.created_at', now()->month)->whereYear('affectations.created_at', now()->year);
    }

    public function blocages()
    {
        return $this->hasManyDeep(Blocage::class, [Technicien::class, Affectation::class])->whereMonth('affectations.created_at', now()->month)->whereYear('affectations.created_at', now()->year)->where('affectations.status', 'Bloqué');
    }

    public function dailyBlocages()
    {
        return $this->hasManyDeep(Blocage::class, [Technicien::class, Affectation::class])->whereDate('blocages.created_at',today())->where('blocages.resolue', '0');
    }

    public function planifications()
    {
        return $this->hasManyThrough(Affectation::class, Technicien::class)->where('affectations.status', 'Planifié')->whereMonth('affectations.created_at', now()->month)->whereYear('affectations.created_at', now()->year);
    }

    public function dailyPlanifications()
    {
        return $this->hasManyThrough(Affectation::class, Technicien::class)->where('affectations.status', 'Planifié')->whereDate('affectations.planification_date', today());
    }

    public function totalAffectations()
    {
        return $this->hasManyThrough(Affectation::class, Technicien::class);
    }

    public function totalDeclaration()
    {
        return $this->hasManyDeep(Declaration::class, [Technicien::class, Affectation::class]);
    }
    
    public function totalClientDone()
    {
        return $this->hasManyDeep(Validation::class, [Technicien::class, Affectation::class])->whereDate('validations.created_at',today());
    }

    public function stock(){
        return $this->hasOne(SoustraitantStock::class);
    }

    public function stockDemands(){
        return $this->hasMany(SoustraitantStockDemand::class);
    }
    public function totalTickets()
    {
        return $this->hasMany(SavTicket::class)->where('status','En cours');
    }
   

    public function totalconnected()
    {
        return $this->hasMany(SavTicket::class)->where('status','Validé');
    }
    public function blocages_sav()
    {
        return $this->hasMany(SavTicket::class)->where('status','Bloqué');
    }
   

    


}
