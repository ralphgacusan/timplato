<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#304c89">
    <title>@yield('title', 'Timplato | Kitchen essentials')</title>
    <link rel="stylesheet" href="{{ asset('css/security-testing.css') }}">
</head>
<body class="storefront">
    <div class="security-banner" role="note">
        <span class="security-banner__dot" aria-hidden="true"></span>
        SECURITY TESTING ONLY · TRAINING ENVIRONMENT
    </div>

    @php
        $labUser = session('security_lab_user', []);
        $labCartCount = array_sum(array_map('intval', session('security_lab_cart', [])));
    @endphp

    <header class="site-header">
        <div class="site-header__inner">
            <a class="brand" href="{{ route('security-testing.products') }}" aria-label="Timplato home">
                <img src="{{ asset('timplatoLogo/Timplato-White2.png') }}" alt="Timplato">
            </a>
            <nav class="site-nav" aria-label="Main navigation">
                <a href="{{ route('security-testing.products') }}" @if (request()->routeIs('security-testing.products')) aria-current="page" @endif>Shop</a>
                <a href="{{ route('security-testing.database') }}" @if (request()->routeIs('security-testing.database')) aria-current="page" @endif>Database</a>
                <a class="site-nav__cart" href="{{ route('security-testing.cart') }}">
                    Cart <span class="cart-count" aria-label="{{ $labCartCount }} items">{{ $labCartCount }}</span>
                </a>
                @if (!empty($labUser))
                    <span class="site-nav__greeting">Hi, {{ data_get($labUser, 'name', data_get($labUser, 'email', 'there')) }}</span>
                    <form action="{{ route('security-testing.logout') }}" method="POST" class="nav-logout">
                        @csrf
                        <button type="submit">Log out</button>
                    </form>
                @else
                    <a href="{{ route('security-testing.signin') }}">Sign in</a>
                    <a class="site-nav__signup" href="{{ route('security-testing.signup') }}">Create account</a>
                @endif
            </nav>
        </div>
    </header>

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="site-footer__inner">
            <a class="site-footer__brand" href="{{ route('security-testing.products') }}">Timplato</a>
            <p>Thoughtful tools for the everyday kitchen.</p>
            <span>© {{ date('Y') }} Timplato · Training storefront</span>
        </div>
    </footer>
</body>
</html>
