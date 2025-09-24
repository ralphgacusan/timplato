<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../timplatoLogo/Timplato-Blue-LOGO.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>@yield('title', 'Timplato Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/admin/admin-layout.css') }}">
    @stack('styles')
    @yield('styles') <!-- This will allow child layout to inject styles -->
    @stack('scripts') <!-- To push scripts from child views -->
    @yield('scripts') <!-- Allow child views to define scripts -->
</head>

<body>
    <div class="page-wrapper">
        <!-- Header with Navigation -->
        <div id="notification-container" style="position: fixed; top: 80px; right: 20px; z-index: 9999;">
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        showNotification(@json(session('success')), 'success');
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        showNotification(@json(session('error')), 'error');
                    });
                </script>
            @endif
        </div>
        <!-- Navbar -->
        <div class="admin_nav">
            <img src="/timplatoLogo/Timplato-White2.png" alt="Timplato Logo" class="logo">
            <div class="admin_profile">
                <img src="../Assets/cyrielPicture.png" alt="Admin Picture" class="admin_picture">
                <p class="admin_name">Cyriel Alden Obillo</p>
                <a href="#" id="userDropdownToggle">
                    <div class="icon-container">
                        <span class="icon-down"></span>
                    </div>
                </a>
                <ul id="userDropdownMenu">
                    <li>
                        <form action="{{ route('auth.logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" style="background:none;border:none;cursor:pointer;">Logout</button>
                        </form>
                    </li>
                    <li><a href="../HTML/loginPage.html">Change User</a></li>
                </ul>
            </div>
        </div>


        <!-- Sidebar -->
        <div class="side_bar" id="sidebar">
            <ul>
                <li class="{{ request()->is('admin/products/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.product-management') }}">
                        <div class="icon-container">
                            <span class="icon-package"></span>
                        </div>
                        <span class="sidebar-label">Product Management</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/orders/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.order-management') }}">
                        <div class="icon-container">
                            <span class="icon-cart"></span>
                        </div>
                        <span class="sidebar-label">Order Management</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/inventory-management*') ? 'active' : '' }}">
                    <a href="/">
                        <div class="icon-container">
                            <span class="icon-boxes"></span>
                        </div>
                        <span class="sidebar-label">Inventory Management</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/user-management*') ? 'active' : '' }}">
                    <a href="/">
                        <div class="icon-container">
                            <span class="icon-user"></span>
                        </div>
                        <span class="sidebar-label">User Management</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/sales-reports*') ? 'active' : '' }}">
                    <a href="/">
                        <div class="icon-container">
                            <span class="icon-barChart"></span>
                        </div>
                        <span class="sidebar-label">Sales & Reports</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/content-management*') ? 'active' : '' }}">
                    <a href="/">
                        <div class="icon-container">
                            <span class="icon-file"></span>
                        </div>
                        <span class="sidebar-label">Content Management</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <a href="/">
                        <div class="icon-container">
                            <span class="icon-settings"></span>
                        </div>
                        <span class="sidebar-label">Settings & Configuration</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/notification-management*') ? 'active' : '' }}">
                    <a href="/">
                        <div class="icon-container">
                            <span class="icon-bell"></span>
                        </div>
                        <span class="sidebar-label">Notification Management</span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/audit-trail*') ? 'active' : '' }}">
                    <a href="/">
                        <div class="icon-container">
                            <span class="icon-history"></span>
                        </div>
                        <span class="sidebar-label">Audit Trail</span>
                    </a>
                </li>
            </ul>
        </div>




        <main class="main-content">
            {{ $slot }}
        </main>

        <script src="{{ asset('js/admin/admin-layout.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
        <script>
            lucide.createIcons();
        </script>

        <script>
            function showNotification(message, type = 'success', duration = 6000) {
                const container = document.getElementById('notification-container');
                const notif = document.createElement('div');
                notif.className = `notification ${type}`;
                notif.innerHTML = `
                <span>${message}</span>
                <span class="close-btn" onclick="this.parentElement.remove()">×</span>
            `;

                container.appendChild(notif);

                setTimeout(() => {
                    notif.remove();
                }, duration);
            }
        </script>



</body>

</html>
