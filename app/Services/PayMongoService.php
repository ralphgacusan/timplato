<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayMongoService
{

    protected $baseURL = 'https://api.paymongo.com/v1';
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = env('PAYMONGO_SECRET_KEY');
    }

    public function createCheckoutSession($amount, $orderId, $paymentMethod)
    {
        $payload = [
            'data' => [
                'attributes' => [
                    'line_items' => [[
                        'currency' => 'PHP',
                        'amount' => $amount,
                        'name' => "Timplato Order #$orderId",
                        'quantity' => 1
                    ]],
                    'payment_method_types' => [$paymentMethod], // e.g., 'gcash', 'card'
                    'success_url' => route('paymongo.callback', ['order' => $orderId]),
                    'cancel_url' => route('customer.orderDetails', $orderId),
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->secretKey . ':'),
            'Content-Type' => 'application/json',
        ])->post("{$this->baseURL}/checkout_sessions", $payload);

        return $response->json();
    }

}
