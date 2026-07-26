@extends('layouts.app')
@section('title','Manage lessons')
@section('content')
<a href="{{ route('admin.topics.index',[$course,$subject]) }}" class="small text-secondary text-decoration-none">← Chapters</a>
<h1 class="page-heading mt-2">{{ $topic->title }} — Lessons</h1>
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <form method="POST" enctype="multipart/form-data" class="row g-3" action="{{ route('admin.lessons.store',[$course,$subject,$topic]) }}">@csrf
        <div class="col-md-8">
            <input class="form-control" name="title" placeholder="Lesson title" required>
        </div>
        <div class="col-md-2">
            <input class="form-control" name="order" type="number" min="1" value="{{ $lessons->count()+1 }}">
        </div>
        <div class="col-md-2">
            <input class="form-control" name="duration_minutes" type="number" min="1" value="10">
        </div>
        <div class="col-12">
            <input  id="editor" class="form-control" name="text_content"  placeholder="Lesson content">
        </div>
        <div class="col-md-6">
           <input class="form-control" name="video_url" placeholder="Video URL (optional)">
        </div>

        <div class="col-md-6">
           <label class="form-label"> Lesson Image </label>
           <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="col-md-6">
            <input class="form-control" name="audio_url" placeholder="Audio URL (optional)">
        </div>
        <div class="col-12">
            <button class="btn btn-brand">Add lesson</button>
        </div>
        
    </form>
</div>
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">@forelse($lessons as $lesson)
    <div class="d-flex p-3 border-bottom align-items-center">
        <span class="me-3 text-muted">{{ $lesson->order }}</span>
        <div class="flex-grow-1"><strong>{{ $lesson->title }}</strong>
           <div class="small text-muted">
                 {{ $lesson->duration_minutes }} min
            </div>
        </div>
        <a href="{{ route('admin.practices.index',[$course,$subject,$topic,$lesson])}}" class="btn btn-sm btn-outline-success me-2"> Practice </a>
        <a href="{{ route('admin.quizzes.edit', [$course,$subject,$topic, $lesson]) }}" class="btn btn-sm btn-outline-primary me-2"> Quiz</a>
        <a href="{{ route('admin.lessons.edit', [$course,$subject,$topic,$lesson]) }}" class="btn btn-sm btn-outline-warning me-2"> Edit</a>
        <form method="POST" action="{{ route('admin.lessons.destroy',[$course,$subject,$topic,$lesson]) }}">@csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Delete</button>
            
        </form>
    </div>@empty
    <div class="p-4 text-muted">
        No lessons added yet.
    </div>@endforelse
</div>
@endsection
@section('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>

@endsection
