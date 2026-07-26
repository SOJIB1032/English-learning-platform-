<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCourseController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
      return view('admin.courses.index', [
        'courses' => Course::query()
        ->withCount('subjects')
        ->orderBy('order')
        ->get()
      ]);
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
       'title' => ['required', 'string', 'max:255'],
       'description' => ['nullable', 'string'],
       'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
       'order' => ['nullable', 'integer', 'min:0'],
       'is_published' => ['nullable', 'boolean'],
        ]);
        $baseSlug = Str::slug($data['title']) ?: 'course'; $slug = $baseSlug; $number = 2;

        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
        $thumbnail = $request->file('thumbnail')
        ->store('courses', 'public');
        }
        while (Course::where('slug', $slug)->exists()) $slug = $baseSlug.'-'.$number++;
        $course = Course::create([
       'title'=>$data['title'],
       'slug'=>$slug,
       'description'=>$data['description'] ?? null,
       'thumbnail'=> $thumbnail,
       'order'=>$data['order'] ?? 0,
       'is_published'=>$request->boolean('is_published')
        ]);
        return redirect()->route('admin.topics.index', $course)->with('status', 'Course created. Add chapters, lessons and quizzes next.');
    }
    public function edit(Course $course)
{
    $this->authorizeAdmin();

    return view('admin.courses.create', compact('course'));
}

public function update(Request $request, Course $course)
{
    $this->authorizeAdmin();

    $data = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'order' => ['nullable', 'integer', 'min:0'],
        'is_published' => ['nullable', 'boolean'],
    ]);

    if ($course->title != $data['title']) {

        $baseSlug = Str::slug($data['title']) ?: 'course';
        $slug = $baseSlug;
        $number = 2;

        while (
            Course::where('slug', $slug)
                ->where('id', '!=', $course->id)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $number++;
        }

        $course->slug = $slug;
    }

    if ($request->hasFile('thumbnail')) {

        if (
            $course->thumbnail &&
            Storage::disk('public')->exists($course->thumbnail)
        ) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->thumbnail = $request
            ->file('thumbnail')
            ->store('courses', 'public');
    }

    $course->update([
        'title' => $data['title'],
        'description' => $data['description'] ?? null,
        'order' => $data['order'] ?? 0,
        'is_published' => $request->boolean('is_published'),
        'thumbnail' => $course->thumbnail,
        'slug' => $course->slug,
    ]);

    return redirect()
        ->route('admin.courses.index')
        ->with('status', 'Course updated successfully.');
}
    public function destroy(Course $course)
    {
     $this->authorizeAdmin();

     // Delete uploaded thumbnail
     if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
        Storage::disk('public')->delete($course->thumbnail);
     }

     // Delete course
     $course->delete();

      return redirect()
        ->route('admin.courses.index')
        ->with('status', 'Course deleted successfully.');
    }
    private function authorizeAdmin(): void { abort_unless(auth()->user()?->is_admin, 403); }
}
