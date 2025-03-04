@extends('admin.layouts.app')

@section('content')
    <h1>{{ $content->title }}</h1>
    <p><strong>Type:</strong> {{ ucfirst($content->type) }}</p>
    <p><strong>Description:</strong> {{ $content->description }}</p>
    <p><strong>Free:</strong> {{ $content->is_free ? 'Yes' : 'No' }}</p>

    <p><strong>File:</strong></p>

    @php
        $extension = pathinfo($content->file_path, PATHINFO_EXTENSION);
        $isAudio = in_array($extension, ['mp3', 'mpeg']);
    @endphp

    @if($isAudio)
        <audio controls>
            <source src="{{ asset('storage/' . $content->file_path) }}" type="audio/{{ $extension }}">
            Votre navigateur ne supporte pas la lecture des fichiers audio.
        </audio>
    @else
        <video width="200" controls>
            <source src="{{ asset('storage/' . $content->file_path) }}" type="video/{{ $extension }}">
            Votre navigateur ne supporte pas la lecture des vidéos.
        </video>
    @endif


    <h3>Transcription:</h3>

    @if(!empty($content->transcription))
        <p>{!! nl2br(e(strip_tags($content->transcription))) !!}</p>
    @else
        <p><em>Aucune transcription disponible.</em></p>
    @endif



    <a href="{{ route('admin.contents.edit', $content->id) }}">Edit</a>
    <form action="{{ route('admin.contents.destroy', $content->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
@endsection
