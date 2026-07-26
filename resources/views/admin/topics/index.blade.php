@extends('layouts.app')
@section('title','Manage chapters')
@section('content')
<a href="{{ route('admin.subjects.index',$course) }}" class="small text-secondary text-decoration-none">
    ← {{ $course->title }}
</a>
<h1 class="page-heading mt-2">Chapters</h1>
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <h2 class="h5">Add chapter</h2>
   <form class="row g-3" method="POST" action="{{ route('admin.topics.store',[$course,$subject]) }}">@csrf
        <div class="col-md-6">
          <input class="form-control" name="title" placeholder="Chapter title" required>
        </div>
        <div class="col-md-2">
         <input class="form-control" name="serial" type="number" min="1" value="{{ $topics->count()+1 }}" required>
        </div>
        <div class="col-md-4">
           <button class="btn btn-brand">Add chapter</button>
        </div>
        <div class="col-12">
         <textarea class="form-control" name="description" placeholder="Short description (optional)"></textarea>
        </div>
    </form>
</div>
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">@forelse($topics as $topic)
    <div class="p-4 border-bottom d-flex gap-3 align-items-center">
        <span class="badge text-bg-light">{{ $topic->serial }}</span>
        <div class="flex-grow-1"><strong>{{ $topic->title }}</strong>
           <div class="small text-muted">
             {{ $topic->lessons_count }} lessons
           </div>
       </div>
       <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.lessons.index',[$course,$subject,$topic]) }}">Lessons</a>
       <a href="{{ route('admin.topics.edit',[$course,$subject,$topic]) }}"class="btn btn-sm btn-outline-primary">Edit</a>
       <form method="POST" action="{{ route('admin.topics.destroy',[$course,$subject,$topic]) }}">@csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this chapter?')">Delete</button>
       </form>
    </div>@empty
    <div class="p-4 text-muted">
        Add your first chapter.
    </div>@endforelse
</div>
@endsection
