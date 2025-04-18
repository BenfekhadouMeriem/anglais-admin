@extends('admin.layouts.app')

@push('page-header')
<div class="col">
    <h3 class="page-title">Podcast Details</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Podcast</li>
    </ul>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0"><i class="fas fa-headphones me-2 text-dark"></i>{{ $content->title }}</h2>
                <div>
                    <a href="{{ route('admin.contents.edit', $content->id) }}" class="btn btn-sm btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.contents.destroy', $content->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <p><strong>Type:</strong> {{ ucfirst($content->type) }}</p>
            <p><strong>Description:</strong> {{ $content->description }}</p>
            <p><strong>Free:</strong> 
                @if($content->is_free)
                    <span class="badge bg-success">Yes</span>
                @else
                    <span class="badge bg-secondary">No</span>
                @endif
            </p>
            <p><strong>Category:</strong> {{ $content->category->name ?? 'No Category' }}</p>

            <div class="my-3">
                <p><strong>File:</strong></p>
                @php
                    $extension = pathinfo($content->file_path, PATHINFO_EXTENSION);
                    $isAudio = in_array($extension, ['mp3', 'mpeg']);
                @endphp

                @if($isAudio)
                    <audio controls class="w-100">
                        <source src="{{ asset('storage/' . $content->file_path) }}" type="audio/{{ $extension }}">
                        Your browser does not support the audio element.
                    </audio>
                @else
                    <video controls class="w-100" style="max-width: 500px;">
                        <source src="{{ asset('storage/' . $content->file_path) }}" type="video/{{ $extension }}">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>

            <div class="mb-3">
                <p><strong>Image:</strong></p>
                <img src="{{ $content->image_path ? asset('storage/' . $content->image_path) : asset('images/default-thumbnail.jpg') }}"
                     alt="Podcast Image" class="img-thumbnail" style="max-width: 150px;">
            </div>

            <div>
                <h4><i class="fas fa-align-left me-2"></i>Transcription</h4>
                @if(!empty($content->transcription))
                    <div class="bg-light p-3 rounded border">
                        {!! nl2br(e(strip_tags($content->transcription))) !!}
                    </div>
                @else
                    <p><em>No transcription available.</em></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
