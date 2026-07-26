@extends('layouts.app')

@section('title','Edit Quiz Question')

@section('content')

<div class="container">

    <a href="{{ route('admin.quizzes.edit',[$course,$subject,$topic,$lesson]) }}"
       class="btn btn-secondary mb-4">
        ← Back
    </a>

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h4 class="mb-0">
                Edit Question
            </h4>

        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.quiz-questions.update',[$course,$subject,$topic,$lesson,$quiz,$question]) }}">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Question
                    </label>

                    <textarea
                        class="form-control"
                        name="question_text"
                        rows="4"
                        required>{{ old('question_text',$question->question_text) }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Correct Answer
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="correct_text"
                        value="{{ old('correct_text',$question->correct_text) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Explanation
                    </label>

                    <textarea
                        class="form-control"
                        name="explanation"
                        rows="3">{{ old('explanation',$question->explanation) }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Points
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        name="points"
                        value="{{ old('points',$question->points) }}"
                        min="1">

                </div>

                <button class="btn btn-primary">
                    Update Question
                </button>

            </form>

        </div>

    </div>

</div>

@endsection