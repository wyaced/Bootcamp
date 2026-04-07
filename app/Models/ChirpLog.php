<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChirpLog extends Model
{
    protected $fillable = [
        'user_id',
        'chirp_id',
        'message',
        'status',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }
}
