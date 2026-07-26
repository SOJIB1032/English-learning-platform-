@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container py-4">

    {{-- Welcome Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>
                    <h2 class="fw-bold mb-1">
                        Welcome, {{ auth()->user()->name }} 👋
                    </h2>

                    <p class="text-muted mb-0">
                        Continue your English learning journey.
                    </p>
                </div>

                <div class="text-end mt-3 mt-md-0">

                    <h3 class="fw-bold text-primary mb-1">
                        {{ $overallPercent }}%
                    </h3>

                    <small class="text-muted">
                        Overall Progress
                    </small>

                </div>

            </div>

            <div class="progress mt-4" style="height:12px;">
                <div
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width: {{ $overallPercent }}%">
                </div>
            </div>

        </div>
    </div>


    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold mb-0">
            My Courses
        </h3>

        <span class="badge bg-primary fs-6">
            {{ $courses->count() }} Courses
        </span>

    </div>


    <div class="row g-4">

        @forelse($courses as $course)

            <div class="col-lg-4 col-md-6">

                <div class="card h-100 border-0 shadow-sm rounded-4">

                    @if($course->thumbnail)

                        <img
                            src="{{ asset('storage/'.$course->thumbnail) }}"
                            class="card-img-top"
                            style="height:220px;object-fit:cover;">

                    @else

                        <div class="bg-primary text-white d-flex align-items-center justify-content-center"
                             style="height:220px;">

                            <div class="text-center">

                                <i class="bi bi-book fs-1"></i>

                                <h4 class="mt-2">
                                    English Course
                                </h4>

                            </div>

                        </div>

                    @endif


                    <div class="card-body">

                        <h4 class="fw-bold">
                            {{ $course->title }}
                        </h4>

                        <p class="text-muted small">

                            {{ Str::limit($course->description,100) }}

                        </p>

                        <div class="d-flex justify-content-between mb-2">

                            <span>

                                <i class="bi bi-play-circle"></i>

                                {{ $course->total_lessons }} Lessons

                            </span>

                            <strong class="text-success">

                                {{ $course->progress_percent }}%

                            </strong>

                        </div>

                        <div class="progress mb-3" style="height:8px;">

                            <div
                                class="progress-bar bg-success"
                                style="width: {{ $course->progress_percent }}%">
                            </div>

                        </div>

                    </div>

                    <div class="card-footer bg-white border-0 pb-4">

                        <a
                            href="{{ route('courses.show',$course) }}"
                            class="btn btn-primary w-100 rounded-pill">

                            Continue Learning

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info text-center">

                    No courses available.

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection