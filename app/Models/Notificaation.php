<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaation extends Model
{
    use HasFactory;

    protected $fillable = [
        "messages",
        "user_id"
    ];
}
