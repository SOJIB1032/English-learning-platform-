<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'order',
       'correct_text', 'explanation', 'points',
    ];

    public function quiz(): BelongsTo { return $this->belongsTo(Quiz::class); }
    

   public function isCorrect(string $answer): bool
   {
      return mb_strtolower(trim($answer))
        ===
      mb_strtolower(trim($this->correct_text));
    }
}
