@extends('layouts.app')

@section('title', 'Manage Quiz')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <a href="{{ route('admin.lessons.index',[$course,$subject,$topic]) }}"
               class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left"></i>
                Back to Lessons
            </a>

            <h2 class="fw-bold text-primary mb-0">
                <i class="bi bi-ui-checks-grid"></i>
                Quiz Management
            </h2>

            <small class="text-muted">
                {{ $course->title }}
                →
                {{ $topic->title }}
                →
                {{ $lesson->title }}
            </small>

        </div>

        <span class="badge bg-primary fs-6">
            {{ $quiz->questions->count() }} Questions
        </span>

    </div>


    {{-- Quiz Settings --}}

    <div class="card shadow border-0 rounded-4 mb-4">

        <div class="card-header bg-primary text-white rounded-top-4 py-3">

            <h5 class="mb-0">
                <i class="bi bi-gear-fill"></i>
                Quiz Settings
            </h5>

        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.quizzes.update',[$course,$subject,$topic,$lesson,$quiz]) }}">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-lg-6">

                        <label class="form-label fw-semibold">

                            Quiz Title

                        </label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="{{ $quiz->title }}"
                            required>

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Pass Mark

                        </label>

                        <input
                            type="number"
                            class="form-control"
                            name="pass_mark"
                            value="{{ $quiz->pass_mark }}">

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Time Limit

                        </label>

                        <input
                            type="number"
                            class="form-control"
                            name="time_limit_minutes"
                            value="{{ $quiz->time_limit_minutes }}">

                    </div>

                </div>

                <button class="btn btn-primary mt-4">

                    <i class="bi bi-save"></i>

                    Save Settings

                </button>

            </form>

        </div>

    </div>


    {{-- Add Question --}}

    <div class="card shadow border-0 rounded-4 mb-4">

        <div class="card-header bg-success text-white rounded-top-4 py-3">

            <h5 class="mb-0">

                <i class="bi bi-plus-circle-fill"></i>

                Add New Question

            </h5>

        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.quiz-questions.store',[$course,$subject,$topic,$lesson,$quiz]) }}">

                @csrf

                <div class="row g-3">

                    <div class="col-md-3">

                        <label class="form-label fw-semibold">

                            Question Type

                        </label>

                        <input
                            class="form-control"
                            value="Short Answer"
                            readonly>

                    </div>

                    <div class="col-md-2">

                        <label class="form-label fw-semibold">

                            Points

                        </label>

                        <input
                            type="number"
                            name="points"
                            class="form-control"
                            value="1"
                            min="1">

                    </div>

                    <div class="col-12">

                        <label class="form-label fw-semibold">

                            Question

                        </label>

                        <textarea
                            rows="4"
                            class="form-control"
                            name="question_text"
                            placeholder="Write your question..."
                            required></textarea>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">

                            Correct Answer

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="correct_text"
                            placeholder="Correct Answer">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">

                            Explanation

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="explanation"
                            placeholder="Optional">

                    </div>

                </div>

                <button class="btn btn-success mt-4">

                    <i class="bi bi-plus-circle"></i>

                    Add Question

                </button>

            </form>

        </div>

    </div>


    {{-- Question List --}}

    <div class="card shadow border-0 rounded-4">

        <div class="card-header bg-dark text-white rounded-top-4 py-3">

            <h5 class="mb-0">

                <i class="bi bi-list-check"></i>

                Question List

            </h5>

        </div>

        <div class="card-body p-0">

            @if($quiz->questions->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                        <tr>

                            <th width="5%">#</th>

                            <th>Question</th>

                            <th width="25%">Correct Answer</th>

                            <th width="10%">Point</th>

                            <th width="10%">Action</th>

                        </tr>

                        </thead>

                        <tbody>

                        @foreach($quiz->questions as $question)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <td>

                                    <strong>

                                        {{ $question->question_text }}

                                    </strong>

                                    @if($question->explanation)

                                        <br>

                                        <small class="text-muted">

                                            {{ $question->explanation }}

                                        </small>

                                    @endif

                                </td>

                                <td>

                                    <span class="badge bg-success">

                                        {{ $question->correct_text }}

                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-primary">

                                        {{ $question->points }}

                                    </span>

                                </td>
<td>
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.quiz-questions.edit',[$course,$subject,$topic,$lesson,$quiz,$question]) }}"
           class="btn btn-warning btn-sm me-2">
             Edit
        </a>

        <form method="POST"
              action="{{ route('admin.quiz-questions.destroy',[$course,$subject,$topic,$lesson,$quiz,$question]) }}"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button onclick="return confirm('Delete this question?')"
                    class="btn btn-danger btn-sm">
                 Delete
            </button>
        </form>
    </div>
</td>
                          

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="bi bi-journal-x display-3 text-secondary"></i>

                    <h5 class="mt-3">

                        No Question Added Yet

                    </h5>

                    <p class="text-muted">

                        Add your first short-answer question.

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection