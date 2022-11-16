<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propose extends Model
{
    use HasFactory;

    // ステータス
    const STATUS_PROPOSE = 0;
    const STATUS_ACCEPT = 1;
    const STATUS_REFUSE = 2;
    const STATUS_LIST = [
        self::STATUS_PROPOSE => '提案中',
        self::STATUS_ACCEPT => '提案受け入れ',
        self::STATUS_REFUSE => '提案拒否',
    ];

    protected $fillable = [
        'application_id',
        'user_id',
        'status',
    ];

    // API
    protected $appends = [
        'volunteer_name',
        // 'status',
    ];
    protected $hidden = [
        // 'user_id',
    ];


    public function getStatusValueAttribute()
    {
        return self::STATUS_LIST[$this->status];
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
    public function getVolunteerNameAttribute()
    {
        return $this->application->volunteer->user->name;
    }
}
