<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Subject;

class AdminTopicController extends Controller
{
    private function gate(): void { abort_unless(auth()->user()?->is_admin, 403); }

  public function index(Course $course, Subject $subject)
{
    $this->gate();

    abort_unless(
        $subject->course_id == $course->id,
        404
    );

    return view(
        'admin.topics.index',
        [
            'course' => $course,
            'subject' => $subject,
            'topics' => $subject->topics()
                                ->withCount('lessons')
                                ->get(),
        ]
    );
}

   public function store(
    Request $request,
    Course $course,
    Subject $subject
)
{
    $this->gate();

    abort_unless(
        $subject->course_id == $course->id,
        404
    );

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'serial' => 'required|integer|min:1',
    ]);

    $data['course_id'] = $course->id;

    $subject->topics()->create($data);

    return back()->with(
        'status',
        'Chapter Added Successfully.'
    );
}
   
    //edit method
  public function edit(
    Course $course,
    Subject $subject,
    Topic $topic
)
{
    $this->gate();

    abort_unless(
        $subject->course_id == $course->id &&
        $topic->subject_id == $subject->id,
        404
    );

    return view(
        'admin.topics.edit',
        compact(
            'course',
            'subject',
            'topic'
        )
    );
}

// update method
public function update(
    Request $request,
    Course $course,
    Subject $subject,
    Topic $topic
)
{
    $this->gate();

   abort_unless(
    $subject->course_id == $course->id &&
    $topic->subject_id == $subject->id,
    404
);

    $topic->update(
        $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'serial'=>'required|integer|min:1',
        ])
    );

    return back()->with(
        'status',
        'Chapter Updated.'
    );
}
public function destroy(
    Course $course,
    Subject $subject,
    Topic $topic
)
{
    $this->gate();

  abort_unless(
    $subject->course_id == $course->id &&
    $topic->subject_id == $subject->id,
    404
);

    $topic->delete();

    return back()->with(
        'status',
        'Chapter Deleted.'
    );
}
}
