<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use App\Models\Affectation;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'phone_no',
        'profile_picture',
        'device_key',
        'status',
        'email',
        'password',
        'technicien_id',
        'soustraitant_id',
        'is_online',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'counter'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getUserRole()
    {
        return Str::upper($this->roles->first()->name);
    }

    public function getCounterAttribute()
    {
        return Affectation::where("technicien_id", $this->technicien_id)->where("status", "En cours")->count();
    }

    public function technicien()
    {
        return $this->hasOne(Technicien::class);
    }

    public function returnPhoneNumber()
    {
        $input = $this->phone_no;
        return substr($input, 0, 2) . ' ' . substr($input, 2, 2) . ' ' . substr($input, 4, 2) . ' ' . substr($input, 6, 2) . ' ' . substr($input, 8, 2);
    }
}
