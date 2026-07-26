@extends('layouts.app')

@section('title', 'Quiz Result - ' . $lesson->title)

@section('content')

<div class="container py-4">
    <h2 class="mb-2"> Quiz Result </h2>
    <h5 class="text-muted mb-2"> {{ $lesson->title }} </h5>

    <div class="card shadow-sm mb-2">
        <div class="card-body text-center py-3">

          <h1 class="display-3 fw-bold text-primary mb-2">
             {{ $score }}
             <span class="text-secondary">/ {{ $total }}</span>
            </h1>

           <p class="text-muted fs-3 mb-2">
            Correct Score
            </p>
           @if($passed)
           <span class="badge bg-success fs-5 px-4 py-2">
            🎉 PASS
            </span>
             @else
            <span class="badge bg-danger fs-5 px-4 py-2">
            ❌ FAIL
            </span>
           @endif

           <p class="mt-2 text-muted">
              Pass Mark: {{ $passMark }}%
            </p>
            <p class="text-muted">Your Score: {{ ($score / $total) * 100 }}%</p>

        </div>
    </div>

    @foreach($results as $result)
        <div class="card mb-3">
            <div class="card-body">
                <h5> {{ $result['question']->question_text }} </h5>
                <p class="mb-2">
                    <strong>Your Answer:</strong>
                    {{ $result['answer'] ?: 'No Answer' }}
                </p>
                <p class="mb-2">
                    <strong>Correct Answer:</strong>
                    {{ $result['question']->correct_text }}
                </p>

                @if($result['correct'])
                    <span class="badge bg-success"> Correct </span>
                @else
                    <span class="badge bg-danger"> Wrong </span>
                @endif

            </div>

        </div>

    @endforeach

    <div class="d-flex justify-content-between mt-4">

        <a href="{{ route('courses.show',$course) }}" class="btn btn-secondary"> Back to Course </a>

        @if($next)

            <a href="{{ route('lessons.show',[$course,$next]) }}" class="btn btn-primary"> Next Lesson </a>

        @endif

    </div>

</div>

@endsection