<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicQuizController extends Controller
{
    public function show(Course $course, Topic $topic, Lesson $lesson, Quiz $quiz)
    {
        abort_unless(
            $topic->course_id == $course->id &&
            $lesson->topic_id == $topic->id &&
            $quiz->lesson_id == $lesson->id,
            404
        );

        $questions = $quiz->questions;

        if ($quiz->shuffle_questions) {
            $questions = $questions->shuffle();
        }

        return view('topic-quizzes.show', compact(
            'course',
            'topic',
            'lesson',
            'quiz',
            'questions'
        ));
    }

    public function submit(Request $request, Course $course, Topic $topic, Lesson $lesson, Quiz $quiz)
    {
        abort_unless(
            $topic->course_id == $course->id &&
            $lesson->topic_id == $topic->id &&
            $quiz->lesson_id == $lesson->id,
            404
        );

        $questions = $quiz->questions;
        $answers = $request->input('answers', []);

        $score = 0;
        $total = $questions->sum('points');
        $results = [];

        foreach ($questions as $question) {

            $answer = trim((string) ($answers[$question->id] ?? ''));

            $correct = $answer !== '' && $question->isCorrect($answer);

            if ($correct) {
                $score += $question->points;
            }

            $results[] = compact('question', 'answer', 'correct');
        }

        $percentage = $total
            ? round(($score / $total) * 100)
            : 0;

        $attempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_points' => $total,
            'percentage' => $percentage,
            'answers' => $answers,
            'submitted_at' => now(),
        ]);

        return view('topic-quizzes.result', compact(
            'course',
            'topic',
            'lesson',
            'quiz',
            'results',
            'attempt'
        ));
    }
}