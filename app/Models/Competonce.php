<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competonce extends Model
{
    use HasFactory;

    protected $table = 'competonces';

    public function user()
    {
        return $this->belongsToMany(User::class , 'skills_users', 'competonce_id'  ,'user_id'  );
    }

    
}
