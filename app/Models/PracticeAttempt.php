<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'practice_id',
        'answer',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }
}