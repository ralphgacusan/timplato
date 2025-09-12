<x-customer-layout>

    @section('title', 'Customer Support - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/customer-support.css') }}">
    @endpush


    <div class="customer-suport-main">
        <div class="help-center-flex-row">
            <div class="help-center-container">
                <h1 class="help-center-title">HELP CENTER</h1>
                <div class="help-center-categories">
                    <div class="help-center-category-row">
                        <button class="help-category-btn" data-category="shop">
                            <span class="help-category-icon shop"></span> Shop with Timplato
                        </button>
                        <button class="help-category-btn" data-category="general">
                            <span class="help-category-icon general"></span> General
                        </button>
                        <button class="help-category-btn" data-category="payment">
                            <span class="help-category-icon payment"></span> Payment
                        </button>
                    </div>
                    <div class="help-center-category-row">
                        <button class="help-category-btn" data-category="shipping">
                            <span class="help-category-icon shipping"></span> Orders & Shipping
                        </button>
                        <button class="help-category-btn" data-category="coupons">
                            <span class="help-category-icon coupons"></span> Coupons/Vouchers
                        </button>
                        <button class="help-category-btn" data-category="policies" disabled>
                            <span class="help-category-icon policies"></span> Policies
                        </button>
                    </div>
                </div>

                <div class="help-center-content">
                    <div id="helpContent"></div>
                </div>
            </div>

            @auth
                <div class="concern-container">
                    <h2 class="concern-title">Concerns</h2>
                    <form class="concern-form" action="{{ route('customer.customer-support.store') }}" method="POST">
                        @csrf
                        <input type="text" name="subject" class="concern-input" placeholder="Subject" required>
                        <textarea name="message" class="concern-textarea" placeholder="Message" required></textarea>
                        <button type="submit" class="concern-submit-btn">Submit</button>
                    </form>

                    {{-- @if (session('success'))
                    <div class="success-message" style="margin-top:10px; color:green;">
                        {{ session('success') }}
                    </div>
                @endif --}}
                </div>
            @endauth




        </div>
    </div>

    <script>
        // Help Center Content Data
        const helpData = {
            shop: {
                category: 'Shop with Timplato',
                items: [{
                        title: 'New to Timplato',
                        content: 'Timplato was founded in 2025 to address a common challenge faced by many Filipino households: finding affordable yet reliable kitchenware in one convenient place. Local shops often lack variety, while imported products can be too expensive or difficult to access. To bridge this gap, Timplato was created as an e-commerce platform dedicated to providing quality, affordable, and practical kitchen tools. The name “Timplato” comes from two Filipino words, “timpla” (to mix or season) and “plato” (plate), symbolizing the company’s goal of helping people prepare and enjoy meals with the right tools.'
                    },
                    {
                        title: 'Products on Timplato',
                        content: 'Timplato focuses exclusively on kitchenware, offering cookware, utensils, food preparation tools, and tableware. What sets it apart is its commitment to promoting Filipino-made products, combining convenience, culture, and quality in one trusted online marketplace.'
                    },
                    {
                        title: 'Checkout',
                        content: '<b>1st Step:</b> You can order your preferred product if you go to the “Product Page”<br><b>2nd Step:</b> If you like any items you can add those in the “Cart” or “Wishlist”<br><b>3rd Step:</b> If you wish to buy the item, you can go to the cart, edit the number of product you want to buy, insert any coupon/voucher and checkout your preferred product.<br><b>4th Step:</b> If you wish to check out your preferred product, choose a payment method and delivery method that fits your preference.<br><b>5th Step:</b> You can now click the checkout button and wait for your order to arrive!<br><b>6th Step (Optional):</b> If you checked out the wrong item or forgot to check out an item, you can cancel your order to check out the right item again.'
                    }
                ]
            },
            general: {
                category: 'General',
                items: [{
                        title: 'How do I remove a kitchenware item from my cart?',
                        content: 'Open your cart, find the item you want to remove, and tap Remove. The item will be deleted immediately.'
                    },
                    {
                        title: 'Why can’t I complete my order during checkout?',
                        content: 'This could be due to incomplete details, unavailable items, or payment issues. Double-check your shipping address, kitchenware availability, and payment method.'
                    }
                ]
            },
            payment: {
                category: 'Payment',
                items: [{
                    title: 'How do I choose the payment method for my order?',
                    content: 'At checkout, under Payment Method, you can choose between Cash on Delivery (COD), Payment Center / E-wallet GCash, and Credit / Debit Card.'
                }]
            },
            shipping: {
                category: 'Orders & Shipping',
                items: [{
                    title: 'How do I choose a delivery </br> method for my kitchenware?',
                    content: 'At checkout, choose your delivery method under the Payment Details, and choose between Standard Delivery, Named Day Delivery, and Premium Delivery.'
                }]
            },
            coupons: {
                category: 'Coupons/Vouchers',
                items: [{
                        title: 'Using Coupons',
                        content: 'How are voucher discounts applied during checkout? Voucher discounts are applied automatically once you select and confirm a valid voucher that matches the item or order.'
                    },
                    {
                        title: 'How do I apply a coupon/voucher at checkout?',
                        content: 'At checkout, tap the Coupon/Voucher textfield, type the promo code that you want to use, and the discount will appear in your order summary.'
                    }
                ]
            },
            policies: {
                category: 'Policies',
                items: [{
                    title: 'Policies',
                    content: 'Read about our policies regarding returns, privacy, and more.'
                }]
            }
        };

        // Render Help Content
        function renderHelpContent(categoryKey, itemIndex = 0) {
            const data = helpData[categoryKey];
            if (!data) return;
            const items = data.items;
            const selectedItem = items[itemIndex];
            let sidebarLinks = '';
            items.forEach((item, idx) => {
                sidebarLinks +=
                    `<div class="help-sidebar-link${idx === itemIndex ? ' active' : ''}" onclick="renderHelpContent('${categoryKey}', ${idx})">${item.title}</div>`;
            });
            // Always render sidebar and main content in a flex row, even for single-item categories
            document.getElementById('helpContent').innerHTML = `
            <div class="help-content-box">
                <div class="help-sidebar">
                    <div class="help-sidebar-header"><span class="help-category-icon ${categoryKey}"></span> ${data.category} <span class="help-sidebar-arrow">&#9660;</span></div>
                    ${sidebarLinks}
                </div>
                <div class="help-main-content">
                    <div class="help-main-title">${selectedItem.title}</div>
                    <div class="help-main-desc">${selectedItem.content.replace(/\n/g, '<br>')}</div>
                </div>
            </div>
        `;
        }

        // Category Button Clicks
        document.querySelectorAll('.help-category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.help-category-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                renderHelpContent(this.getAttribute('data-category'), 0);
            });
        });

        // Initial Render
        renderHelpContent('shop', 0);
        document.querySelector('.help-category-btn[data-category="shop"]').classList.add('active');
    </script>


</x-customer-layout>
