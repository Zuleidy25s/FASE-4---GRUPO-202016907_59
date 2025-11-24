@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>🛒 Iniciar Nuevo Alquiler/Reserva</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('alquileres.store') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header">Fechas y Horarios</div>
            <div class="card-body row">
                <div class="col-md-4">
                    <label for="fecha_reserva" class="form-label">Fecha de Reserva:</label>
                    <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" required>
                </div>
                <div class="col-md-4">
                    <label for="hora_inicio" class="form-label">Hora de Inicio:</label>
                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                </div>
                <div class="col-md-4">
                    <label for="hora_fin" class="form-label">Hora de Fin (Opcional):</label>
                    <input type="time" class="form-control" id="hora_fin" name="hora_fin">
                </div>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">Selección de Ítems</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ítem</th>
                            <th>Costo Unitario</th>
                            <th>Cantidad Máx.</th>
                            <th>Cantidad Solicitada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->nombre_item }}</td>
                            <td>${{ number_format($item->costo_unitario, 2) }}</td>
                            <td>{{ $item->cantidad_total }}</td>
                            <td>
                                <input type="number" name="items[{{ $item->id_item }}][cantidad]" 
                                       data-item-id="{{ $item->id_item }}"
                                       min="0" max="{{ $item->cantidad_total }}" class="form-control item-cantidad">
                                <input type="hidden" name="items[{{ $item->id_item }}][id_item]" value="{{ $item->id_item }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Opciones de Entrega</div>
            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_entrega" id="retiro" value="Retiro en el lugar" checked>
                    <label class="form-check-label" for="retiro">Retiro en el lugar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_entrega" id="domicilio" value="Servicio a Domicilio">
                    <label class="form-check-label" for="domicilio">Servicio a Domicilio</label>
                </div>
                
                <div id="direccion-container" style="display:none; margin-top: 15px;">
                    <label for="direccion_entrega" class="form-label">Dirección de Entrega:</label>
                    <input type="text" class="form-control" id="direccion_entrega" name="direccion_entrega">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-lg">Proceder al Resumen y Pago</button>
    </form>
</div>

<script>
    // Pequeño script para mostrar/ocultar el campo de dirección
    document.addEventListener('DOMContentLoaded', function() {
        const domicilioRadio = document.getElementById('domicilio');
        const retiroRadio = document.getElementById('retiro');
        const direccionContainer = document.getElementById('direccion-container');

        const toggleDireccion = () => {
            direccionContainer.style.display = domicilioRadio.checked ? 'block' : 'none';
        };

        domicilioRadio.addEventListener('change', toggleDireccion);
        retiroRadio.addEventListener('change', toggleDireccion);
        toggleDireccion(); // Llamar al inicio para el estado predeterminado
    });
</script>
@endsection