<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commentaire',
        'freelancer_id'
    ];


    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
