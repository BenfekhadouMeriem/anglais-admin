@extends('admin.layouts.app')

@push('page-css')
    
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Edit podcast</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item active">Dashboard</li>
	</ul>
</div>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12 col-lg-12">
    
        <div class="card card-table">
            <div class="card-header">
                <h4 class="card-title ">Edit podcast</h4>
            </div>
            <div class="card-body">
                <div class="p-5">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.contents.update', $content->id) }}">
                        @csrf
                        @method("PUT")

                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title podcast"  value="{{ $content->title }}" >
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea name="description" class="form-control">{{ $content->description }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Type:</label>
                                        <div class="form-group">
                                            <select name="type" class="select2 form-select form-control" required>
                                                <option value="adult" {{ $content->type == 'adult' ? 'selected' : '' }}>adult</option>
                                                <option value="young" {{ $content->type == 'young' ? 'selected' : '' }}>young</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>Category:</label>
                                        <div class="form-group">
                                            <select name="category_id" class="select2 form-select form-control" required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $category->id == $content->category_id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Current image:</label>
                                        <div class="form-group">
                                            @if ($content->image_path)
                                                <p><img src="{{ Storage::url($content->image_path) }}" alt="Current Image" width="150"></p>
                                            @else
                                                <p>No image uploaded.</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>Current File:</label>
                                        <div class="form-group">
                                            <br>
                                            <p><a href="{{ Storage::url($content->file_path) }}" target="_blank">View File</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Upload New Image (optional)</label>
                                        <div class="form-group">
                                            <input type="file" name="image" accept="image/*" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>Upload New File (optional)</label>
                                        <div class="form-group">
                                            <input type="file" name="file" accept="audio/mp3,video/mp4" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <br>
                                    <input type="checkbox" name="is_free" {{ $content->is_free ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_free">
                                        <i class="fas fa-gift me-1 text-success"></i> Is this podcast free?
                                    </label>
                                    <small class="text-muted d-block">Toggle this ON if the podcast is offered for free.</small>
                                </div>
                            </div>

                        </div>
                        <br><br>
                        <button type="submit" class="btn btn-success btn-block">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>

    
</div>

@endsection

@push('page-js')
    
@endpush
