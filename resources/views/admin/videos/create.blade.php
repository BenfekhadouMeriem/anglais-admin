@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une vidéo</h1>
    <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="file">Fichier vidéo</label>
            <input type="file" name="file" class="form-control" accept="video/mp4,video/mov,video/avi,audio/mp3,audio/mpeg" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" class="form-control" required>
                <option value="free">Gratuit</option>
                <option value="paid">Payant</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
@endsection