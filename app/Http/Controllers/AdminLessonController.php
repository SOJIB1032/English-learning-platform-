<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Subject;

class AdminLessonController extends Controller
{
    private function gate(): 
    void {
         abort_unless(auth()->user()?->is_admin, 403);
        }

  public function index(
    Course $course,
    Subject $subject,
    Topic $topic
)
{
    $this->gate();

    abort_unless(
        $subject->course_id === $course->id &&
        $topic->subject_id === $subject->id,
        404
    );

    return view(
        'admin.lessons.index',
        [
            'course' => $course,
            'subject' => $subject,
            'topic' => $topic,
            'lessons' => $topic->lessons()
            ->orderBy('order')
            ->get(),
        ]
    );
}
 //store method..........................................
    public function store(
    Request $request,
    Course $course,
    Subject $subject,
    Topic $topic
)
{
    $this->gate();

    abort_unless(
        $subject->course_id === $course->id &&
        $topic->subject_id === $subject->id,
        404
    );

    $d = $request->validate([
        'title' => 'required|string|max:255',
        'text_content' => 'nullable|string',
        'video_url' => 'nullable|url',
        'audio_url' => 'nullable|url',
        'duration_minutes' => 'required|integer|min:1',
        'order' => 'required|integer|min:1',
    ]);

    $d['slug'] = $this->slug($course, $d['title']);
    $d['course_id'] = $course->id;

    $topic->lessons()->create($d);

    return back()->with('status', 'Lesson added.');
}
private function slug(Course $course, string $title): string
{
    $slug = Str::slug($title);

    $original = $slug;

    $i = 1;

    while (
        Lesson::where('course_id', $course->id)
            ->where('slug', $slug)
            ->exists()
    ) {
        $slug = $original.'-'.$i++;
    }

    return $slug;
}
   //update edit method..................................
    public function edit(Course $course,Subject $subject, Topic $topic, Lesson $lesson)
{
    $this->gate();

    abort_unless(
         $subject->course_id === $course->id &&
        $topic->subject_id === $subject->id &&
        $lesson->topic_id === $topic->id,
        404
    );

    return view(
        'admin.lessons.edit',
        compact('course', 'subject', 'topic', 'lesson')
    );
}

//update method......................................
public function update(
    Request $request,
    Course $course,
    Subject $subject,
    Topic $topic,
    Lesson $lesson
) {
    $this->gate();

    abort_unless(
        $subject->course_id === $course->id &&
        $topic->subject_id === $subject->id &&
        $lesson->topic_id === $topic->id,
        404
    );

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'text_content' => 'nullable|string',
        'video_url' => 'nullable|url',
        'audio_url' => 'nullable|url',
        'duration_minutes' => 'required|integer|min:1',
        'order' => 'required|integer|min:1',
    ]);

    if ($lesson->title != $data['title']) {
        $data['slug'] = $this->slug($course, $data['title']);
    }

    $lesson->update($data);

    return redirect()->route(
        'admin.lessons.index',
        [$course, $subject, $topic]
    )->with(
        'status',
        'Lesson updated successfully.'
    );
}

//destroy method..........................................

    public function destroy(
    Course $course,
    Subject $subject,
    Topic $topic,
    Lesson $lesson
) {
    $this->gate();

    abort_unless(
        $subject->course_id === $course->id &&
        $topic->subject_id === $subject->id &&
        $lesson->topic_id === $topic->id,
        404
    );

    $lesson->delete();

    return back()->with(
        'status',
        'Lesson removed.'
    );
}
}
