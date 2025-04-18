@extends('admin.layouts.app')

@push('page-css')
    
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Create Podcast</h3>
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
                <h4 class="card-title ">Add Podcast</h4>
            </div>
            <div class="card-body">
                <div class="p-5">
                    <form method="POST" enctype="multipart/form-data" action="{{route('admin.contents.store')}}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title podcast">
                                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="Description" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="row">
                                    <!-- Type Selection -->
                                    <div class="col-6">
                                        <label for="type">Type:</label>
                                        <div class="form-group">
                                            <select id="type" name="type" class="select2 form-select form-control" required>
                                                <option value="adult">Adult</option>
                                                <option value="young">Young</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Category Selection -->
                                    <div class="col-6">
                                        <label for="category">Category</label>
                                        <div class="form-group">
                                            <select id="category" class="select2 form-select form-control" name="category_id" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="image">Image</label>
                                        <div class="form-group">
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>File (MP3/MP4)</label>
                                        <div class="form-group">
                                            <input type="file" name="file" required accept="audio/mp3,video/mp4" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <br>
                                    <input class="form-check-input" type="checkbox" id="is_free" name="is_free">
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
