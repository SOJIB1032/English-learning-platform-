@extends('layouts.app')
@section('title','Quiz result')
@section('content')
<section class="card border-0 shadow-sm rounded-4 p-4 p-lg-5 text-center mb-4">
    <span class="eyebrow">Quiz complete</span>
    <h1 class="page-heading display-3 mb-1">{{ $attempt->percentage }}%</h1>
    <p class="text-secondary">You scored {{ $attempt->score }} out of {{ $attempt->total_points }} points.</p>
    @if($attempt->percentage >= $quiz->pass_mark)
      <span class="badge text-bg-success p-2">Passed</span>
    @else
      <span class="badge text-bg-warning p-2">Keep practising</span>
    @endif
    <div class="mt-4">
        <a class="btn btn-brand" href="{{ route('courses.show',$course) }}">Back to course</a> 
        <a class="btn btn-outline-dark" href="{{ route('topic-quizzes.show',[$course,$topic,$quiz]) }}">Try again</a>
    </div>
</section>
<h2 class="page-heading h2">Review answers</h2>
@foreach($results as $item)
<div class="card border-0 shadow-sm rounded-4 p-4 mb-3">
    <div class="d-flex gap-2">
        <i class="bi {{ $item['correct'] ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
        <div>
            <strong>{{ $item['question']->question_text }}</strong>
            <div class="small text-secondary mt-2">
                Your answer: {{ $item['answer'] ?: 'No answer' }}
            </div>
            <div class="small">
                Correct answer: {{ $item['question']->question_type==='mcq' ? $item['question']->{'option_'.$item['question']->correct_option} : $item['question']->correct_text }}
            </div>@if($item['question']->explanation)
            <p class="small text-secondary mt-2 mb-0">{{ $item['question']->explanation }}</p>
            @endif
        </div>
    </div>
</div>
@endforeach
@endsection
