<?php
// SNS認証用
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'provider'
    ];

    protected $hidden = [
        // 'user_id',
        // 'created_at',
        // 'updated_at',
        // 'provider'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

}
