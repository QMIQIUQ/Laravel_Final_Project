<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
    <style>
        /* Add any custom styling for your receipt here */
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .order-details {
            font-size: 16px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">Order Receipt</div>
    <div class="order-details">
        <p>Order #{{ $order->id }}</p>
        <p>Done By: {{ $order->user->name }}</p>
        <p>Date: {{ $order->created_at->format('M d, Y H:i A') }}</p>
    </div>

    <div>
        <h4>Order Items</h4>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->unit_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total-price">
        <p>Total Price: ${{ $order->total_price }}</p>
    </div>
</body>
</html>
