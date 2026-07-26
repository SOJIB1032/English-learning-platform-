@extends('layouts.app')

@section('title', 'কুইজ - ' . $lesson->title)

@section('content')
<div class="mb-6">
    <a href="{{ route('lessons.show', [
    'course' => $course,
    'subject' => $subject,
    'topic' => $topic,
    'lesson' => $lesson,
    ]) }}" class="text-sm btn btn-secondary hover:underline">
    ← লেসনে ফিরে যান
   </a>
    <h1 class="text-2xl font-bold mt-2">কুইজ: {{ $lesson->title }}</h1>
</div>

<form method="POST" action="{{ route('quiz.submit', [
    'course' => $course,
    'subject' => $subject,
    'topic' => $topic,
    'lesson' => $lesson,
    ]) }}">
    @csrf

    @foreach($questions as $index => $question)

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <h5 class="mb-3">
                    {{ $index + 1 }}.
                    {{ $question->question_text }}
                </h5>
                <label class="form-label fw-bold">Enter your answer in 1 line: </label>
              <input
               name="answers[{{ $question->id }}]"
                class="form-control pt-1"
               placeholder="Write your answer here..."
              required>{{ old('answers.'.$question->id, $previousAnswers[$question->id] ?? '') }}
             
            </div>

        </div>

    @endforeach

    <button type="submit" class="w-full btn btn-primary hover:bg-teal-800 text-white  rounded font-semibold">
        উত্তর জমা দিন
    </button>
</form>
@endsection
