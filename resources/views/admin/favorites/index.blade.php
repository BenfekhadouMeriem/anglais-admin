@extends('admin.layouts.app')

@section('content')
    <h1>Your Favorite Contents</h1>

    @if($favorites->isEmpty())
        <p>You have no favorite contents yet.</p>
    @else
        <ul>
            @foreach($favorites as $favorite)
                <li>
                    <a href="{{ route('admin.contents.show', $favorite->id) }}">{{ $favorite->title }}</a>
                    <!-- Affichez plus d'informations sur le contenu ici -->
                </li>
            @endforeach
        </ul>
    @endif
@endsection
