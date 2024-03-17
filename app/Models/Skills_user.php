<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'competonce_id',
    ];

   
}
