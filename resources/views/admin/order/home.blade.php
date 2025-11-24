@extends('admin.index')
{{-- Cabecera web --}}
{{-- sidebar --}}
@include('admin.layout.sidebar')
<main id="main" class="main py-10 px-4">
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Gestión de Órdenes</h1>

        <table id="ordersTable" class="min-w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th>ID</th>
                    <th>Order #</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Pago</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>QR</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>

        <!-- MODAL QR -->
        <div id="modalQR" onclick="closeModal('modalQR')" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-4 rounded shadow-lg relative">
                <img id="qrImage" src="" alt="QR" class="w-64 h-64">
            </div>
        </div>

        <!-- MODAL VER PEDIDO -->
        <div id="modalView" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 overflow-auto p-4">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-3xl relative">
                <button onclick="closeModal('modalView')" class="absolute top-2 right-2 text-gray-600 font-bold text-xl">&times;</button>
                <div id="orderDetails">
                    <!-- Información del pedido inyectada desde showOrder(id) -->
                </div>
            </div>
        </div>


    </main>

</div>

<link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
    href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- Excel requiere JSZip -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- PDF requiere pdfmake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


<script>
    let table = $('#ordersTable').DataTable({
    ajax: '{{ route("admin.orders.list") }}',
    responsive: true,
    processing: true,
    serverSide: false,

    dom: 'Bfrtip',   // ⬅️ ACTIVAR BOTONES

    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Excel',
            className: 'px-4 py-1 bg-blue-600 text-white rounded'
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            className: 'px-4 py-1 bg-red-600 text-white rounded',
            orientation: 'landscape',
            pageSize: 'A4'
        },
        {
            extend: 'print',
            text: 'Imprimir',
            className: 'px-4 py-1 bg-gray-700 text-white rounded'
        },
        {
            extend: 'copy',
            text: 'Copiar',
            className: 'px-4 py-1 bg-green-700 text-white rounded'
        }
    ],

        columns: [
            { data: 'id' },
            { data: 'order_number' },
            { data: 'customer_name' },
            { data: 'type' },
            { data: 'payment_method' },
            { data: 'status' },
            { data: 'total' },
            {
                data: 'id', // usar el ID real de la orden
                render: function(id) {
                    const qrUrl = '/static/uploads_product/qrs/qr_' + id + '.svg';
                    return `<button onclick="showQR('${qrUrl}')" class="px-2 py-1 bg-green-600 text-white rounded">Ver QR</button>`;
                }
            },
            { data: 'actions' }
        ]
    });

    function showOrder(id) {
        $.get("{{ url('/admin/orders') }}/" + id, function(order) {

            let itemsHTML = order.items.map(i =>
                `<tr>
                    <td>${i.product.name}</td>
                    <td>${i.quantity}</td>
                    <td>$${i.price}</td>
                    <td>$${i.subtotal}</td>
                </tr>`
            ).join('');

            $("#orderDetails").html(`
                <p><strong>Cliente:</strong> ${order.customer_name}</p>
                <p><strong>Tipo:</strong> ${order.type}</p>
                <p><strong>Pago:</strong> ${order.payment_method}</p>
                <p><strong>Total:</strong> $${order.items.reduce((t,i)=>t+i.subtotal,0)}</p>

                <h3 class="font-bold mt-3">Productos</h3>
                <table class="w-full">
                    <thead><tr class="font-bold"><td>Producto</td><td>Cant</td><td>Precio</td><td>Subtotal</td></tr></thead>
                    <tbody>${itemsHTML}</tbody>
                </table>

                <h3 class="font-bold mt-3">Pago</h3>
                <p><strong>Método:</strong> ${order.payment?.gateway ?? 'N/A'}</p>
                <p><strong>Estado:</strong> ${order.payment?.status ?? 'N/A'}</p>
            `);

            openModal('modalView');
        });
    }

    function showQR(url) {
        $('#qrImage').attr('src', url);
        openModal('modalQR');
    }

    function deleteOrder(id) {
        if (!confirm('¿Eliminar este pedido?')) return;

        $.ajax({
            url: "{{ url('/admin/orders') }}/" + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function () {
                table.ajax.reload();
            }
        });
    }

    function openModal(id) {
        $("#" + id).removeClass('hidden');
    }

    function closeModal(id) {
        $("#" + id).addClass('hidden');
}
</script>


