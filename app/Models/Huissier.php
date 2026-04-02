<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Huissier extends Model
{
    protected $fillable = [
        'tribunal_id',
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'status',
    ];

    public function tribunal()
    {
        return $this->belongsTo(Tribunal::class);
    }

    public ?string $plain_password = null;
}
