@extends('layouts.app')

@section('title', $lesson->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white shadow-sm rounded-4 border">

    <div>

        <a href="{{ route('courses.show', $course) }}"
           class="btn btn-outline-primary btn-sm rounded-pill mb-3">
            <i class="bi bi-arrow-left me-1"></i>
            Back to {{ $course->title }}
        </a>
        

        <h2 class="fw-bold mb-1 text-dark">
            {{ $lesson->title }}
        </h2>

        <small class="text-muted">
            Continue your English learning journey.
        </small>

    </div>

    <div class="d-none d-md-block">
        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow"
             style="width:60px;height:60px;">
            <i class="bi bi-book-half fs-3"></i>
        </div>
    </div>

</div>

<div class="bg-white rounded shadow p-2 d-flex flex-column gap-5">

    @if ($lesson->audio_url)
        <div>
            <h2 class="font-semibold mb-2">🔊 অডিও শুনুন</h2>
            <audio controls class="w-full">
                <source src="{{ asset($lesson->audio_url) }}" type="audio/mpeg">
                আপনার ব্রাউজার অডিও প্লেব্যাক সাপোর্ট করে না।
            </audio>
        </div>
    @endif

    @if ($lesson->text_content)
        <div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-header bg-light py-3">
        <h5 class="mb-0 fw-bold text-primary">
            📖 Lesson Content
        </h5>
    </div>
   
 <div class="card-body p-4">

   <div class="d-flex align-items-start">

   <div class="flex-grow-1">
      <div class="fs-5 lh-lg text-dark">
          {!! $lesson->text_content !!}
      </div>
    </div>

    @if($lesson->image)
    <div class="ms-3">
        <img src="{{ asset('storage/'.$lesson->image) }}"
             class="img-fluid rounded shadow"
             style="max-width: 250px;">
    </div>
    @endif

</div>

</div>

</div>
    @endif

    <div class="flex items-center justify-between pt-4 border-t">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div>
               @if ($previous)
                <a href="{{ route('lessons.show', [
                 'course' => $course,
                 'subject' => $next->topic->subject,
                 'topic'   => $next->topic,
                 'lesson'  => $next,
                 ]) }}"
                 class="btn btn-outline-primary btn-sm rounded-pill">
                  ← আগের লেসন
                </a>
                @endif
            </div>
            <div>
                @if ($next)
               <a href="{{ route('lessons.show', [
                 'course' => $course,
                  'subject' => $next->topic->subject,
                  'topic'   => $next->topic,
                  'lesson'  => $next,
                 ]) }}"
                 class="btn btn-outline-primary  btn-sm rounded-pill">
                 পরবর্তী লেসন →
                </a>
               @endif
            </div>
        </div> 
        <form method="POST"  action="{{ route('lessons.complete', [
          'course' => $course,
          'subject' => $subject,
          'topic' => $topic,
          'lesson' => $lesson,
         ]) }}">
            @csrf
            @if($lesson->practices->count())
            <div class="d-flex justify-content-center">
             <a href="{{ route('practice.show', [
              'course' => $course,
              'subject' => $subject,
              'topic' => $topic,
              'lesson' => $lesson,
              ]) }}"
                class="btn btn-success rounded-pill px-5 borde-top">
                Practice
               </a>
            </div>

          @elseif($lesson->hasQuiz())

         <a href="{{ route('quiz.show',[$course,$lesson]) }}"
          class="btn btn-primary">
          Quiz
         </a>
          @endif
        </form>
    </div>
</div>
@endsection
