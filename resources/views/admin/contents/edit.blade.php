@extends('admin.layouts.app')

@section('content')
    <h1>Edit Content</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('admin.contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Title:</label>
        <input type="text" name="title" value="{{ $content->title }}" required>

        <label>Description:</label>
        <textarea name="description">{{ $content->description }}</textarea>

        <label>Type:</label>
        <select name="type" required>
            <option value="video" {{ $content->type == 'video' ? 'selected' : '' }}>Video</option>
            <option value="podcast" {{ $content->type == 'podcast' ? 'selected' : '' }}>Podcast</option>
        </select>

        <label>Current File:</label>
        <p><a href="{{ Storage::url($content->file_path) }}" target="_blank">View File</a></p>

        <label>Upload New File (optional):</label>
        <input type="file" name="file" accept="audio/mp3,video/mp4">

        <label>Is Free?</label>
        <input type="checkbox" name="is_free" {{ $content->is_free ? 'checked' : '' }}>

        <button type="submit">Update</button>
    </form>
@endsection
