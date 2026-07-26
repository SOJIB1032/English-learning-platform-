<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Practice;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Subject;
class AdminPracticeController extends Controller
{
    private function gate(): void
    {
        abort_unless(auth()->user()?->is_admin, 403);
    }

    public function index( Course $course, Subject $subject, Topic $topic, Lesson $lesson)
    {
        $this->gate();

        abort_unless(
            $subject->course_id == $course->id &&
            $topic->subject_id == $subject->id &&
            $lesson->topic_id == $topic->id,
            404
        );

        $practices = $lesson->practices;

        return view(
            'admin.practices.index',
            compact(
                'course',
                'subject',
                'topic',
                'lesson',
                'practices'
            )
        );
    }

    public function store( Request $request, Course $course, Subject $subject, Topic $topic, Lesson $lesson ) {

        $this->gate();

        abort_unless(
            $subject->course_id == $course->id &&
            $topic->subject_id == $subject->id &&
            $lesson->topic_id == $topic->id,
            404
        );

      $data = $request->validate([
      'question' => 'required|string',
      'correct_answer' => 'required|string',
      'serial' => 'nullable|integer|min:1',
      ]);

      $lesson->practices()->create([
      'question' => $data['question'],
      'correct_answer' => trim($data['correct_answer']),
      'serial' => $data['serial'] ?? (($lesson->practices()->max('serial') ?? 0) + 1),
      ]);

        return back()->with(
            'status',
            'Practice Question Added Successfully.'
        );
    }

 // edit method.................................
    public function edit(
    Course $course,
    Subject $subject,
    Topic $topic,
    Lesson $lesson,
    Practice $practice
)
{
    $this->gate();

    abort_unless(
        $subject->course_id == $course->id &&
        $topic->subject_id == $subject->id &&
        $lesson->topic_id == $topic->id,
        404
    );

    return view(
        'admin.practices.edit',
        compact(
            'course',
            'subject',
            'topic',
            'lesson',
            'practice'
        )
    );
}
 // update method ......................................
public function update(
    Request $request,
    Course $course,
    Subject $subject,
    Topic $topic,
    Lesson $lesson,
    Practice $practice
)
{
    $this->gate();

    abort_unless(
         $subject->course_id == $course->id &&
         $topic->subject_id == $subject->id &&
         $practice->lesson_id == $lesson->id,
        404
    );

    $data = $request->validate([
        'question' => 'required|string',
        'correct_answer' => 'required|string',
        'serial' => 'required|integer|min:1',
    ]);

    $practice->update([
        'question' => $data['question'],
        'correct_answer' => trim($data['correct_answer']),
        'serial' => $data['serial'],
    ]);

    return redirect()
        ->route('admin.practices.index', [$course,$subject,$topic,$lesson])
        ->with('status','Practice updated successfully.');
}
 // destroy method ......................................................
    public function destroy(
        Course $course,
        Subject $subject,
        Topic $topic,
        Lesson $lesson,
        Practice $practice
    ) {

        $this->gate();

        abort_unless(
            $subject->course_id == $course->id &&
            $topic->subject_id == $subject->id &&
            $lesson->topic_id == $topic->id,
            404
        );

        $practice->delete();

        return back()->with(
            'status',
            'Practice Question Deleted.'
        );
    }
}