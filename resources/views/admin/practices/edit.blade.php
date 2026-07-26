@extends('layouts.app')

@section('title','Edit Practice')

@section('content')

<div class="container">

    <a href="{{ route('admin.practices.index',[$course,$subject,$topic,$lesson]) }}"
       class="btn btn-secondary mb-4">
        ← Back
    </a>

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h4 class="mb-0">
                Edit Practice
            </h4>

        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.practices.update',[$course,$subject,$topic,$lesson,$practice]) }}">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Question
                    </label>

                    <textarea
                        name="question"
                        class="form-control"
                        rows="2"
                        required>{{ old('question',$practice->question) }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Correct Answer
                    </label>

                    <textarea
                        name="correct_answer"
                        class="form-control"
                        rows="2"
                        required>{{ old('correct_answer',$practice->correct_answer) }}</textarea>

                </div>

                <div class="mb-3">

                    <label>
                        Serial
                    </label>

                    <input
                        type="number"
                        name="serial"
                        class="form-control"
                        value="{{ old('serial',$practice->serial) }}">

                </div>

                <button class="btn btn-primary">

                    Update Practice

                </button>

            </form>

        </div>

    </div>

</div>

@endsection