@extends('layouts.app')

@section('title','Edit Lesson')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Edit Lesson
    </h2>

    <form method="POST" enctype="multipart/form-data" 
    action="{{ route('admin.lessons.update',[$course,$subject,$topic,$lesson]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Lesson Title</label>
            <input
                type="text"
                name="title"
                class="form-control"
                value="{{ old('title',$lesson->title) }}"
                required>
        </div>
        <div class="mb-3">
            <label>Lesson Content</label>
            <textarea
                id="editor"
                name="text_content"
                class="form-control"
                rows="10">{{ old('text_content',$lesson->text_content) }}
            </textarea>
        </div>

        <div class="row">

            <div class="col-md-6">

                <label>Video URL</label>

                <input
                    type="url"
                    name="video_url"
                    class="form-control"
                    value="{{ old('video_url',$lesson->video_url) }}">

            </div>

            <div class="col-12 mb-3">
              <label> Lesson Image </label>
              <input type="file" name="image" class="form-control">
              @if($lesson->image)
           <img src="{{ asset('storage/'.$lesson->image) }}" class="img-fluid rounded shadow mb-3" width="250">
            @endif
            </div>

            <div class="col-md-6">

                <label>Audio URL</label>

                <input
                    type="url"
                    name="audio_url"
                    class="form-control"
                    value="{{ old('audio_url',$lesson->audio_url) }}">

            </div>

        </div>

        <div class="row mt-3">

            <div class="col-md-6">

                <label>Order</label>

                <input
                    type="number"
                    name="order"
                    class="form-control"
                    value="{{ old('order',$lesson->order) }}">

            </div>

            <div class="col-md-6">

                <label>Duration</label>

                <input
                    type="number"
                    name="duration_minutes"
                    class="form-control"
                    value="{{ old('duration_minutes',$lesson->duration_minutes) }}">

            </div>

        </div>

        <button class="btn btn-primary mt-4">

            Update Lesson

        </button>

    </form>

</div>

@endsection

@section('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => console.error(error));
</script>

@endsection