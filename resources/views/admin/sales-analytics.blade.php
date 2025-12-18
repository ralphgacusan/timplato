<x-admin-layout>
    @section('title', 'Sales & Analytics - Timplato Admin')

    @push('styles')
        <style>
            .sales-analytics-content {
                padding: 130px 80px;
            }

            .analytics-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-top: 32px;
            }

            .analytics-card {
                background-color: #f8f8f8;
                color: #000;
                border-radius: 12px;
                padding: 24px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                transition: transform 0.2s ease-in-out;
            }

            .analytics-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .analytics-card .title {
                font-size: 0.9rem;
                font-weight: 500;
                margin-bottom: 8px;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .analytics-card .value {
                font-size: 1.6rem;
                font-weight: 600;
            }

            .analytics-card .subtext {
                font-size: 0.8rem;
                color: #555;
            }

            .trend-up {
                color: #22c55e;
            }

            .trend-down {
                color: #ef4444;
            }

            .filters {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
                margin-top: 20px;
            }

            .filter-left,
            .filter-right {
                display: flex;
                gap: 10px;
            }

            .filters input,
            .filters button {
                padding: 6px 12px;
                border-radius: 6px;
                border: 1px solid #ccc;
            }

            .filters button {
                background-color: #304C89;
                color: #fff;
                border: none;
                cursor: pointer;
            }

            .filters button:hover {
                background-color: #1E2A47;
            }

            .chart-section {
                background-color: #f8f8f8;
                border-radius: 12px;
                padding: 24px;
                margin-top: 40px;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="sales-analytics-content">
        <h2>Sales & Analytics Reports</h2>
        <p>Access to sales data, revenue, product performance reports, and customer insights.</p>

        <div class="filters">
            <form method="GET" action="{{ route('admin.sales-analytics') }}" class="filter-form"
                style="width: 100%; display: flex; justify-content: space-between;">
                <div class="filter-left" style="display: flex; gap: 10px; align-items: center;">
                    <label>
                        From:
                        <input type="date" name="from_date" id="from_date"
                            value="{{ request('from_date', now()->subDays(30)->format('Y-m-d')) }}">
                    </label>
                    <label>
                        To:
                        <input type="date" name="to_date" id="to_date"
                            value="{{ request('to_date', now()->format('Y-m-d')) }}">
                    </label>

                    <button type="submit">Apply Filter</button>

                    <!-- Quick Filters -->
                    <button type="button" class="quick-filter" data-range="today">Today</button>
                    <button type="button" class="quick-filter" data-range="last7">Last 7 Days</button>
                    <button type="button" class="quick-filter" data-range="month">This Month</button>

                </div>

                <div class="filter-right" style="display: flex; gap: 10px;">
                    <button type="button" onclick="window.print()">Print Report</button>
                    <button type="submit" name="export" value="excel">Export as Excel</button>
                </div>
            </form>
        </div>



        <div class="analytics-cards">
            <div class="analytics-card">
                <div class="title">Total Revenue</div>
                <div class="value">₱{{ number_format($data['totalRevenue'], 2) }}</div>
                <div class="subtext trend-up">▲ 5% vs previous period</div>
            </div>

            <div class="analytics-card">
                <div class="title">Total Orders</div>
                <div class="value">{{ $data['totalOrders'] }}</div>
                <div class="subtext trend-up">▲ 3% vs previous period</div>
            </div>

            <div class="analytics-card">
                <div class="title">Average Order Value</div>
                <div class="value">₱{{ number_format($data['averageOrderValue'], 2) }}</div>
                <div class="subtext">Per transaction</div>
            </div>

            <div class="analytics-card">
                <div class="title">Conversion Rate</div>
                <div class="value">{{ $data['conversionRate'] }}%</div>
                <div class="subtext">Completed orders</div>
            </div>

            <div class="analytics-card">
                <div class="title">Total Customers</div>
                <div class="value">{{ $data['totalCustomers'] }}</div>
                <div class="subtext trend-up">+{{ $data['newCustomers'] }} new</div>
            </div>

            {{-- <div class="analytics-card">
                <div class="title">Avg Lifetime Value</div>
                <div class="value">₱{{ number_format($data['avgLifetimeValue'], 2) }}</div>
                <div class="subtext">Per customer</div>
            </div> --}}
        </div>

        <div class="chart-section" style="margin-top: 40px;">
            <h3 id="chart-title">Sales Overview</h3>
            <canvas id="analyticsChart" height="100"></canvas>
        </div>

        <div class="chart-section" style="margin-top: 40px;">
            <h3>Product Performance Reports</h3>
            {{-- Product Search and Category Filter --}}
            <div class="filters" style="margin-top: 20px;">
                <div class="filter-left" style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" id="productSearch" placeholder="Search product name..."
                        style="padding: 6px 12px; border-radius: 6px; border: 1px solid #ccc;">
                    <select id="productCategory"
                        style="padding: 6px 12px; border-radius: 6px; border: 1px solid #ccc; min-width: 200px;">
                        <option value="">All Categories</option>
                        @foreach (\App\Models\Category::whereNull('parent_id')->orderBy('name')->get() as $mainCategory)
                            <option value="{{ $mainCategory->category_id }}">
                                {{ $mainCategory->name }}
                            </option>
                            @foreach ($mainCategory->children()->orderBy('name')->get() as $subCategory)
                                <option value="{{ $subCategory->category_id }}">
                                    └ {{ $subCategory->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>

                </div>
            </div>

            {{-- Scrollable Product List --}}
            <div id="productList" class="product-list-container"
                style="max-height: 250px; overflow-y: auto; margin-top: 16px; border: 1px solid #ccc; border-radius: 8px; padding: 10px;">
                @foreach ($products as $product)
                    <div class="product-item" data-product-id="{{ $product->product_id }}"
                        data-category-id="{{ $product->category_id }}"
                        style="padding: 10px; cursor: pointer; border-bottom: 1px solid #eee;">
                        <strong>{{ $product->name }}</strong><br>
                        <small>₱{{ number_format($product->price, 2) }} | Sold: {{ $product->sold }}</small>
                    </div>
                @endforeach
            </div>

            <div id="productMetrics" class="analytics-cards" style="margin-top: 30px; display:none;">
                <div class="analytics-card product-metric-card" data-metric="totalRevenue">
                    <div class="title">Total Revenue</div>
                    <div class="value" id="prod-total-revenue">₱0.00</div>
                    <div class="subtext">Sales amount</div>
                </div>

                <div class="analytics-card product-metric-card" data-metric="totalOrders">
                    <div class="title">Total Orders</div>
                    <div class="value" id="prod-total-orders">0</div>
                    <div class="subtext">Orders containing this product</div>
                </div>

                <div class="analytics-card product-metric-card" data-metric="unitsSold">
                    <div class="title">Units Sold</div>
                    <div class="value" id="prod-total-sold">0</div>
                    <div class="subtext">Total quantity sold</div>
                </div>

                <div class="analytics-card product-metric-card" data-metric="avgOrderValue">
                    <div class="title">Avg Order Value</div>
                    <div class="value" id="prod-avg-order-value">₱0.00</div>
                    <div class="subtext">For this product</div>
                </div>

            </div>

            {{-- Product Performance Chart --}}
            <div style="margin-top: 30px;">
                <h4 id="product-chart-title">Select a product to view performance</h4>
                <canvas id="productPerformanceChart" height="100"></canvas>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const searchInput = document.getElementById("productSearch");
                const categorySelect = document.getElementById("productCategory");
                const productList = document.getElementById("productList");

                // Helper function to update product list
                const updateProductList = (products) => {
                    productList.innerHTML = "";
                    if (products.length === 0) {
                        productList.innerHTML = "<div style='padding: 10px;'>No products found.</div>";
                        return;
                    }

                    products.forEach(product => {
                        const div = document.createElement("div");
                        div.classList.add("product-item");
                        div.dataset.productId = product.product_id;
                        div.dataset.categoryId = product.category_id;
                        div.style.cssText =
                            "padding: 10px; cursor: pointer; border-bottom: 1px solid #eee;";
                        div.innerHTML = `
                <strong>${product.name}</strong><br>
                <small>₱${parseFloat(product.price).toLocaleString(undefined, { minimumFractionDigits: 2 })} | Sold: ${product.sold}</small>
            `;
                        productList.appendChild(div);
                    });

                    // Reattach click listeners to updated product list
                    attachProductClickEvents();
                };

                // Fetch products dynamically
                const fetchProducts = () => {
                    const search = searchInput.value.trim();
                    const category_id = categorySelect.value;

                    fetch(
                            `/admin/sales-analytics/products/filter?search=${encodeURIComponent(search)}&category_id=${encodeURIComponent(category_id)}`
                        )
                        .then(res => res.json())
                        .then(data => updateProductList(data))
                        .catch(err => console.error("Error fetching products:", err));
                };

                // Listen for typing (debounced)
                let typingTimer;
                searchInput.addEventListener("input", () => {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(fetchProducts, 300);
                });

                // Listen for category changes
                categorySelect.addEventListener("change", fetchProducts);

                // Reattach product click handler (existing logic)
                function attachProductClickEvents() {
                    document.querySelectorAll(".product-item").forEach(item => {
                        item.addEventListener("click", function() {
                            const productId = this.getAttribute("data-product-id");
                            const fromDate = document.getElementById("from_date").value;
                            const toDate = document.getElementById("to_date").value;

                            fetch(
                                    `/admin/sales-analytics/product/${productId}?from_date=${fromDate}&to_date=${toDate}`
                                )
                                .then(response => response.json())
                                .then(data => {
                                    document.getElementById("product-chart-title").textContent =
                                        `${data.name} - Sales Performance`;

                                    const productChart = Chart.getChart("productPerformanceChart");
                                    productChart.data.labels = data.labels;
                                    productChart.data.datasets[0].data = data.sales;
                                    productChart.update();

                                    document.getElementById("prod-total-revenue").textContent =
                                        `₱${parseFloat(data.metrics.totalRevenue).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
                                    document.getElementById("prod-total-orders").textContent = data
                                        .metrics.totalOrders;
                                    document.getElementById("prod-total-sold").textContent = data
                                        .metrics.totalUnitsSold;
                                    document.getElementById("prod-avg-order-value").textContent =
                                        `₱${parseFloat(data.metrics.averageOrderValue).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

                                    document.getElementById("productMetrics").style.display =
                                        "grid";
                                })
                                .catch(err => console.error("Error fetching product data:", err));
                        });
                    });
                }

                // Attach initial handlers
                attachProductClickEvents();
            });

            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById("analyticsChart").getContext("2d");

                // Use backend data passed from controller
                const labels = @json($data['chartLabels']);
                const revenueData = @json($data['chartRevenue']);
                const ordersData = @json($data['chartOrders']);
                const averageOrderValueData = @json($data['chartAverageOrderValue']);
                const conversionRateData = @json($data['chartConversionRate']);
                const customersData = @json($data['chartCustomers']);
                const lifetimeValueData = @json($data['chartLifetimeValue']);

                // Initialize Chart.js with revenue by default
                let analyticsChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Revenue (₱)",
                            data: revenueData,
                            borderColor: "#304C89",
                            backgroundColor: "rgba(48, 76, 137, 0.2)",
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            }
                        }
                    }
                });

                // Update chart dynamically when clicking analytics cards
                const cards = document.querySelectorAll(".analytics-card");
                cards.forEach(card => {
                    card.addEventListener("click", () => {
                        const title = card.querySelector(".title").textContent.trim();
                        document.getElementById("chart-title").textContent =
                            `${title} - Selected Range`;

                        let selectedData, label;
                        switch (title) {
                            case "Total Revenue":
                                selectedData = revenueData;
                                label = "Revenue (₱)";
                                break;
                            case "Total Orders":
                                selectedData = ordersData;
                                label = "Orders";
                                break;
                            case "Average Order Value":
                                selectedData = averageOrderValueData;
                                label = "Avg Order Value (₱)";
                                break;
                            case "Conversion Rate":
                                selectedData = conversionRateData;
                                label = "Conversion Rate (%)";
                                break;
                            case "Total Customers":
                                selectedData = customersData;
                                label = "Customers";
                                break;
                            case "Avg Lifetime Value":
                                selectedData = lifetimeValueData;
                                label = "Lifetime Value (₱)";
                                break;
                            default:
                                selectedData = revenueData;
                                label = "Revenue (₱)";
                        }

                        analyticsChart.data.datasets[0].label = label;
                        analyticsChart.data.datasets[0].data = selectedData;
                        analyticsChart.update();
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                const fromInput = document.getElementById("from_date");
                const toInput = document.getElementById("to_date");
                const quickButtons = document.querySelectorAll(".quick-filter");

                quickButtons.forEach(button => {
                    button.addEventListener("click", () => {
                        const range = button.getAttribute("data-range");
                        const today = new Date();
                        let fromDate, toDate;

                        switch (range) {
                            case "today":
                                fromDate = toDate = today;
                                break;
                            case "last7":
                                fromDate = new Date();
                                fromDate.setDate(today.getDate() - 6); // last 7 days including today
                                toDate = today;
                                break;
                            case "month":
                                fromDate = new Date(today.getFullYear(), today.getMonth(),
                                    1); // first day of month
                                toDate = new Date(today.getFullYear(), today.getMonth() + 1,
                                    0); // last day of month
                                break;
                        }

                        // Format dates to YYYY-MM-DD
                        const formatDate = d => d.toISOString().split('T')[0];
                        fromInput.value = formatDate(fromDate);
                        toInput.value = formatDate(toDate);

                        // Submit the form automatically
                        button.closest("form").submit();
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                const ctxProduct = document.getElementById("productPerformanceChart").getContext("2d");
                let productChart = new Chart(ctxProduct, {
                    type: "bar",
                    data: {
                        labels: [],
                        datasets: [{
                            label: "Units Sold",
                            data: [],
                            backgroundColor: "rgba(48, 76, 137, 0.5)",
                            borderColor: "#304C89",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            x: {
                                ticks: {
                                    autoSkip: false
                                }
                            }
                        }
                    }
                });

                let currentProductData = {}; // Store last fetched product data

                function attachProductClickEvents() {
                    document.querySelectorAll(".product-item").forEach(item => {
                        item.addEventListener("click", function() {
                            const productId = this.getAttribute("data-product-id");
                            const fromDate = document.getElementById("from_date").value;
                            const toDate = document.getElementById("to_date").value;

                            fetch(
                                    `/admin/sales-analytics/product/${productId}?from_date=${fromDate}&to_date=${toDate}`
                                    )
                                .then(response => response.json())
                                .then(data => {
                                    currentProductData = data; // save for card clicks
                                    document.getElementById("product-chart-title").textContent =
                                        `${data.name} - Sales Performance`;

                                    // Default: Units Sold
                                    productChart.data.labels = data.labels;
                                    productChart.data.datasets[0].data = data.sales;
                                    productChart.data.datasets[0].label = "Units Sold";
                                    productChart.update();

                                    // Update metrics
                                    document.getElementById("prod-total-revenue").textContent =
                                        `₱${parseFloat(data.metrics.totalRevenue).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
                                    document.getElementById("prod-total-orders").textContent = data
                                        .metrics.totalOrders;
                                    document.getElementById("prod-total-sold").textContent = data
                                        .metrics.totalUnitsSold;
                                    document.getElementById("prod-avg-order-value").textContent =
                                        `₱${parseFloat(data.metrics.averageOrderValue).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

                                    document.getElementById("productMetrics").style.display =
                                        'grid';
                                })
                                .catch(err => console.error("Error fetching product data:", err));
                        });
                    });
                }

                attachProductClickEvents();

                // Handle clicks on product metric cards
                document.querySelectorAll(".product-metric-card").forEach(card => {
                    card.addEventListener("click", function() {
                        if (!currentProductData.labels) return; // no product selected yet

                        let metric = card.dataset.metric;
                        let chartData = [];
                        let chartLabel = "";

                        switch (metric) {
                            case "totalRevenue":
                                chartData = currentProductData.metricsByDate
                                    .revenue; // backend must return per day revenue
                                chartLabel = "Revenue (₱)";
                                break;
                            case "totalOrders":
                                chartData = currentProductData.metricsByDate.orders;
                                chartLabel = "Orders";
                                break;
                            case "unitsSold":
                                chartData = currentProductData.metricsByDate.unitsSold;
                                chartLabel = "Units Sold";
                                break;
                            case "avgOrderValue":
                                chartData = currentProductData.metricsByDate.avgOrderValue;
                                chartLabel = "Avg Order Value (₱)";
                                break;
                        }

                        productChart.data.datasets[0].label = chartLabel;
                        productChart.data.datasets[0].data = chartData;
                        productChart.update();
                    });
                });
            });
            document.addEventListener("DOMContentLoaded", function() {
                const fromInput = document.getElementById("product_from_date");
                const toInput = document.getElementById("product_to_date");
                const quickButtons = document.querySelectorAll(".product-quick-filter");

                quickButtons.forEach(button => {
                    button.addEventListener("click", () => {
                        const range = button.getAttribute("data-range");
                        const today = new Date();
                        let fromDate, toDate;

                        switch (range) {
                            case "today":
                                fromDate = toDate = today;
                                break;
                            case "last7":
                                fromDate = new Date();
                                fromDate.setDate(today.getDate() - 6);
                                toDate = today;
                                break;
                            case "month":
                                fromDate = new Date(today.getFullYear(), today.getMonth(), 1);
                                toDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                                break;
                        }

                        const formatDate = d => d.toISOString().split('T')[0];
                        fromInput.value = formatDate(fromDate);
                        toInput.value = formatDate(toDate);

                        button.closest("form").submit();
                    });
                });
            });
        </script>
    @endpush


    </div>
</x-admin-layout>
