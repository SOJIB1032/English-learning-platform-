<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSubjectController extends Controller
{
    private function gate(): void
    {
        abort_unless(auth()->user()?->is_admin, 403);
    }

    public function index(Course $course)
    {
        $this->gate();

        $subjects = $course->subjects()
            ->withCount('topics')
            ->orderBy('serial')
            ->get();

        return view(
            'admin.subjects.index',
            compact('course', 'subjects')
        );
    }

    public function store(Request $request, Course $course)
    {
        $this->gate();

       $data = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'serial' => 'required|integer|min:1',
   ]);

  $data['slug'] = Str::slug($data['title']);
  if ($data['slug'] == '') {
    $data['slug'] = 'subject-' . time();
 }
  $course->subjects()->create($data);

        return back()->with(
            'status',
            'Subject created successfully.'
        );
    }

    public function update(Request $request, Course $course, Subject $subject)
    {
        $this->gate();

        abort_unless(
            $subject->course_id == $course->id,
            404
        );

        $subject->update(
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'serial' => 'required|integer|min:1',
            ])
        );

        return back()->with(
            'status',
            'Subject updated successfully.'
        );
    }

    public function destroy(Course $course, Subject $subject)
    {
        $this->gate();

        abort_unless(
            $subject->course_id == $course->id,
            404
        );

        if ($subject->topics()->count()) {

            return back()->with(
                'error',
                'Delete all chapters first.'
            );
        }

        $subject->delete();

        return back()->with(
            'status',
            'Subject deleted.'
        );
    }
}