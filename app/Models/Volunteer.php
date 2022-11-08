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
        'name',
        'profile',
    ];
    // public function scopePublished(Builder $query)
    // {
    //     $query->where('is_published', true)
    //         ->where('start_date', '>=', now());
    //     return $query;
    // }

    // public function scopeMyVolunteerOffer(Builder $query, $params)
    // {
    //     if (Auth::user()->can('npo')) {
    //         $query->latest()
    //             ->with('scouts')
    //             ->where('npo_id', Auth::user()->npo->id)
    //             ->where('is_published', $params['is_published'] ?? self::STATUS_OPEN);
    //     } else {
    //         $query->latest()
    //             ->with('scouts')
    //             ->whereHas('scouts', function ($query) use ($params) {
    //                 $query->where('user_id', Auth::user()->id);
    //             });
    //     }

    //     return $query;
    // }

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

    // 追加 エントリー用
    public function scouts()
    {
        return $this->hasMany(Scout::class);
    }

    // 追加 エントリーchoose
    public function applications()
    {
        return $this->hasMany(Applicaiton::class);
    }

}
