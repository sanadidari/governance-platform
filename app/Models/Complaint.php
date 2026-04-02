<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'huissier_id',
        'subject',
        'description',
        'status', // submitted, processing, resolved, rejected
        'priority', // low, medium, high
        'attachments',
        'admin_notes', // Internal notes
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function huissier()
    {
        return $this->belongsTo(Huissier::class);
    }
    //
}
