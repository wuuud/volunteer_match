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
        'career',
        'status',
    ];

    // API用 アクセサで記載したこと
    protected $append = [
        'volunteer_name.user_name',
    ];

    protected $hidden = [
        // 'volunteer_id',
        // 'created_at',
        // 'updated_at',
    ];

    // 検索
    public function scopeSearch(Builder $query, $search)
    {
        if (!empty($search['career'])) {
            $query->where('career', 'like', '%' . $search['career'] . '%');
        }
    }

    public function scopeMyApplication(Builder $query)
    {
        if (Auth::user()->can('volunteer')) {
            $query->latest()
                ->with('proposes')
                ->where('volunteer_id', Auth::user()->volunteer->id);
        } else {
            $query->latest()
                ->with('proposes')
                ->whereHas('proposes', function ($query) {
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

    public function getVolunteerNameAttribute()
    {
        return $this->volunteer->user->name;
    }
}
