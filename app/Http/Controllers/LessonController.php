<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Topic;

class LessonController extends Controller
{
   public function show(Course $course,Subject $subject, Topic $topic, Lesson $lesson)
{
     abort_if($lesson->topic_id != $topic->id, 404);

    $lesson->load([
          'topic.subject',
        'quiz.questions',
        'practices',
    ]);

    $topic = $lesson->topic;
    $subject = $topic?->subject;

    $user = Auth::user();
    $progress = $user?->progressForLesson($lesson->id);

    $next = $lesson->next();
    $previous = $lesson->previous();

    return view(
        'lessons.show',
        compact(
            'course',
            'subject',
            'topic',
            'lesson',
            'progress',
            'next',
            'previous'
        )
    );
}

    /**
     * ইউজার লেসনের টেক্সট/অডিও পড়া/শোনা শেষ করলে "সম্পন্ন" হিসেবে মার্ক করা
     */
    public function markComplete(Course $course, Lesson $lesson)
{
    abort_if($lesson->course_id != $course->id,404);

    $user = Auth::user();

    Progress::updateOrCreate(
        [
            'user_id'=>$user->id,
            'lesson_id'=>$lesson->id,
        ],
        [
            'lesson_completed'=>true,
            'completed_at'=>now(),
        ]
    );

    if(!$lesson->hasQuiz())
    {
        $next=$lesson->next();

        if($next){
            return redirect()
                ->route('lessons.show',[$course,$next])
                ->with('status','Lesson completed.');
        }

        return redirect()
            ->route('courses.show',$course)
            ->with('status','Congratulations!');
    }

    return redirect()
        ->route('quiz.show',[$course,$lesson]);
}
}
