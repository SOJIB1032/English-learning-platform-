<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)
            ->orderBy('order')
            ->get();

        $user = Auth::user();

        $courses->each(function ($course) use ($user) {
            $course->progress_percent = $course->progressPercentFor($user);
        });

        return view('courses.index', compact('courses'));
    }
public function show(Course $course)
{
   
    $course->load([
        'subjects.topics.lessons.practice',
        'subjects.topics.lessons.quiz',
    ]);

    $lessons = $course->subjects
        ->flatMap(fn ($subject) => $subject->topics)
        ->flatMap(fn ($topic) => $topic->lessons);

    $user = Auth::user();

    $lessons->each(function ($lesson) use ($user) {
        $progress = $user?->progressForLesson($lesson->id);

        $lesson->is_completed = $progress?->lesson_completed ?? false;
        $lesson->quiz_score = $progress?->quiz_score;
        $lesson->quiz_total = $progress?->quiz_total;
    });
     
    return view('courses.show', compact('course', 'lessons'));
}
   
}
