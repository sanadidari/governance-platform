<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acte extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'huissier_id',
        'reference',
        'type',
        'status',
        'objet',
        'date_depot',
        'date_execution',
        'notes',
        'attachments',
        'admin_notes',
    ];

    protected $casts = [
        'date_depot'    => 'date',
        'date_execution' => 'date',
        'attachments'   => 'array',
    ];

    public function huissier()
    {
        return $this->belongsTo(Huissier::class);
    }
}
