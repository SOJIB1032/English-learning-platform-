@extends('layouts.app')

@section('title','Manage Subjects')

@section('content')

<a href="{{ route('admin.courses.index') }}"
   class="btn btn-outline-secondary mb-4">

    ← Back

</a>

<h2 class="mb-4">

    {{ $course->title }}

</h2>


<div class="card shadow mb-4">

    <div class="card-header">

        Add Subject

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.subjects.store',$course) }}">

            @csrf

            <div class="row">

                <div class="col-md-5">

                    <input
                        name="title"
                        class="form-control"
                        placeholder="Subject Name"
                        required>

                </div>

                <div class="col-md-2">

                    <input
                        name="serial"
                        class="form-control"
                        type="number"
                        value="{{ $subjects->count()+1 }}">

                </div>

                <div class="col-md-5">

                    <button class="btn btn-success">

                        Add Subject

                    </button>

                </div>

            </div>

            <textarea
                name="description"
                class="form-control mt-3"
                placeholder="Description"></textarea>

        </form>

    </div>

</div>



<div class="card shadow">

    <div class="card-header">

        Subject List

    </div>

    <div class="card-body">

        @forelse($subjects as $subject)

            <div
                class="d-flex justify-content-between align-items-center border-bottom py-3">

                <div>

                    <strong>

                        {{ $subject->serial }}.
                        {{ $subject->title }}

                    </strong>

                    <br>

                    <small class="text-muted">

                        {{ $subject->topics_count }}

                        Chapters

                    </small>

                </div>

                <div>

                    <a
                        href="{{ route('admin.topics.index',[$course,$subject]) }}"
                        class="btn btn-primary btn-sm">

                        Chapters

                    </a>

                    <form
                        class="d-inline"
                        method="POST"
                        action="{{ route('admin.subjects.destroy',[$course,$subject]) }}">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Delete Subject?')"
                            class="btn btn-danger btn-sm">

                            Delete

                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="alert alert-warning">

                No Subject Found

            </div>

        @endforelse

    </div>

</div>

@endsection