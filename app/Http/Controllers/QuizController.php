<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Topic;

class QuizController extends Controller
{
    public function show(Course $course,Subject $subject, Topic $topic, Lesson $lesson)
    {
        $quiz = $lesson->quiz;

       abort_if(!$quiz,404);

       $questions = $quiz
       ->questions()
       ->orderBy('order')
       ->get();

      abort_if($questions->isEmpty(),404);
      $attempt = auth()->check()
       ? $quiz->attempts()
        ->where('user_id', auth()->id())
        ->latest()
        ->first()
        : null;

        $previousAnswers = $attempt?->answers ?? [];

       return view(
             'quiz.show',
            compact(
             'course',
             'subject',
             'topic',
             'lesson',
             'quiz',
             'questions',
             'previousAnswers'
            )
        );
    }

    public function submit(Request $request, Course $course,Subject $subject, Topic $topic, Lesson $lesson)
    {
         $request->validate([
         'answers' => 'required|array',
             ]);
        abort_unless(
         $subject->course_id === $course->id &&
         $topic->subject_id === $subject->id &&
         $lesson->topic_id === $topic->id,
         404
        );

        $quiz = $lesson->quiz;

        abort_if(!$quiz, 404);

       $questions = $quiz->questions()->orderBy('order')->get();

        $answers = $request->input('answers', []);

        $score = 0;

        $total = $questions->sum('points');

        $results = [];

        foreach ($questions as $question) {

            $answer = trim(
                (string)($answers[$question->id] ?? '')
            );

            $correct = $answer !== ''
                &&
                $question->isCorrect($answer);

            if ($correct) {

                $score += $question->points;

            }

            $results[] = compact(
                'question',
                'answer',
                'correct'
            );
        }

        $quiz->attempts()->create([
        'user_id' => Auth::id(),
        'score' => $score,
        'total_points' => $total,
        'percentage' => $total > 0 ? round(($score / $total) * 100) : 0,
        'answers' => $answers,
        'submitted_at' => now(),
       ]);
       Progress::updateOrCreate(

      [
        'user_id' => Auth::id(),
        'lesson_id' => $lesson->id,
     ],
 
     [
        'lesson_completed' => true,
        'quiz_completed' => true,
        'quiz_score' => $score,
        'quiz_total' => $total,
        'completed_at' => now(),
     ]

     );
       $passMark = 60;
       $percentage = $total > 0 ? ($score / $total) * 100 : 0;
       $passed = $percentage >= $passMark;
        $next = $lesson->next();

        return view(

            'quiz.result',

            compact(

                'course',

                'subject',
                
                'topic',

                'lesson',

                'quiz',

                'results',

                'score',

                'total',

                'next',
                'passMark',
                'passed'

            )

        );
    }
}