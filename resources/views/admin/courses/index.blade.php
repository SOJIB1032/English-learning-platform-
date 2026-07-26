@extends('layouts.app')
@section('title', 'Admin courses')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="eyebrow">Admin panel</span>
        <h1 class="page-heading mb-0">কোর্স ম্যানেজমেন্ট</h1>
    </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-brand">
        <i class="bi bi-plus-lg"></i> নতুন কোর্স</a>
    </div>
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">কোর্স</th>
                    <th>Chapter</th><th>Lesson</th>
                    <th class="text-end pe-4">ম্যানেজ করুন</th>
                </tr>
            </thead>
           <tbody>@forelse($courses as $course)
                <tr>
                    <td class="ps-4"><strong>{{ $course->title }}</strong>
                       <div class="small text-muted">{{ $course->is_published ? 'Published' : 'Draft' }}</div>
                    </td>
                    <td>{{ $course->topics_count }}</td>
                    <td>{{ $course->lessons_count }}</td>
                    <td class="text-end pe-4">
                        <div class="d-inline-flex gap-2">
                         <form method="POST"
                          action="{{ route('admin.courses.destroy', $course) }}"
                          onsubmit="return confirm('Are you sure you want to delete this course?')">
                         @csrf
                         @method('DELETE')
                         <button type="submit" class="btn btn-sm btn-outline-danger">
                         <i class="bi bi-trash"></i> Delete
                         </button>
                         <a href="{{ route('admin.courses.edit', $course) }}"
                          class="btn btn-sm btn-outline-primary">
                           <i class="bi bi-pencil"></i> Edit
                          </a>
                          </form>
                        </div>
                        <a
                          href="{{ route('admin.subjects.index',$course) }}"
                          class="btn btn-sm btn-outline-primary">
                          <i class="bi bi-bookmarks"></i>
                           Subjects
                        </a>
                    </td>
                </tr>@empty
                <tr>
                    <td colspan="4" class="text-center text-muted p-4">এখনও কোনো কোর্স নেই।</td>
                </tr>@endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
