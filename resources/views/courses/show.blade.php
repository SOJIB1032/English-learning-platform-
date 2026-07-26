@extends('layouts.app')

@section('title', $course->title . ' — English Path')

@section('content')
@php
    $objectives = $course->learning_objectives ?: [
        'Useful phrases for everyday conversations',
        'Vocabulary you can use right away',
        'Confidence to speak without overthinking',
    ];
@endphp

<div class="row g-4">
    <div class="col-lg-8">
        <a href="{{ route('courses.index') }}"
   class="text-decoration-none fw-semibold text-primary">
    <i class="bi bi-arrow-left-circle me-1"></i>
    সব কোর্সে ফিরে যান
</a>
        <span class="eyebrow d-block mt-4">{{ $course->difficulty }} · {{ $course->duration_minutes ?: 30 }} মিনিট</span>
        <h1 class="page-heading display-5">{{ $course->title }}</h1>
        <p class="lead text-secondary">{{ $course->overview ?: $course->description }}</p>

        <div class="card border-0 shadow-sm rounded-4 mt-4">
            <div class="card-body p-4">
                <h2 class="h5">আপনি যা শিখবেন</h2>
                <div class="row">
                    @foreach ($objectives as $objective)
                        <div class="col-md-6 mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $objective }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <aside class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-2 " style="top:90px">
            <div class="card-body ">
                <div class="course-art art-2 rounded-3 mb-3"><i class="bi bi-play-circle"></i></div>
                <div class="small text-muted">{{ $lessons->count() }} টি লেসন</div>
                <h2 class="h5">শুরু করার জন্য প্রস্তুত?</h2>
                @auth
                   <a class="btn btn-brand w-100"
                  href="{{$lessons->first() ? route('lessons.show', [
                  $course,
                  $lessons->first()->topic->subject,
                 $lessons->first()->topic,
                 $lessons->first()
                 ]) : '#' }}">
                        কোর্স শুরু করুন 
                        <i class="bi bi-arrow-right"></i>
                    </a> @else
                    <a class="btn btn-brand w-100" href="{{ route('register') }}">ফ্রি অ্যাকাউন্ট খুলুন</a>
                @endauth
            </div>
        </div>
    </aside>
</div>

<section class="mt-5">

    <h2 class="page-heading h2 mb-4">
        <i class="bi bi-journal-bookmark-fill text-primary me-2"></i>
        Course Contents
    </h2>

    <div class="accordion" id="subjectsAccordion">

        @forelse($course->subjects as $subject)

            <div class="accordion-item border rounded-4 shadow-sm mb-3 overflow-hidden">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed fw-bold"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#subject{{ $subject->id }}">

                        <div class="w-100 d-flex justify-content-between align-items-center">

                            <div>

                                <i class="bi bi-folder2-open text-primary me-2"></i>

                                Subject {{ $subject->serial }} :
                                {{ $subject->title }}

                            </div>

                            <span class="badge bg-primary rounded-pill">

                                {{ $subject->topics->count() }}
                                Chapters

                            </span>

                        </div>

                    </button>

                </h2>

                <div id="subject{{ $subject->id }}"
                     class="accordion-collapse collapse"
                     data-bs-parent="#subjectsAccordion">

                    <div class="accordion-body p-0">

                        <div class="accordion"
                             id="topicAccordion{{ $subject->id }}">

                            @foreach($subject->topics as $topic)

                                <div class="accordion-item border-0 border-bottom">

                                    <h2 class="accordion-header">

                                        <button class="accordion-button collapsed bg-light"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#topic{{ $topic->id }}">

                                            <div class="w-100 d-flex justify-content-between align-items-center">

                                                <div>

                                                    <i class="bi bi-book-half text-success me-2"></i>

                                                    Chapter {{ $topic->serial }}

                                                    :

                                                    {{ $topic->title }}

                                                </div>

                                                <span class="badge bg-success rounded-pill">

                                                    {{ $topic->lessons->count() }}

                                                    Lessons

                                                </span>

                                            </div>

                                        </button>

                                    </h2>

                                    <div id="topic{{ $topic->id }}"
                                         class="accordion-collapse collapse"
                                         data-bs-parent="#topicAccordion{{ $subject->id }}">

                                        <div class="list-group list-group-flush">

                                            @forelse($topic->lessons as $lesson)

                                                <div class="list-group-item py-3">

                                                    <div class="d-flex justify-content-between align-items-center">

                                                        <div class="d-flex align-items-center">

                                                            <span
                                                                class="rounded-circle me-3
                                                                {{ $lesson->is_completed ? 'bg-success text-white' : 'bg-light' }}"
                                                                style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">

                                                                @if($lesson->is_completed)

                                                                    <i class="bi bi-check-lg"></i>

                                                                @else

                                                                    {{ $lesson->order }}

                                                                @endif

                                                            </span>

                                                            <div>

                                                                <strong>

                                                                    {{ $lesson->title }}

                                                                </strong>

                                                                <div class="small text-muted mt-1">

                                                                    <i class="bi bi-clock me-1"></i>

                                                                    {{ $lesson->duration_minutes }}
                                                                    Minutes

                                                                    @if($lesson->practices->count())

                                                                        <span class="badge bg-warning text-dark ms-2">

                                                                            Practice

                                                                        </span>

                                                                    @endif

                                                                    @if($lesson->hasQuiz())

                                                                        <span class="badge bg-info ms-2">

                                                                            Quiz

                                                                        </span>

                                                                    @endif

                                                                </div>

                                                            </div>

                                                        </div>

                                                        @auth

                                                            <a href="{{ route('lessons.show',[
                                                                'course'=>$course,
                                                                'subject'=>$lesson->topic->subject,
                                                                'topic'=>$lesson->topic,
                                                                'lesson'=>$lesson
                                                            ]) }}"
                                                               class="btn btn-primary btn-sm rounded-pill px-3">

                                                                <i class="bi bi-play-fill"></i>

                                                                Start

                                                            </a>

                                                        @endauth

                                                    </div>

                                                </div>

                                            @empty

                                                <div class="p-4 text-muted">

                                                    No lessons found.

                                                </div>

                                            @endforelse

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="alert alert-warning">

                No Subject Found.

            </div>

        @endforelse

    </div>

</section>
@endsection
