@extends('layouts.app')
@section('title', isset($course) ? 'Edit Course' : 'নতুন কোর্স যোগ করুন')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="eyebrow">Admin panel</span>
       <h1 class="page-heading mb-0">
         {{ isset($course) ? 'কোর্স এডিট করুন' : 'নতুন কোর্স যোগ করুন' }}
       </h1>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-dark">সব কোর্স</a>
</div>
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-lg-5">
        <form method="POST"
           action="{{ isset($course)
            ? route('admin.courses.update',$course)
            : route('admin.courses.store') }}"
            enctype="multipart/form-data"
            class="row g-3">
            @csrf

           @if(isset($course))
           @method('PUT')
           @endif
          <div class="col-md-8">
             <label class="form-label">কোর্সের নাম *</label>
             <input class="form-control" name="title" value="{{ old('title',$course->title ?? '') }}" required autofocus>
            </div>
            <div class="col-md-4">
                <label class="form-label">Display order</label>
                <input class="form-control" type="number" min="0" name="order" value="{{ old('order',$course->order ?? 0) }}">
            </div>
            <div class="col-12">
                <label class="form-label">বিবরণ</label>
                <textarea class="form-control" name="description" rows="4">{{ old('description',$course->description ?? '') }}</textarea>
            </div>
           <div class="col-12">
              <label class="form-label">Course Thumbnail </label>
              <input type="file" class="form-control" name="thumbnail" accept="image/*">
              @if(isset($course) && $course->thumbnail)

             <div class="mt-3">
             <img
              src="{{ asset('storage/'.$course->thumbnail) }}"
             width="220"
             class="rounded shadow">
             </div>

             @endif
              <small class="text-muted">
                 JPG, PNG, WEBP
                </small>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input type="hidden" name="is_published" value="0">
                    <input class="form-check-input" id="published" type="checkbox" name="is_published" value="1" @checked(old('is_published',$course->is_published ?? true))>
                    <label class="form-check-label" for="published">কোর্সটি প্রকাশ করুন</label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    {{ isset($course) ? 'কোর্স আপডেট করুন' : 'নতুন কোর্স যোগ করুন' }}
                </button>
                
            </div>
        </form>
    </div>
</div>
@endsection
