<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postile extends Model
{
    use HasFactory;


    protected $fillable = [
        'id_freelancer',
        'id_offerdeomplis',
        'description',
        'status'
    ];

    public function usersOffer()
    {
        return $this->belongsTo(OfferDeEmploi::class, 'id_offerdeomplis');
    }
}
