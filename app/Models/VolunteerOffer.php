<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerOffer extends Model
{
    use HasFactory;

    // ステータス
    const STATUS_CLOSE = 0;
    const STATUS_OPEN = 1;
    const STATUS_LIST = [
        self::STATUS_CLOSE => '未公開',
        self::STATUS_OPEN => '公開',
    ];

    protected $fillable = [
        'title',
        // 'occupation_id',
        'start_date',                    //ボランティア開始日
        'description',
        'is_published',
    ];

    public function npo()
    {
        return $this->belongsTo(Npo::class);
    }
    // public function volunteerOfferViews()
    // {
    //     return $this->hasMany(VolunteerOfferView::class);
    // }
    // public function occupation()
    // {
    //     return $this->belongsTo(Occupation::class);
    // }

    public function scouts()
    {
        return $this->hasMany(Scout::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
