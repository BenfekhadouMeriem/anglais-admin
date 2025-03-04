@extends('admin.layouts.app')

@section('content')
    <h1>Contents</h1>
    <a href="{{ route('admin.contents.create') }}">Add New Content</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Free</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contents as $content)
                <tr>
                    <td>{{ $content->title }}</td>
                    <td>{{ ucfirst($content->type) }}</td>
                    <td>{{ $content->is_free ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.contents.show', $content->id) }}">View</a>
                        <a href="{{ route('admin.contents.edit', $content->id) }}">Edit</a>
                        <form action="{{ route('admin.contents.destroy', $content->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
