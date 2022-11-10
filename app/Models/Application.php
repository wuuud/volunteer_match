<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'volunteer_id',
        'name',
        'career',
    ];


    // 検索
    public function scopeSearch(Builder $query, $search)
    {
        if (!empty($search['career'])) {
            $query->where('career', 'like', '%' . $search['career'] . '%');
        }
    }

    public function scopeMyApplication(Builder $query, $params)
    {
        if (Auth::user()->can('volunteer')) {
            $query->latest()
                ->with('proposes')
                ->where('volunteer_id', Auth::user()->volunteer->id);
        } else {
            $query->latest()
                ->with('proposes')
                ->whereHas('proposes', function ($query) use ($params) {
                    $query->where('user_id', Auth::user()->id);
                });
        }
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
    public function proposes()
    {
        return $this->hasMany(Propose::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
