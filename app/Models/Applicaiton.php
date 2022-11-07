<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicaiton extends Model
{
    use HasFactory;

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

}
