@extends('index')

@section('content')

    <div>
        @if (count(collect($items)) == 0)
        <div class="container">
            <div class="row">
                <p class="w-100 mx-4 d-flex text-center lead card shadow-sm p-3 mt-5 mb-2"> 
                    {{ Auth::user()->name}} ¡No hay un producto en el carrito de compras!
                </p>
                <div class="w-100 text-center my-3 mb-5">
                    <a class="btn btn-outline-light text-dark">
                        Ir a la tienda
                    </a>
                </div>
            </div>
        </div>
        @else
            <div class="container my-3">
                <div class="row">   
                    {{-- arriba va el form --}}
                    <div class="col-md-9 table-responsive">
                        <div class="d-flex text-center align-items-center">
                            <div class="btn ">
                                <i class="bi bi-bag"></i>
                            </div> 
                            <h5 class="my-2">Carrito de compras</h5>
                        </div>

                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td width="80"></td>
                                    <td><strong>Producto</strong></td>
                                    <td width="140"><strong>Cantidad</strong></td>
                                    <td><strong>Subtotal</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="align-middle justify-content-center text-center">
                                            {{-- btn delete --}}
                                            <a href="{{ url('/cart/item/'.$item->id.'/delete')  }}" class="bg-danger p-2 rounded-circle">
                                                <i class="bi bi-trash text-white"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <img src="{{ url('/storage/img/uploads_product_image/'.$item->getProduct->image) }}" 
                                                class="img-fluid w-100 rounded shadow">
                                        </td>
                                        <td class="align-middle">
                                            {{ $item->label_item }}
                                            
                                                <div>
                                                    @if($item->discount_status == "1")
                                                        <span style="color: #757474;">{{ config('cms.currency').number_format($item->price_initial, 0, '.',',') }}</span> |
                                                    @endif
                                                        <span class=" font-weight-bold">
                                                            {{ config('cms.currency').number_format($item->price_unit), 2, '.',',' }} 
                                                        </span>
                                                        @if($item->discount_status == "1")
                                                            <span class="bg-danger rounded text-white p-1" style="font-size: 0.8rem;">
                                                                <strong>
                                                                    {{ $item->discount, 2, '.',',' }}%
                                                                </strong>
                                                            </span>
                                                        @endif
                                                </div>
                                        </td>
                                        <td class="align-middle d-flex justify-content-center align-items-center text-center" >
                                            <form action="{{ url('/cart/item/'.$item->id.'/update') }}" method="POST" class="my-4">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="text-center" style="width:40px;">
                                                <button type="submit" class="btn btn-outline-light">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy text-dark" viewBox="0 0 16 16">
                                                        <path d="M11 2H9v3h2z"/>
                                                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="align-middle">
                                            {{ config('cms.currency').' '.number_format($item->total, 2, '.',',') }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="3"></td>
                                    <td>
                                        <strong>Subtotal:</strong>
                                    </td>
                                    <td>{{ config('cms.currency').' '.number_format($order->getSubtotal(), 2, '.',',') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>
                                        <strong>Iva (19%):</strong>
                                    </td>
                                    <td>{{ config('cms.currency').' '.number_format('0.00', 2, ',','.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>
                                        <strong>Precio de envío:</strong>
                                    </td>
                                    <td>{{ config('cms.currency').' '.number_format('0.00', 2, ',','.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>
                                        <strong>Total:</strong>
                                    </td>
                                    <td>{{ config('cms.currency').' '.number_format('0.00', 2, ',','.') }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            {{-- title --}}
                            <div class="d-flex text-center align-items-center">
                                <div class="btn ">
                                    <i class="bi bi-geo-alt"></i>
                                </div> 
                                <h5 class="my-2">Dirección de envío</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="address">Dirección</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Calle, número, piso, dpto" value="{{ old('address') }}">
                                    @if($errors->has('address'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('address') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="card my-4">
                            {{-- title --}}
                            <div class="d-flex text-center align-items-center">
                                <div class="btn ">
                                    <i class="bi bi-chat-left"></i>
                                </div> 
                                <h5 class="my-2">Agregar comentario</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea class="form-control" id="comment" name="order_msg" rows="3" placeholder="Escribe tu comentario...">{{ old('comment') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Confirmar compra</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Si hay mensajes en la sesión, los mostrará usando SweetAlert --}}
    @if(Session::has('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var type = "{{ Session::get('typealert') }}";
                var message = "{{ Session::get('message') }}";
        
                // Configuración de las alertas
                var alertConfig = {
                    success: {
                        icon: 'success',
                        title: '¡Éxito!',
                        color: '#28a745'  // Color verde para éxito
                    },
                    error: {
                        icon: 'error',
                        title: 'Error',
                        color: '#dc3545'  // Color rojo para error
                    },
                    warning: {
                        icon: 'warning',
                        title: 'Advertencia',
                        color: '#ffc107'  // Color amarillo para advertencia
                    },
                    info: {
                        icon: 'error',
                        title: 'Error',
                        color: '#dc3545'  // Color azul para información
                    }
                };
        
                // Obtén la configuración correspondiente al tipo de alerta
                var config = alertConfig[type] || alertConfig.info;  // Usa configuración de 'info' por defecto
        
                Swal.fire({
                    icon: config.icon,
                    title: config.title,
                    text: message,
                    showConfirmButton: true,
                    timer: 5000,
                    customClass: {
                        title: 'swal-title',
                        container: 'swal-container'
                    },
                    willOpen: () => {
                        Swal.getContainer().querySelector('.swal-title').style.color = config.color;
                    }
                });
            });
        </script>
    @endif
@endsection