<x-admin-layout>
    @section('title', 'Admin Dashboard - Timplato Admin')

    @push('styles')
        <style>
            html,
            body {
                margin: 0;
                padding-top: 18px;
                font-family: 'Inter', sans-serif;
                background-color: #f8f8f8;
                height: auto;
                overflow-y: auto;
            }

            .dashboard-content {
                padding: 80px 40px 40px 40px;
                display: flex;
                flex-direction: column;
                gap: 30px;
            }

            h2 {
                margin-bottom: 4px;
            }

            p {
                margin-top: 0;
                color: #555;
            }

            /* Top KPI cards */
            .kpi-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            }

            .kpi-card {
                background-color: #ffffff;
                border-radius: 12px;
                padding: 20px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            }

            .kpi-card .title {
                font-size: 0.9rem;
                font-weight: 500;
                margin-bottom: 6px;
            }

            .kpi-card .value {
                font-size: 1.6rem;
                font-weight: 600;
            }

            .kpi-card .trend {
                font-size: 0.85rem;
                color: #22c55e;
            }

            /* Second row - charts (keep 50/50) */
            .charts-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .chart-card {
                background-color: #ffffff;
                border-radius: 12px;
                padding: 20px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-direction: column;
            }

            .chart-card canvas {
                width: 100% !important;
                height: 250px;
            }

            /* Third row: quick stats 60%, pie chart 40% */
            .third-row {
                display: flex;
                gap: 20px;
            }

            .quick-stats {
                flex: 1.5;
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
                background-color: #ffffff;
                border-radius: 12px;
                padding: 20px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                align-content: stretch;
            }

            .chart-card.pie {
                flex: 1;
                background-color: #ffffff;
                border-radius: 12px;
                padding: 20px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 250px;
            }

            .chart-card.pie canvas {
                width: 100% !important;
                height: 100% !important;
            }

            .stat-card {
                flex: 1 1 calc(50% - 10px);
                background-color: #f3f5f4;
                border-radius: 12px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
                transition: transform 0.2s;
            }

            .stat-card:hover {
                transform: translateY(-3px);
            }

            .stat-card .number {
                font-size: 1.6rem;
                font-weight: 700;
                margin-bottom: 6px;
            }

            .stat-card .desc {
                font-size: 0.9rem;
                color: #555;
                line-height: 1.2;
            }

            a {
                cursor: pointer;
                text-decoration: none;
                /* remove underline */
                color: inherit;
                /* keep text color */
            }

            /* Make all cards clickable visually appealing */
            .kpi-card,
            .stat-card,
            .chart-card {
                transition: transform 0.2s, box-shadow 0.2s, background-color 0.2s;
            }

            /* Hover effect */
            .kpi-card:hover,
            .stat-card:hover,
            .chart-card:hover {
                transform: translateY(-5px);
                /* slightly lift */
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
                /* deeper shadow */
                background-color: #f0f4ff;
                /* subtle color change */
            }

            /* Optional: change title color on hover */
            .kpi-card:hover .title,
            .stat-card:hover .desc,
            .chart-card:hover h3 {
                color: #304c89;
                /* highlight color */
            }

            /* Keep cursor pointer for all links */
            a {
                cursor: pointer;
                text-decoration: none;
                color: inherit;
            }
        </style>
    @endpush

    <div class="dashboard-content">
        <div>
            <h2>Dashboard</h2>
            <p>Here's what's happening with Timplato as of today.</p>
        </div>

        <!-- Top KPI cards -->
        <div class="kpi-cards">
            <a href="{{ route('admin.sales-analytics') }}" class="kpi-card">
                <div class="title">Total Revenue</div>
                <div class="value">₱{{ number_format($totalRevenue, 2) }}</div>
                <div class="trend">▲ {{ $revenueTrend ?? '0%' }} from last month</div>
            </a>

            <a href="{{ route('admin.order-management') }}" class="kpi-card">
                <div class="title">Total Complete Orders</div>
                <div class="value">{{ $totalOrders }}</div>
                <div class="trend">▲ {{ $ordersTrend ?? '0%' }} from last month</div>
            </a>

            <a href="{{ route('admin.user-management') }}" class="kpi-card">
                <div class="title">Total Customers</div>
                <div class="value">{{ $totalCustomers }}</div>
                <div class="trend">▲ {{ $customersTrend ?? '0%' }} from last month</div>
            </a>

            <a href="{{ route('admin.sales-analytics') }}" class="kpi-card">
                <div class="title">Conversion Rate</div>
                <div class="value">{{ $conversionRate }}%</div>
                <div class="trend">▲ {{ $conversionTrend ?? '0%' }} from last month</div>
            </a>
        </div>

        <!-- Charts row -->
        <div class="charts-row">
            <div class="chart-card">
                <h3>Sales Overview</h3>
                <canvas id="salesOverviewChart"></canvas>
            </div>
            <div class="chart-card">
                <h3>Complete Orders by Month</h3>
                <canvas id="ordersByMonthChart"></canvas>
            </div>
        </div>

        <!-- Third row -->
        <div class="third-row">
            <div class="quick-stats">
                <a href="{{ route('admin.product-management') }}" class="stat-card">
                    <div class="number">{{ $totalProducts }}</div>
                    <div class="desc">Products<br>{{ $productsAddedThisMonth ?? 0 }} added this month</div>
                </a>

                <a href="{{ route('admin.inventory-management') }}" class="stat-card">
                    <div class="number">{{ $lowStock }}</div>
                    <div class="desc">Low Stock Items<br>Needs attention</div>
                </a>

                <a href="{{ route('admin.order-management') }}" class="stat-card">
                    <div class="number">{{ $pendingOrders }}</div>
                    <div class="desc">Pending Orders<br>To be processed</div>
                </a>

                <a href="{{ route('admin.user-management') }}" class="stat-card">
                    <div class="number">{{ $newCustomersThisMonth }}</div>
                    <div class="desc">New Customers<br>This month</div>
                </a>
            </div>

            <a href="{{ route('admin.sales-analytics') }}" class="chart-card pie">
                <h3>Sales by Category</h3>
                <canvas id="salesByCategoryChart"></canvas>
            </a>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const salesCtx = document.getElementById("salesOverviewChart").getContext("2d");
                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                            "Dec"
                        ],
                        datasets: [{
                            label: "Revenue (₱)",
                            data: @json($salesChart),
                            borderColor: "#304C89",
                            backgroundColor: "rgba(48, 76, 137, 0.2)",
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true
                    }
                });

                const ordersCtx = document.getElementById("ordersByMonthChart").getContext("2d");
                new Chart(ordersCtx, {
                    type: 'bar',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                            "Dec"
                        ],
                        datasets: [{
                            label: "Orders",
                            data: @json($ordersChart),
                            backgroundColor: "#648DE5"
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true
                    }
                });

                const categoryCtx = document.getElementById("salesByCategoryChart").getContext("2d");
                new Chart(categoryCtx, {
                    type: 'pie',
                    data: {
                        labels: @json(array_keys($salesByCategoryChart)),
                        datasets: [{
                            data: @json(array_values($salesByCategoryChart)),
                            backgroundColor: ["#304C89", "#648DE5", "#9EB7E5", "#F4AE71", "#FFBE86"]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
