@extends('layouts.app')

@section('title','Practice Completed')

@section('content')

<div class="container">

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body text-center p-5">

            <div class="mb-4">

                <i class="bi bi-check-circle-fill text-success"
                   style="font-size:80px"></i>

            </div>

            <h2 class="fw-bold text-success">

                Practice Saved Successfully

            </h2>

            <p class="text-muted mt-3">

                Your practice answers have been saved.

                You can come back anytime and edit them again.

            </p>

            <hr class="my-4">

            <div class="d-flex justify-content-center gap-3">

                <a href="{{ route('practice.show',[
                   'course' => $course,
                   'subject' => $subject,
                   'topic' => $topic,
                  'lesson' => $lesson,]) }}"
                   class="btn btn-outline-success">

                    <i class="bi bi-pencil-square"></i>

                    Edit Practice

                </a>

                @if($lesson->hasQuiz())

                    <a href="{{ route('quiz.show',[ 
                      'course' => $course,
                      'subject' => $subject,
                      'topic' => $topic,
                      'lesson' => $lesson,
                      ]) }}"
                       class="btn btn-primary">

                        Continue To Quiz →

                    </a>

                @else

                    @if($next)

                        <a href="{{ route('lessons.show',[$course,$next]) }}"
                           class="btn btn-primary">

                            Next Lesson →

                        </a>

                    @else

                        <a href="{{ route('courses.show',$course) }}"
                           class="btn btn-primary">

                            Back To Course

                        </a>

                    @endif

                @endif

            </div>

        </div>

    </div>

</div>

@endsection