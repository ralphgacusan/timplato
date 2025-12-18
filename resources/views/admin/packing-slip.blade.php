<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Packing Slip #{{ $order->order_id }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            width: 100%;
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            vertical-align: top;
            padding: 3px 0;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
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

        .totals {
            width: 100%;
            margin-top: 10px;
        }

        .totals table {
            width: 50%;
            float: right;
            border-collapse: collapse;
        }

        .totals td {
            padding: 4px 8px;
        }

        .totals tr td:last-child {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Packing Slip</h2>

        <div class="info">
            <table>
                <tr>
                    <td>
                        <strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}<br>
                        <strong>Ship To:</strong><br>
                        {{ $order->user->getFullName() ?? 'N/A' }}<br>
                        {{ $order->user->getFullAddress() ?? 'N/A' }}<br>

                        <strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}
                    </td>
                    <td>
                        <strong>Tracking:</strong> {{ $order->order_id ?? 'N/A' }}<br>
                        <strong>Order:</strong> #{{ $order->order_id }}<br>
                        <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>SKU</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Ext. Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->product->product_id ?? 'N/A' }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>&#8369;{{ number_format($item->price, 2) }}</td>
                            <td>&#8369;{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            @php
                // Check if stored values are missing or zero
                $use_calculated =
                    (is_null($order->subtotal) || $order->subtotal == 0) &&
                    (is_null($order->total_amount) || $order->total_amount == 0);

                if ($use_calculated) {
                    // Fallback: compute manually
                    $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
                    $shipping = $order->shipping_cost ?? 0;
                    $discount = $order->discount_amount ?? 0;
                    $total = $subtotal + $shipping - $discount;
                } else {
                    // Use stored values
                    $subtotal = $order->subtotal;
                    $shipping = $order->shipping_cost ?? 0;
                    $discount = $order->discount_amount ?? 0;
                    $total = $order->total_amount;
                }
            @endphp

            <table>
                <tr>
                    <td>Sub Total</td>
                    <td>&#8369;{{ number_format($subtotal, 2) }}</td>
                </tr>

                <tr>
                    <td>Shipping Cost</td>
                    <td>
                        @if ($shipping > 0)
                            &#8369;{{ number_format($shipping, 2) }}
                        @else
                            Free Shipping
                        @endif
                    </td>
                </tr>

                @if ($discount > 0)
                    <tr>
                        <td>Discount</td>
                        <td>- &#8369;{{ number_format($discount, 2) }}</td>
                    </tr>
                @endif

                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>&#8369;{{ number_format($total, 2) }}</strong></td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
