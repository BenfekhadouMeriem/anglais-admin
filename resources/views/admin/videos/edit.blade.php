@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la vidéo</h1>
    <form action="{{ route('admin.videos.update', $video) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ $video->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $video->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="file">Fichier vidéo (laisser vide pour ne pas changer)</label>
            <input type="file" name="file" class="form-control" accept="video/mp4,video/mov,video/avi,audio/mp3,audio/mpeg">
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" class="form-control" required>
                <option value="free" {{ $video->type == 'free' ? 'selected' : '' }}>Gratuit</option>
                <option value="paid" {{ $video->type == 'paid' ? 'selected' : '' }}>Payant</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection