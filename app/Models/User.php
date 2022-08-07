<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Trip;
use App\Models\Livetrip;
use App\Models\Tripdata;
use App\Models\Car;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dateBirth',
        'gender',
        'address',
        'username',
        'permis',
        'image'
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

    public function trips(){
        return $this->hasMany(Trip::class);
    }

    public function livetrips(){
        return $this->hasMany(Livetrip::class);
    }

    public function tripdatas(){
        return $this->hasMany(Tripdata::class);
    }

    public function cars(){
        return $this->hasMany(Car::class);
    }

    public function sendPasswordResetNotification($token)
{
    $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
}
}
