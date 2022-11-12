<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasProfilePhoto;

class Volunteer extends Model
{
    use HasFactory;
    use HasProfilePhoto;

    // ステータス
    const STATUS_CLOSE = 0;
    const STATUS_OPEN = 1;
    const STATUS_LIST = [
        self::STATUS_CLOSE => '未公開',
        self::STATUS_OPEN => '公開',
    ];
    
    protected $fillable = [
        'user_id',
    ];

    // API
    protected $appends = [
        'user_name'
    ];
    protected $hidden = [
        // 'user_id',
        'user',
    ];
    

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = [
    //     'profile_photo_url',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function volunteerOffers()
    {
        return $this->hasMany(VolunteerOffer::class);
    }

    // 追加 エントリー
    public function scouts()
    {
        return $this->hasMany(Scout::class);
    }
    // 追加 エントリー
    public function applications()
    {
        return $this->hasMany(Applicaiton::class);
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}

