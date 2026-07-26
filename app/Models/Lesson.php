<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'course_id',
        'subject_id',
        'title',
        'slug',
        'image',
        'order',
        'text_content',
        'audio_url',
        'topic_id', 'video_url', 'example', 'grammar', 'vocabulary', 'summary', 'duration_minutes',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class);
    }

    public function topic(): BelongsTo { return $this->belongsTo(Topic::class); }
    public function practice(): HasMany
  {
    return $this->hasMany(Practice::class);
  }

    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    public function practices(): HasMany 
    { 
        return $this->hasMany(Practice::class)->orderBy('serial'); 
    }

    public function hasQuiz(): bool
    {
        return $this->quiz()->exists();
    }

    /**
     * এই লেসনের পরের লেসন (একই কোর্সে) - "পরবর্তী" বাটনের জন্য
     */
    public function next(): ?self
    {
        return static::where('topic_id',$this->topic_id)
        ->where('order','>',$this->order)
        ->orderBy('order')
        ->first();
    }

    public function previous(): ?self
    {
       return static::where('topic_id',$this->topic_id)
      ->where('order','<',$this->order)
      ->orderByDesc('order')
      ->first();
    }
}
