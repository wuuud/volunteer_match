<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Notifiable;   //SNS認証用

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // SNS認証用
    function IdentityProvider()
    {
        // IdentityProviderモデルと紐付ける 1対多の関係
        return $this->hasOne(IdentityProvider::class);
    }


    public function npo()
    {
        return $this->hasOne(\App\Models\Npo::class);
    }

    public function scouts()
    {
        return $this->hasMany(Scout::class);
    }

    // 追加
    public function volunteer()
    {
        return $this->hasOne(\App\Models\Volunteer::class);
    }

    public function proposes()
    {
        return $this->hasMany(Propose::class);
    }
}
