@extends('admin.index')
{{-- Cabecera web --}}
@include('layout.nav.head')
{{-- Navbar --}}
@include('layout.nav.nav')
{{-- sidebar --}}
@include('admin.layout.sidebar')

<main id="main" class="main">
    <div class="container">
		{{-- messages error --}}
		@if(Session::has('message'))
			<div class="alert alert-{{ Session::get('typealert') }}">
				{{ Session::get('message') }}
			</div>
		@endif
		<!--Page Title -->
        <div class="pagetitle">
            <h1>Editar Categoría: {{ $cat->name }}</h1>
            <nav>
                <ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="{{ url('/admin') }}">Dashboard</a>
					</li>
					<li class="breadcrumb-item">
						<a href="{{ url('/admin/categories/0') }}">Categorías</a>
					</li>
					<li class="breadcrumb-item active">Editar categoría {{ $cat->name }}</li>
                </ol>
            </nav>
        </div>

		<div class="container ">
			<div class="row">
				<div class="col-md-4">
					<div class="container">
						<div class="">
		
							<div class="inside">
								<form action="{{ url('/admin/category/'.$cat->id.'/edit') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<label for="name">Nombre categoria:</label>
									<div class="input-group">
										<input type="text" name="name" class="form-control" value="{{ $cat->name }}">
									</div>
		
									<button type="submit" class="btn btn-outline-success mt-3">Editar</button>
								</form>
							</div>
						</div>
					</div>
				</div>
		
				{{-- @if(!is_null($cat->icono))
				<div class="col-md-3">
					<div class="container-fluid">
						<div class="panel shadow">
							<div class="header">
								<h2 class="title"><i class="fas fa-edit"></i> Icono</h2>
							</div>
		
							<div class="inside">
								<img src="{{ url('/upload/'.$cat->file_path.'/'.$cat->icono) }}" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
				@endif --}}
		
			</div>
		</div>
		
		
    </div>
</main>