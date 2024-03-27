<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferDeEmploi extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'description', 'image', 'prix', 'user_id'];

    public function posteles()
    {
        return $this->hasMany(Postile::class ,'id_offerdeomplis' );
    }
}
