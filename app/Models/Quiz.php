<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
   protected $fillable = [
    'lesson_id',
    'title',
    'pass_mark',
    'time_limit_minutes',
    'shuffle_questions',
];
    protected $casts = ['shuffle_questions' => 'boolean'];
    public function lesson()
    {
         return $this->belongsTo(Lesson::class);
    }

    public function questions()
    {
      return $this->hasMany(Question::class)->orderBy('order');
    }
    public function attempts(): HasMany { return $this->hasMany(QuizAttempt::class); }
}
