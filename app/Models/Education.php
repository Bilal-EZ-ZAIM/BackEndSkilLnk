<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'ecole',
        'description',
        'date_debut',
        'date_fin',
        'user_id'
    ];
}
