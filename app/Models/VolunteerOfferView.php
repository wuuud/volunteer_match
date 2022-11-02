<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerOfferView extends Model
{
    use HasFactory;

     protected $fillable = [
        'volunteer_offer_id',
        'user_id',
    ];
}
