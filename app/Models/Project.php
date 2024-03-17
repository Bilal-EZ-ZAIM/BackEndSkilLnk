<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'discription',
        'image',
        'link_github',
        'link_host',
        'user_id'
    ];

    


}
