@extends('layouts.app')

@section('title', $quiz->title)

@section('content')

<a href="{{ route('courses.show', $course) }}" class="small text-secondary text-decoration-none">
    ← {{ $course->title }}
</a>

<div class="mt-3">
    <span class="eyebrow">Chapter quiz</span>
    <h1 class="page-heading">{{ $quiz->title }}</h1>

    <p class="text-secondary">
        Pass mark: {{ $quiz->pass_mark }}%
        @if($quiz->time_limit_minutes)
            · Suggested time: {{ $quiz->time_limit_minutes }} min
        @endif
    </p>
</div>

<form method="POST" action="{{ route('topic-quizzes.submit', [$course, $topic, $quiz]) }}">
    @csrf

    @foreach($questions as $question)

        <article class="card border-0 shadow-sm rounded-4 p-4 mb-3">

            <div class="d-flex justify-content-between mb-3">
                <strong>
                    {{ $loop->iteration }}.
                    {{ $question->question_text }}
                </strong>

                <span class="small text-muted">
                    {{ $question->points }} point
                </span>
            </div>

            @if($question->question_type === 'short_answer')
                <textarea
                    class="form-control"
                    name="answers[{{ $question->id }}]"
                    rows="3"
                    placeholder="Write your answer in English"></textarea>

                <div class="form-text">
                    Short answers are matched with the answer set by the instructor.
                </div>

            @endif

        </article>

    @endforeach

    <button class="btn btn-brand btn-lg">
        Submit quiz
        <i class="bi bi-check2-circle"></i>
    </button>

</form>

@endsection