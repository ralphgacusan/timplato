<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../timplatoLogo/Timplato-Blue-LOGO.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>@yield('title', 'Timplato')</title>
    <link rel="stylesheet" href="{{ asset('css/customer/navbar.css') }}">
    @stack('styles')
    @yield('styles') <!-- This will allow child layout to inject styles -->
    @stack('scripts') <!-- To push scripts from child views -->
    @yield('scripts') <!-- Allow child views to define scripts -->
</head>

<body>
    <div class="page-wrapper">
        <!-- Header with Navigation -->
        {{-- Nav --}}
        <div class="nav">
            <a href="{{ route('customer.home') }}" style="text-decoration: none; color: inherit;"><img
                    src="{{ asset('timplatoLogo/Timplato-White2.png') }}" alt="Timplato Logo" class="logo"></a>
            <ul>
                {{-- TO BE FIXED --}}
                {{-- <li class="search-nav-item" style="position:relative;">
                    <a href="#" id="searchToggle"><i data-lucide="search"></i></a>
                    <input type="text" id="navbarSearchBar" class="navbar-search-bar" placeholder="Search..." />
                </li> --}}
                <li><a href="{{ route('customer.home') }}"><i data-lucide="house"></i></a></li>
                <li><a href="{{ route('customer.products') }}"><i data-lucide="store"></i></a></li>
                <li><a href="{{ route('customer.cart') }}"><i data-lucide="shopping-cart"></i></a></li>

                @auth

                    <li><a href="{{ route('customer.wishlist.index') }}"><i data-lucide="heart"></i></a></li>
                    <li><a href="#" id="notificationToggle"><i data-lucide="bell"></i></a></li>

                    <div id="notificationModal" class="notification-modal">
                        <div class="notification-modal-content">
                            <h2 class="notification-modal-title">Recently Received Notifications</h2>
                            <hr class="notification-modal-divider">
                            <div class="notification-list">
                                @forelse($notifications as $notification)
                                    @php
                                        $imageUrl = null;

                                        if ($notification->product?->primaryImage) {
                                            $imageUrl = asset(
                                                'images/' . $notification->product->primaryImage->image_url,
                                            );
                                        } elseif ($notification->order?->items->first()?->product?->primaryImage) {
                                            $imageUrl = asset(
                                                'images/' .
                                                    $notification->order->items->first()->product->primaryImage
                                                        ->image_url,
                                            );
                                        } else {
                                            $imageUrl = asset('images/product-placeholder.png');
                                        }
                                    @endphp

                                    <div class="notification-item">
                                        <div class="notification-img">
                                            <img src="{{ $imageUrl }}" alt="Notification Image"
                                                style="width:40px;height:40px;object-fit:cover;">
                                        </div>
                                        <div class="notification-info">
                                            <div class="notification-text">
                                                {!! $notification->message !!}
                                            </div>
                                            <div class="notification-date">
                                                {{ $notification->created_at->format('M d, Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center py-3">No notifications available.</p>
                                @endforelse
                            </div>
                            <a href="{{ route('auth.user-profile', Auth::user()->id) }}#notifications-section"
                                class="notification-viewall-btn">
                                View All
                            </a>
                        </div>
                    </div>
                @endauth


                {{-- User Dropdown --}}
                <li class="dropdown-user" style="position:relative;">
                    @guest
                        <a href="#" id="userDropdownToggle"><i data-lucide="user"></i></a>
                        <ul id="userDropdownMenu">
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('auth.signup') }}">Sign Up</a></li>
                        </ul>
                    @endguest

                    @auth
                        <a href="#" id="userDropdownToggle">
                            @if (Auth::user()->profile_picture ?? false)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile"
                                    class="profile-img" style="width:30px;height:30px;border-radius:50%;object-fit:cover;">
                            @else
                                <i data-lucide="user"></i>
                            @endif
                        </a>
                        <ul id="userDropdownMenu">
                            <li><a href="{{ route('auth.user-profile', Auth::user()->id) }}">Profile</a></li>
                            <li>
                                <form action="{{ route('auth.logout') }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit"
                                        style="background:none;border:none;cursor:pointer;">Logout</button>
                                </form>
                            </li>
                        </ul>
                    @endauth
                </li>
            </ul>
        </div>

        <div id="notification-container"></div>

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

        <main class="main-container">

            {{ $slot }}

        </main>

        <!-- Footer -->
        <div class="footer">
            <a href="{{ route('customer.customer-support.index') }}" style="text-decoration: none; color: inherit;">
                <p>Help Center</p>
            </a>

            <p>&copy; 2023 Timplato. All rights reserved.</p>
        </div>
    </div>

    <script src="{{ asset('js/customer/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        lucide.createIcons();
    </script>


</body>

</html>
