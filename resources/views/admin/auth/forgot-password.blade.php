<!-- resources/views/auth/forgot-password.blade.php -->
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Réinitialisation du mot de passe</h2>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email">Adresse e-mail</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer le lien</button>
        </form>
    </div>
@endsection
