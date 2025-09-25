<x-customer-layout>

    @section('title', 'Payment - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/checkout.css') }}">
    @endpush

    <div class="checkout-main-container container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="checkout-section p-4 rounded shadow-sm">
                    <h3 class="fw-bold mb-3 text-center">Complete Your Payment</h3>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Order Total:</span>
                        <span class="fw-semibold">₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>

                    <div class="d-grid mb-3">
                        <button id="payBtn" class="btn btn-warning btn-lg fw-semibold">
                            Pay Now
                        </button>
                    </div>

                    <p class="text-muted text-center" style="font-size:0.9rem;">
                        You will be redirected to a secure payment page powered by PayMongo.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.paymongo.com/pay.js"></script>
    <script>
        const payBtn = document.getElementById('payBtn');

        payBtn.addEventListener('click', async () => {
            const clientKey = "{!! $order->client_secret !!}";

            // Debug: check the client key
            console.log('Client Key:', clientKey);

            if (!clientKey) {
                console.error('Client Key is null or empty!');
                alert('Payment cannot proceed: client key missing.');
                return;
            }

            try {
                console.log('Opening PayMongo payment modal...');
                const payment = Paymongo.pay(clientKey, {
                    return_url: "{{ route('customer.home') }}"
                });

                payment.open();
                console.log('PayMongo modal should be open now.');
            } catch (error) {
                console.error('Error opening PayMongo modal:', error);
                alert('Something went wrong while opening payment. Check console.');
            }
        });
    </script>

</x-customer-layout>
