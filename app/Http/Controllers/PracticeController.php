<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\PracticeAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Topic;

class PracticeController extends Controller
{
    public function show(Course $course, Subject $subject,Topic $topic, Lesson $lesson)
    {
        abort_unless(
        $subject->course_id == $course->id &&
        $topic->subject_id == $subject->id &&
        $lesson->topic_id == $topic->id,
        404
        );

        $practices = $lesson->practices;

        $attempts = PracticeAttempt::where('user_id', Auth::id())
         ->whereIn('practice_id', $practices->pluck('id'))
         ->get()
         ->keyBy('practice_id');

         $previousAnswers = $attempts->map(function ($attempt) {
           return [
            'answer' => $attempt->answer,
           'is_correct' => $attempt->is_correct,
           ];
            })->toArray();

        return view(
            'practice.show',
            compact(
                'course',
                'subject',
                'topic',
                'lesson',
                'practices',
                'previousAnswers'
            )
        );
    }

    public function submit(Request $request, Course $course, Subject $subject,Topic $topic, Lesson $lesson)
    {
       abort_unless(
      $subject->course_id == $course->id &&
      $topic->subject_id == $subject->id &&
      $lesson->topic_id == $topic->id,
      404
      );

        $request->validate([
            'answers' => 'required|array',
        ]);

        foreach ($lesson->practices as $practice) {

         $answer = trim($request->answers[$practice->id] ?? '');

          PracticeAttempt::updateOrCreate(

         [
            'user_id' => Auth::id(),
            'practice_id' => $practice->id,
         ],

         [
            'answer'       => $answer,
            'submitted_at' => now(),
          ]
          );
        }
      

        $next = $lesson->next();

        return view(
            'practice.result',
            compact(
                'course',
                'subject',
                'topic',
                'lesson',
                'next'
            )
        );
    }
}