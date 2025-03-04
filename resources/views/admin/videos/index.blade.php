@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Liste des vidéos</h1>
    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">Ajouter une vidéo</a>
    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Type</th>
                <th> video </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($videos as $video)
            <tr>
                <td>{{ $video->title }}</td>
                <td>{{ Str::limit($video->description, 50) }}</td>
                <td>{{ $video->type }}</td>
                <td>
                    @php
                        $extension = pathinfo($video->file_path, PATHINFO_EXTENSION);
                        $isAudio = in_array($extension, ['mp3', 'mpeg']);
                    @endphp

                    @if($isAudio)
                        <audio controls>
                            <source src="{{ asset('storage/' . $video->file_path) }}" type="audio/{{ $extension }}">
                            Votre navigateur ne supporte pas la lecture des fichiers audio.
                        </audio>
                    @else
                        <video width="200" controls>
                            <source src="{{ asset('storage/' . $video->file_path) }}" type="video/{{ $extension }}">
                            Votre navigateur ne supporte pas la lecture des vidéos.
                        </video>
                    @endif
                </td>


                <td>
                    <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection