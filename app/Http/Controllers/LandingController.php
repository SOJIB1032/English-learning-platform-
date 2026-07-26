<?php

namespace App\Http\Controllers;

use App\Models\Course;

class LandingController extends Controller
{
    public function __invoke()
    {
        $courses = Course::query()
       ->where('is_published', true)
       ->withCount('subjects')
       ->orderBy('order')
       ->take(3)
       ->get();
        return view('welcome', compact('courses'));
    }
}
