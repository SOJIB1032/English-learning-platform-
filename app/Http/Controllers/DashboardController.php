<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $courses = Course::where('is_published', true)->orderBy('order')->get();

        $courses->each(function ($course) use ($user) {
            $course->progress_percent = $course->progressPercentFor($user);
            $course->total_lessons = $course->lessons()->count();
        });

        $overallPercent = $courses->count()
            ? (int) round($courses->avg('progress_percent'))
            : 0;

        return view('dashboard.index', compact('courses', 'overallPercent'));
    }
}
