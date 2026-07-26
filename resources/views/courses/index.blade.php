@extends('layouts.app')
@section('title', 'Courses — Fluently')
@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-lg-8 text-center">

        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
            📚 Course Library
        </span>

        <h1 class="display-4 fw-bold text-dark mb-3">
            Build <span class="text-primary">English</span> That Fits Your Life
        </h1>

        <p class="lead text-secondary mb-0">
            Choose a learning path, improve your skills, and achieve your goals
            with interactive lessons, practice exercises, and quizzes.
        </p>

    </div>
</div>
<div class="row g-4">@forelse($courses as $course)
    <div class="col-md-6 col-lg-4 mb-4">
    <article class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
        <div style="height:220px; overflow:hidden;">
          @if($course->thumbnail)
           <img
            src="{{ asset('storage/'.$course->thumbnail) }}"
            alt="{{ $course->title }}"
            class="w-100 h-100"
            style="object-fit:cover;">
            @else
          <div class="bg-primary bg-gradient text-white h-100 d-flex flex-column justify-content-center align-items-center">
             <i class="bi bi-journal-bookmark-fill display-3"></i>
              @if($course->difficulty)
                <span class="badge bg-light text-primary mt-3">
                    {{ $course->difficulty }}
                </span>
             @endif
            </div>
            @endif
       </div>

        <div class="card-body d-flex flex-column">

            <div class="d-flex justify-content-between text-muted small mb-2">
                <span>
                    <i class="bi bi-collection-play me-1"></i>
                    {{ $course->lessons()->count() }} Lessons
                </span>

                <span>
                    <i class="bi bi-clock me-1"></i>
                    {{ $course->duration_minutes ?: 30 }} Min
                </span>
            </div>

            <h5 class="fw-bold mb-2">
                {{ $course->title }}
            </h5>

            <p class="text-secondary small flex-grow-1">
                {{ Str::limit($course->description, 115) }}
            </p>

            @auth

            <div class="d-flex justify-content-between small mb-2">
                <span class="fw-semibold">Progress</span>
                <span>{{ $course->progress_percent }}%</span>
            </div>

            <div class="progress rounded-pill mb-4" style="height:8px;">
                <div class="progress-bar bg-success"
                     role="progressbar"
                     style="width: {{ $course->progress_percent }}%">
                </div>
            </div>

            @endauth

            <a href="{{ route('courses.show',$course) }}"
               class="btn btn-primary rounded-pill w-100">
                Explore Course
                <i class="bi bi-arrow-right ms-1"></i>
            </a>

        </div>

    </article>
</div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            No courses have been published yet.
        </div>
    </div>@endforelse
</div>
@endsection
