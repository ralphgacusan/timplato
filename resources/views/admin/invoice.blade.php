<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_id }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items th,
        .items td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        .items th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            margin-top: 15px;
        }

        .total p,
        .total h3 {
            margin: 2px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Invoice #{{ $order->order_id }}</h2>
        <p>Customer: {{ $order->user->getFullName() ?? 'N/A' }}</p>
        <p>Email: {{ $order->user->email ?? 'N/A' }}</p>
        <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
        <p>Payment Method: {{ strtoupper($order->payment_method) }}</p>
    </div>

    <div class="items">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>&#8369;{{ number_format($item->price, 2) }}</td>
                        <td>&#8369;{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        @php
            // Check if stored values are missing or zero
            $use_calculated =
                (is_null($order->subtotal) || $order->subtotal == 0) &&
                (is_null($order->total_amount) || $order->total_amount == 0);

            if ($use_calculated) {
                // Fallback: compute manually
                $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
                $discount = $order->discount_amount ?? 0;
                $shipping = $order->shipping_cost ?? 0;
                $total = $subtotal - $discount + $shipping;
            } else {
                // Use database values
                $subtotal = $order->subtotal;
                $discount = $order->discount_amount ?? 0;
                $shipping = $order->shipping_cost ?? 0;
                $total = $order->total_amount;
            }
        @endphp

        <p>Subtotal: &#8369;{{ number_format($subtotal, 2) }}</p>



        @if ($shipping > 0)
            <p>Shipping: &#8369;{{ number_format($shipping, 2) }}</p>
        @endif

        @if ($discount > 0)
            <p>Discount: &#8369;{{ number_format($discount, 2) }} ({{ $order->voucher_code ?? '' }})</p>
        @endif

        <h3>Total: &#8369;{{ number_format($total, 2) }}</h3>
        <p>Status: {{ ucfirst($order->current_status) }}</p>

        @if ($order->tracking_number)
            <p>Tracking #: {{ $order->tracking_number }}</p>
        @endif
    </div>

</body>

</html>
