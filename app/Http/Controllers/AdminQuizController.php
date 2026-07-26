<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Subject;

class AdminQuizController extends Controller
{
    private function gate(): void
    {
        abort_unless(auth()->user()?->is_admin, 403);
    }

    public function edit(Course $course, Subject $subject, Topic $topic, Lesson $lesson)
    {
        $this->gate();

        abort_unless(
        $subject->course_id == $course->id &&
        $topic->subject_id == $subject->id &&
        $lesson->topic_id == $topic->id,
        404
        );

     $quiz = $lesson->quiz;

    if (!$quiz) {

     $quiz = $lesson->quiz()->create([
        'title' => $lesson->title . ' Quiz',
        'pass_mark' => 60,
        'shuffle_questions' => false,
     ]);

    }

        return view('admin.quizzes.edit', compact('course', 'subject','topic','lesson', 'quiz'));
    }

    public function update(Request $request, Course $course,  Subject $subject, Topic $topic, Lesson $lesson, Quiz $quiz)
    {
        $this->gate();

        abort_unless(
           $subject->course_id == $course->id &&
           $topic->subject_id == $subject->id &&
           $lesson->topic_id == $topic->id &&
           $quiz->lesson_id == $lesson->id,
            404
        );

        $quiz->update($request->validate([
            'title' => 'required|string|max:255',
            'pass_mark' => 'required|integer|min:0|max:100',
            'time_limit_minutes' => 'nullable|integer|min:1',
        ]));

        return back()->with('status', 'Quiz settings saved.');
    }

    public function addQuestion(Request $request, Course $course,Subject $subject, Topic $topic, Lesson $lesson, Quiz $quiz)
    {
        $this->gate();

        abort_unless(
            $subject->course_id == $course->id &&
            $topic->subject_id == $subject->id &&
            $lesson->topic_id == $topic->id &&
            $quiz->lesson_id == $lesson->id,
            404
        );

        $data = $request->validate([
            'question_text' => 'required|string',
            'correct_text' => 'required|string',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
        ]);

        $data['question_type'] = 'short_answer';
       
        $data['order'] = ($quiz->questions()->max('order') ?? 0) + 1;

        $quiz->questions()->create($data);

        return back()->with('status', 'Question added.');
    }
     // edit question method ...................................
    public function editQuestion(
    Course $course,
    Subject $subject,
    Topic $topic,
    Lesson $lesson,
    Quiz $quiz,
    Question $question
)
{
    $this->gate();

    abort_unless(
       $subject->course_id == $course->id &&
       $topic->subject_id == $subject->id &&
       $lesson->topic_id == $topic->id &&
       $quiz->lesson_id == $lesson->id &&
       $question->quiz_id == $quiz->id,
        404
    );

    return view(
        'admin.quizzes.edit-question',
        compact(
            'course',
            'subject',
            'topic',
            'lesson',
            'quiz',
            'question'
        )
    );
}
 
//update method...................................................
public function updateQuestion(
    Request $request,
    Course $course,
    Subject $subject,
    Topic $topic,
    Lesson $lesson,
    Quiz $quiz,
    Question $question
)
{
    $this->gate();

    abort_unless(
        $subject->course_id == $course->id &&
        $topic->subject_id == $subject->id &&
        $lesson->topic_id == $topic->id &&
        $quiz->lesson_id == $lesson->id &&
        $question->quiz_id == $quiz->id,
        404
    );

    $data = $request->validate([
        'question_text' => 'required|string',
        'correct_text' => 'required|string',
        'explanation' => 'nullable|string',
        'points' => 'required|integer|min:1',
    ]);

    $question->update($data);

    return redirect()
        ->route('admin.quizzes.edit', [$course, $subject, $topic, $lesson])
        ->with('status','Question updated successfully.');
}
 //deletequestion method...................................................
    public function deleteQuestion(Course $course, Subject $subject, Topic $topic, Lesson $lesson, Quiz $quiz, Question $question)
    {
        $this->gate();

        abort_unless(
           $subject->course_id == $course->id &&
           $topic->subject_id == $subject->id &&
           $lesson->topic_id == $topic->id &&
           $quiz->lesson_id == $lesson->id &&
           $question->quiz_id == $quiz->id,
            404
        );

        $question->delete();

        return back()->with('status', 'Question removed.');
    }
}
