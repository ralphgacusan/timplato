<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayMongoService
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = base64_encode(env('PAYMONGO_SECRET_KEY') . ':');
    }

    public function createPaymentIntent($amount, $currency = 'PHP')
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paymongo.com/v1/payment_intents', [
            'data' => [
                'attributes' => [
                    'amount' => $amount * 100, // PayMongo expects centavos
                    'payment_method_allowed' => ['card', 'gcash', 'paymaya'],
                    'currency' => $currency,
                ]
            ]
        ]);

        return $response->json();
    }

    public function attachPaymentMethod($paymentIntentId, $paymentMethodId, $returnUrl)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post("https://api.paymongo.com/v1/payment_intents/{$paymentIntentId}/attach", [
            'data' => [
                'attributes' => [
                    'payment_method' => $paymentMethodId,
                    'return_url' => $returnUrl,
                ]
            ]
        ]);

        return $response->json();
    }
}
