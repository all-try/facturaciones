<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $venta->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 20px;
            margin-top: 15px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details, .client-details {
            width: 48%;
        }
        .invoice-details h3, .client-details h3 {
            color: #007bff;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .products-table th, .products-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .products-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .products-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .total-final {
            font-weight: bold;
            font-size: 18px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            margin-top: 10px;
        }
        .footer {
            clear: both;
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Repuestos Serviluz</div>
        <div>Dirección: </div>
        <div>Teléfono: </div>
        <div class="invoice-title">FACTURA #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>

    <div class="invoice-info">
        <div class="invoice-details">
            <h3>Detalles de la Factura</h3>
            <p><strong>Número:</strong> {{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Fecha:</strong> {{ $venta->fecha->format('d/m/Y') }}</p>
            <p><strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="client-details">
            <h3>Datos del Cliente</h3>
            <p><strong>Nombre:</strong> {{ $venta->cliente_nombre }}</p>
            <p><strong>Teléfono:</strong> {{ $venta->cliente_telefono }}</p>
        </div>
    </div>

    <table class="products-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td class="text-right">{{ $producto->pivot->cantidad }}</td>
                <td class="text-right">${{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($producto->pivot->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>${{ number_format($venta->total, 2) }}</span>
        </div>
        <div class="total-final">
            <div style="display: flex; justify-content: space-between;">
                <span>TOTAL:</span>
                <span>${{ number_format($venta->total, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Gracias por su compra</p>
        <p>Esta factura fue generada automáticamente el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
