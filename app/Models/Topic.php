<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Topic extends Model
{
    protected $fillable = ['course_id','subject_id', 'title', 'description', 'serial'];

    public function course(): BelongsTo 
    { 
        return $this->belongsTo(Course::class);
    }
    public function subject(): BelongsTo
    {
       return $this->belongsTo(Subject::class);
    }
    public function lessons(): HasMany 
    { 
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
    
}
