@extends('admin.layouts.app')

<x-assets.datatables />  

@push('page-css')
	
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Category</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">category</li>
	</ul>
</div>
<div class="col-sm-5 col">
    <a href="{{ route('admin.category.create') }}" class="btn btn-success float-right mt-2">+ Add category</a>
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
                                <th>#</th>
                                <th>Nom</th>
                                <th>Image</th>
								<th class="text-center action-btn">Actions</th>
							</tr>
						</thead>
						<tbody>
                            @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="Image" width="80">
                                    @else
                                        <span class="text-muted">Aucune</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- Bouton Modifier avec icône -->
                                    <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Formulaire de suppression -->
                                    <form action="{{ route('admin.category.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                            @empty
                                <tr><td colspan="4">Aucune catégorie.</td></tr>
                            @endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
