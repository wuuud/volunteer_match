<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasProfilePhoto;

class Npo extends Model
{
    use HasFactory;
    use HasProfilePhoto;

    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    
    public function volunteerOffers()
    {
        return $this->hasMany(VolunteerOffer::class);
    }
}
