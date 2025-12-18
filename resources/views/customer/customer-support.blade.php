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
                        <button class="help-category-btn" data-category="policies" disabled style="visibility: hidden;">
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
        // Convert PHP sections into JS object
        const helpData = {!! json_encode(
            $sections->mapWithKeys(function ($group, $key) {
                // Parse JSON content safely
                $content = [];
                if (isset($group[0]) && ($decoded = json_decode($group[0]->content, true))) {
                    $content = $decoded;
                }
                return [
                    $key => [
                        'category' => $group[0]->title ?? ucfirst($key),
                        'items' => $content,
                    ],
                ];
            }),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE,
        ) !!};


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
