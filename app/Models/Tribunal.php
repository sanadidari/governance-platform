<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tribunal extends Model
{
    protected $fillable = ['region_id', 'name', 'type', 'code'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
