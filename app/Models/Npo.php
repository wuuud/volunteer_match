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

    protected $appends = [
        'profile_photo_url',
        'user_name',
    ];

    // protected $hidden = [
    //     'name',
    //     'profile_photo_path',
    //     'created_at',
    //     'updated_at',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function volunteerOffers()
    {
        return $this->hasMany(VolunteerOffer::class);
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}
