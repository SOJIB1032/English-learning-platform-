<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Subject;

class Course extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'order',
        'is_published',
        'overview', 'learning_objectives', 'skills', 'target_audience', 'requirements',
        'instructor_name', 'difficulty', 'duration_minutes', 'status',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'learning_objectives' => 'array',
        'skills' => 'array',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
    //subject method.....................................
    public function subjects(): HasMany
{
    return $this->hasMany(Subject::class)
                ->orderBy('serial');
} 

    /**
     * নির্দিষ্ট ইউজারের এই কোর্সে সামগ্রিক progress (%) হিসাব করে
     */
    public function progressPercentFor(?\App\Models\User $user): int
    {
        if (!$user) {
            return 0;
        }

        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) {
            return 0;
        }

        $completed = Progress::where('user_id', $user->id)
            ->whereIn('lesson_id', $this->lessons()->pluck('id'))
            ->where('lesson_completed', true)
            ->count();

        return (int) round(($completed / $totalLessons) * 100);
    }
}
