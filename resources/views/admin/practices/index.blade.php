@extends('layouts.app')
@section('title','Practice Manager')
@section('content')

<div class="container">
    <a href="{{ route('admin.lessons.index',[$course,$subject,$topic]) }}"
       class="btn btn-secondary mb-4">
        ← Back
    </a>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Practice :
                {{ $lesson->title }}
            </h4>
        </div>

        <div class="card-body">
            <form method="POST"
                action="{{ route('admin.practices.store', [$course,$subject,$topic,$lesson]) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">
                       Question
                    </label>
                    <input
                      name="question"
                      class="form-control"
                      placeholder="Write your question here..."
                      required>
                    
                </div>

               <div class="mb-3">
                    <label class="form-label">
                      Correct Answer
                    </label>
                    <input
                      name="correct_answer"
                      class="form-control"
                      placeholder="Write your answer here..."
                      required>
                    
                    <small class="text-muted">
                      User এই উত্তর লিখলে Accepted দেখানো হবে।
                    </small>
                </div>

                <div class="mb-3">
                    <label> Serial </label>
                    <input type="number" name="serial" class="form-control">
                </div>

                <button class="btn btn-success">
                    Add Practice
                </button> 
            </form>
        </div>
    </div> 

    <br>

    <div class="card shadow">
        <div class="card-header">
            Practice List
        </div>

        <div class="card-body">
            @forelse($lesson->practices as $practice)

                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <strong>
                            {{ $practice->serial }}.
                          </strong>
                            {{ $practice->question }}
                            <br>
                          <small class="text-success">
                             <strong>Correct Answer:</strong>
                               {{ $practice->correct_answer }}
                            </small>
                        </div>
                        <div class="d-flex align-items-center">
                         <a href="{{route('admin.practices.edit', [$course,$subject,$topic,$lesson,$practice]) }}" class="btn btn-warning btn-sm me-2"> Edit </a>
                
                        <form method="POST" action="{{ route('admin.practices.destroy',[$course,$subject,$topic,$lesson,$practice]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                        </div>
                    </div>
                </div>

            @empty

                <div class="alert alert-warning">
                    No Practice Question.
                </div>

            @endforelse

        </div>
    </div>
</div>

@endsection