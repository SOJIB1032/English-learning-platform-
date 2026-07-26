<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    public function quizAttempts(): HasMany { return $this->hasMany(QuizAttempt::class); }

    /**
     * এই ইউজার নির্দিষ্ট লেসনে কতটুকু progress করেছে তা বের করে
     */
    public function progressForLesson(int $lessonId): ?Progress
    {
        return $this->progress()->where('lesson_id', $lessonId)->first();
    }
}
