@extends('index')

@section('title', 'Editar mi perfil')

@section('content')
    <div class="row mb-5">
        {{-- Avatar, sidebar --}}
        <div class="col-md-3">
            {{-- Sidebar --}}
            <div>
                <ul class="">
                    <li class="list-group-item">
                        <a href="#" class="sidebar-link" data-section="perfil">Perfil</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="sidebar-link" data-section="pedidos">Pedidos</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="sidebar-link" data-section="tarjetas">Tarjetas de crédito</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="sidebar-link" data-section="autenticacion">Autenticación</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="sidebar-link" data-section="favoritos">Favoritos</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="sidebar-link" data-section="direcciones">Direcciones</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="sidebar-link" data-section="salir">Salir</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-8">
            {{-- Contenido dinámico --}}
            <div id="dynamic-content">
                <div class="section" id="perfil">
                    <!-- Contenido de Perfil -->
                    @include('user.sections.perfil')
                </div>
                <div class="section" id="pedidos" style="display: none;">
                    <!-- Contenido de Pedidos -->
                    <h4>Pedidos</h4>
                    <!-- Aquí va la información de pedidos -->
                </div>
                <div class="section" id="tarjetas" style="display: none;">
                    <!-- Contenido de Tarjetas de crédito -->
                    <h4>Tarjetas de crédito</h4>
                    <!-- Aquí va la información de tarjetas de crédito -->
                </div>
                <div class="section" id="autenticacion" style="display: none;">
                    <!-- Contenido de Autenticación -->
                    @include('user.sections.autentication')
                </div>
                <div class="section" id="favoritos" style="display: none;">
                    <!-- Contenido de Favoritos -->
                    <h4>Favoritos</h4>
                    <!-- Aquí va la información de favoritos -->
                </div>
                <div class="section" id="direcciones" style="display: none;">
                    <!-- Contenido de Direcciones -->
                    <h4>Direcciones</h4>
                    <!-- Aquí va la información de direcciones -->
                </div>
                <div class="section" id="salir" style="display: none;">
                    <!-- Contenido de Salir -->
                    <h4>Salir</h4>
                    <!-- Aquí va la información de salir -->
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .sidebar-link {
		color: #000000;
        font-weight: normal;
		text-decoration: none !important;
    }

    .sidebar-link.active {
        font-weight: bold;
        border-bottom: 2px solid #000000;
    }
</style>
