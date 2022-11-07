<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
        'start_date',  //ボランティア募集開始日
        'description',
        'is_published',
    ];

    public function scopePublished(Builder $query)
    {
        $query->where('is_published', true)
            ->where('start_date', '>=', now());
        return $query;
    }

    public function scopeMyVolunteerOffer(Builder $query, $params)
    {
        if (Auth::user()->can('npo')) {
            $query->latest()
                ->with('scouts')
                ->where('npo_id', Auth::user()->npo->id)
                ->where('is_published', $params['is_published'] ?? self::STATUS_OPEN);
        } else {
            $query->latest()
                ->with('scouts')
                ->whereHas('scouts', function ($query) use ($params) {
                    $query->where('user_id', Auth::user()->id);
                });
        }

        return $query;
    }

    // 追加
    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function npo()
    {
        return $this->belongsTo(Npo::class);
    }

    // 削除？ エントリー用
    public function scouts()
    {
        return $this->hasMany(Scout::class);
    }
}
