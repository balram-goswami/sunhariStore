<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>

    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #f5f5f5;
        }
    </style>
</head>

<body>

    <h2>Invoice #{{ $order->id }}</h2>

    <p>
        <strong>Customer:</strong> {{ $order->customer->name }} <br>
        <strong>Email:</strong> {{ $order->customer->email }}
    </p>

    <h3>Products</h3>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->products as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>₹{{ number_format($item->price,2) }}</td>
                <td>₹{{ number_format($item->total,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="text-align:right; margin-top:40px;">
        Subtotal: ₹{{ number_format($order->net_sub_total,2) }} <br>
        Shipping: ₹{{ number_format($order->net_shipping_amount,2) }} <br>
        <strong>Total: ₹{{ number_format($order->net_total,2) }}</strong>
    </h3>

</body>

</html>