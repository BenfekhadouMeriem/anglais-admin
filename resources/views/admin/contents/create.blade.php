@extends('admin.layouts.app')

@section('content')
    <h1>Add New Content</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('admin.contents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description"></textarea>

        <label>Type:</label>
        <select name="type" required>
            <option value="video">Video</option>
            <option value="podcast">Podcast</option>
        </select>

        <label>File (MP3/MP4):</label>
        <input type="file" name="file" required accept="audio/mp3,video/mp4">

        <label>Is Free?</label>
        <input type="checkbox" name="is_free">

        <button type="submit">Save</button>
    </form>
@endsection
