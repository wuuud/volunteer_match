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
    protected $appends = [
        'volunteer_name',
    ];

    protected $hidden = [
        'volunteer',
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
        // 認証後
        if (Auth::user()->volunteer) {
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
        return $query;
    }

    // API後
    // $user = User::find(21);
    // if ($user->volunteer) {
    //     $query->latest()
    //         ->with('proposes')
    //         ->where('volunteer_id', $user->volunteer->id);
    // } else {
    //     $query->latest()
    //         ->with('proposes')
    //         ->whereHas('proposes', function ($query) {
    //             $query->where('user_id', Auth::user()->id);
    //         });
    // }
    // return $query;
    // }

    // API前
    //     if (Auth::user()->volunteer) {
    //         $query->latest()
    //             ->with('proposes')
    //             ->where('volunteer_id', $user->volunteer->id);
    //     } else {
    //         $query->latest()
    //             ->with('proposes')
    //             ->whereHas('proposes', function ($query) {
    //                 $query->where('user_id', Auth::user()->id);
    //             });
    //     }
    //     return $query;
    // }

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

    // public function getVolunteerNameAttribute()
    // {
    //     return $this->volunteer->user->name;
    // }
}
