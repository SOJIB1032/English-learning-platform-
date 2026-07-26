@extends('layouts.app')

@section('title','Practice - '.$lesson->title)

@section('content')

<div class="container">

    <div class="mb-4">

        <a href="{{route('practice.show', [
            'course' => $course,
            'subject' => $subject,
            'topic' => $topic,
            'lesson' => $lesson,
           ]) }}"
           class="btn btn-outline-secondary btn-sm">

            ← Back to Lesson

        </a>

        <h2 class="mt-3 fw-bold">

            Practice :
            {{ $lesson->title }}

        </h2>

        <p class="text-muted">

            Answer the following questions.

        </p>

    </div>

    <form method="POST"
          action="{{ route('practice.submit',[
            'course' => $course,
            'subject' => $subject,
            'topic' => $topic,
            'lesson' => $lesson,]) }}">

        @csrf

        @foreach($practices as $practice)

            <div class="card shadow-sm border-0 rounded-4 mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">

                        {{ $practice->serial }}.

                        {{ $practice->question }}

                    </h5>

                   <input
                   class="form-control"
                   placeholder="Write your answer here..."
                   name="answers[{{ $practice->id }}]">{{ old('answers.'.$practice->id, $previousAnswers[$practice->id]['answer'] ?? '') }}
                  
                   @if(isset($previousAnswers[$practice->id]))
                   @php
                   $userAnswer = trim($previousAnswers[$practice->id]['answer']);
                    $correctAnswer = trim($practice->correct_answer);
                    $accepted = strtolower($userAnswer) === strtolower($correctAnswer);
                    @endphp
                  @if($accepted)
                   <div class="alert alert-success mt-3 mb-0">
                    ✅ <strong>Accepted Answer</strong>
                  </div>
                  @else
                  <div class="alert alert-danger mt-3 mb-2">
                  ❌ <strong>Not Accepted Answer</strong>
                 </div>
                 <div class="alert alert-info">
                 <strong>Correct Answer:</strong><br>
                  {{ $practice->correct_answer }}
                 </div>
                  @endif
                  @endif

                </div>

            </div>

        @endforeach

        <div class="d-flex justify-content-between">

            <button
                class="btn btn-success">

                <i class="bi bi-save"></i>

                Save Practice

            </button>

            @if($lesson->hasQuiz())

                <a href="{{ route('quiz.show',[
                  'course' => $course,
                  'subject' => $subject,
                   'topic' => $topic,
                   'lesson' => $lesson,]) }}"
                   class="btn btn-primary">

                    Continue To Quiz →

                </a>

            @endif

        </div>

    </form>

</div>

@endsection