@extends('admin.layouts.app')

<x-assets.datatables />  

@push('page-css')
	
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Podcast</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">podcast</li>
	</ul>
</div>
<div class="col-sm-5 col">
    <a href="{{ route('admin.contents.create') }}" class="btn btn-success float-right mt-2">+ Add podcast</a>
</div>

@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
                    <form method="GET" action="{{ route('admin.category.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Rechercher une catégorie...">
                            <button class="btn btn-outline-secondary btn-sm" type="submit">
                                <i class="fas fa-search"></i> {{-- Icône de recherche --}}
                            </button>
                        </div>
                    </form>
					<table id="user-table" class="datatable table table-striped table-bordered table-hover table-center mb-0">
						<thead>
							<tr style="boder:1px solid black;">
                                <th>Title</th>
                                <th>Type</th>
                                <th>Free</th>
                                <th>Category</th>
								<th class="text-center action-btn">Actions</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($contents as $content)
                                <tr>
                                    <td>{{ $content->title }}</td>
                                    <td>{{ ucfirst($content->type) }}</td>
                                    <td>{{ $content->is_free ? 'Yes' : 'No' }}</td>
                                    <td>{{ $content->category->name ?? 'No Category' }}</td> 
                                    <td class="text-center">
                                        <!-- View button with icon -->
                                        <a href="{{ route('admin.contents.show', $content->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit button -->
                                        <a href="{{ route('admin.contents.edit', $content->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete form -->
                                        <form action="{{ route('admin.contents.destroy', $content->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

