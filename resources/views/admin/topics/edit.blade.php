@extends('layouts.app')

@section('title','Edit Chapter')

@section('content')

<div class="container">

    <a href="{{ route('admin.topics.index',[$course ,$subject]) }}"
       class="btn btn-secondary mb-4">
        ← Back
    </a>

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h4>Edit Chapter</h4>

        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.topics.update',[$course,$subject,$topic]) }}">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Title</label>

                    <input
                        class="form-control"
                        name="title"
                        value="{{ old('title',$topic->title) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Description</label>

                    <textarea
                        class="form-control"
                        rows="4"
                        name="description">{{ old('description',$topic->description) }}</textarea>

                </div>

                <div class="mb-3">

                    <label>Serial</label>

                    <input
                        type="number"
                        class="form-control"
                        name="serial"
                        value="{{ old('serial',$topic->serial) }}"
                        required>

                </div>

                <button class="btn btn-success">

                    Update Chapter

                </button>

            </form>

        </div>

    </div>

</div>

@endsection