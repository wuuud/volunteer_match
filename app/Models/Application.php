<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'volunteer_id',
        'name',
        'career',
    ];

    
    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
    public function proposes()
    {
        return $this->hasMany(Propose::class);
    }
}
