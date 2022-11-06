<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopePublished(Builder $query)
    {
        $query->where('is_published', true)
            ->where('start_date', '>=', now());
        return $query;
    }


    // 職種検索用のスコープを追加
    // public function scopeSearch(Builder $query, $params)
    // {
    //     if (!empty($params['occupation_id'])) {
    //         $query->where('occupation_id', $params['occupation_id']);
    //     }

    //     return $query;
    // }

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
