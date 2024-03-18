<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
    ];

    // public function competonces()
    // {
    //     return $this->belongsToMany(Competonce::class);
    // }

    public function competonces()
    {
        return $this->belongsToMany(Competonce::class , 'skills_users'  ,'user_id' , 'competonce_id' );
    }

    public function project()
    {
        return $this->hasMany(Project::class ,'user_id');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class ,'freelancer_id');
    }

  

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
        'password' => 'hashed',
    ];
}
