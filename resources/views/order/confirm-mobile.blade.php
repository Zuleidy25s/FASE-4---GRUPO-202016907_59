<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido realizado</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center py-12">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg text-center">

        <h1 class="text-2xl font-bold mb-3">Pedido realizado </h1>
        <p class="text-gray-600 mb-4">Gracias por tu orden</p>

        <h2 class="text-xl font-semibold">Ticket No.</h2>

        <!-- NUMERO DE ORDEN -->
        <p class="text-3xl font-bold text-gray-800 mb-6">
            <?= $order->order_number ?>
        </p>

        <!-- QR -->
        <div class="flex justify-center mb-6">
            <?= QrCode::size(300)->generate($order->order_number) ?>
        </div>

        <h3 class="text-lg font-semibold text-left">Resumen</h3>

        <!-- LISTA DE ITEMS -->
        <div class="mt-3 text-left">
            <?php foreach ($order->items as $item): ?>
                <div class="flex justify-between py-2 border-b">
                    <span><?= $item->product->name ?> x<?= $item->quantity ?></span>
                    <span>$<?= number_format($item->subtotal, 0, ',', '.') ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- TOTAL -->
        <div class="flex justify-between text-xl font-bold mt-5">
            <span>Total:</span>
            <span>
                $<?= number_format($order->items->sum('subtotal'), 0, ',', '.') ?>
            </span>
        </div>

        <!-- BOTÓN -->
        <a href="<?= route('home') ?>"
            class="mt-8 inline-block bg-black text-white py-3 px-6 rounded-xl hover:bg-gray-800 transition-all">
            Volver a realizar pedido
        </a>

    </div>

</div>

</body>
</html>
