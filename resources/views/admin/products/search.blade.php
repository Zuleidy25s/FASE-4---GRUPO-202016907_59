@extends('admin.index')
{{-- Cabecera web --}}
@include('layout.nav.head')
{{-- Navbar --}}
@include('layout.nav.nav')
{{-- sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main">
    <div class="container">
		<!--Page Title -->
        <div class="">
            <h1>Productos</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Productos</li>
                </ol>
            </nav>
        </div>

<div class="container-fluid">
	<div class="">
		<div class="header">
			<div class="" style="list-style: none;">
				@if(kvfj(Auth::user()->permissions, 'product_add'))

					<a href="{{ url('/admin/product/add') }}" class="btn btn-outline-dark my-4">
						Agregar producto
					</a>
			
				@endif
					<div class="dropdown float-right">
						<button class="btn btn-outline-dark dropdown-toggle" type="button" id="btn_filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Filtrar <i class="fas fa-chevron-down"></i>
						</button>
						<ul class="dropdown-menu" aria-labelledby="btn_filter">
							<li><a class="dropdown-item" href="{{url('/admin/products/1')}}">Públicos</a></li>
							<li><a class="dropdown-item" href="{{url('/admin/products/0')}}">Borradores</a></li>
							<li><a class="dropdown-item" href="{{url('/admin/products/trash')}}">Papelera</a></li>
							<li><a class="dropdown-item" href="{{url('/admin/products/all')}}">Todos</a></li>
						</ul>
					</div>
				
				{{-- <li>
					<a href="#" id="btn_search">
						<i class="fas fa-search"></i> Buscar
					</a>
				</li> --}}
			</div>
		</div>

		<div class="inside">

			<div class="form_search mb-4" id="form_search">
				<form method="POST" action="{{ url('/admin/product/search') }}">
					@csrf
					<div class="row">
						<div class="col-md-4">
							<input type="text" name="search" class="form-control" placeholder="Ingrese su búsqueda" required>
						</div>
						<div class="col-md-4">
							<select name="filter" class="form-control">
								<option value="0">Nombre del producto</option>
								<option value="1">Código</option>
							</select>
						</div>
						<div class="col-md-2">
							<select name="status" class="form-control">
								<option value="0">Borrador</option>
								<option value="1">Públicos</option>
							</select>
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary">Buscar</button>
						</div>
					</div>
				</form>
				
			</div>
			
			<table class="table table-striped">
				<thead>
					<tr>
						<td>ID</td>
						<td></td>
						<td>Nombres</td>
						<td>Categoria</td>
						<td>Precio</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $p)
					<tr>
						<td width="50">{{ $p->id }}</td>
						<td width="64">
							@if($p->image)
								<a href="{{ asset('storage/img/uploads_product_image/'. $p->image) }}" data-fancybox="gallery">
									<img src="{{ asset('storage/img/uploads_product_image/'. $p->image) }}" width="64px">
								</a>
							@endif
						</td>
						<td>{{ $p->name }} @if($p->status == "0") <i class="fas fa-eraser" data-toggle="tooltip" data-placement="top" title="Estado: Borrador"></i> @endif</td>
						<td>{{ $p->cat->name }}</td>
						<td>{{ $p->price }}</td>
						<td>
							<div class="opts">
								@if(kvfj(Auth::user()->permissions, 'product_edit'))
								<a href="{{ url('/admin/product/'.$p->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
								<i class="fas fa-edit"></i>
								</a>
								@endif
								@if(kvfj(Auth::user()->permissions, 'product_delete'))
								<a href="{{ url('/admin/product/'.$p->id.'/delete') }}" data-toggle="tooltip" data-placement="top" title="Eliminar">
								<i class="fas fa-trash-alt"></i>
								</a>
								@endif
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>


</div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

