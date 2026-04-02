<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'code'];

    public function tribunals()
    {
        return $this->hasMany(Tribunal::class);
    }

    public function huissiers()
    {
        return $this->hasManyThrough(Huissier::class, Tribunal::class);
    }
}
