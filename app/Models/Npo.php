<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\HasProfilePhoto;

class Npo extends Model
{
    use HasFactory;
    use HasProfilePhoto;

    protected $fillable = [
        'user_id',
        'name',
    ];

    protected $appends = [
        // 'user_profile_photo_url',
        // 'user_name',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function volunteerOffers()
    {
        return $this->hasMany(VolunteerOffer::class);
    }
}
