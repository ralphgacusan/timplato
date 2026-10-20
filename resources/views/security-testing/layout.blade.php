<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Security Testing Lab')</title>
    <link rel="stylesheet" href="{{ asset('css/customer/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/sign-in.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/specific-product.css') }}">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 0 0 48px;
            background: #f2f4f8;
            color: #333;
            font-family: 'Inter', sans-serif;
        }

        .security-banner {
            position: sticky;
            top: 0;
            z-index: 1001;
            margin: 0;
            padding: 14px 20px;
            background: #9b1c1c;
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-align: center;
        }

        .lab-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            min-height: 90px;
            padding: 10px clamp(20px, 5vw, 56px);
            background: #304c89;
        }

        .lab-navigation .logo {
            height: 64px;
            margin: 0;
        }

        .lab-navigation-links {
            display: flex;
            gap: 28px;
        }

        .lab-navigation a {
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }

        .lab-navigation a:hover {
            color: #f4ae71;
        }

        .lab-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .lab-panel {
            margin: 32px auto 48px;
            padding: 32px;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .1);
        }

        .lab-panel h1,
        .lab-panel h2 {
            color: #304c89;
        }

        .signin-hero {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 560px;
            margin: 32px auto 48px;
            padding: 32px 20px;
            border-radius: 18px;
            background-position: center;
            background-size: cover;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .1);
        }

        .signin-hero .loginContainer {
            min-width: 0;
        }

        .lab-fixture-note {
            margin: 0;
            color: #666;
            font-size: .9rem;
        }

        .lab-panel pre {
            overflow-wrap: anywhere;
            white-space: pre-wrap;
        }

        .lab-panel textarea {
            min-height: 120px;
            resize: vertical;
        }

        .lab-product-page {
            align-items: center;
            margin: 32px auto 48px;
        }

        .lab-product-image {
            width: 100%;
            max-width: 420px;
            height: 340px;
            object-fit: cover;
            border-radius: 10px;
        }

        .lab-review-form {
            gap: 14px;
            margin-top: 24px;
        }

        .lab-review-form .formButton {
            width: 100%;
        }

        .lab-review-form textarea {
            min-height: 120px;
            resize: vertical;
        }

        .lab-reset-form {
            margin: 24px 0 0;
            text-align: right;
        }

        .lab-reset-form button {
            padding: 9px 16px;
            border: 1px solid #304c89;
            border-radius: 6px;
            background: #fff;
            color: #304c89;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .lab-database {
            max-width: 1200px;
            margin-top: 0;
        }

        .lab-database h3 {
            color: #304c89;
        }

        .lab-database table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .lab-database th,
        .lab-database td {
            padding: 10px;
            border: 1px solid #d9dfe8;
            text-align: left;
            vertical-align: top;
            overflow-wrap: anywhere;
        }

        .lab-database th {
            background: #eef2f8;
        }

        .lab-table-wrap {
            overflow-x: auto;
        }

        @media (max-width: 600px) {
            .security-banner {
                font-size: .85rem;
            }

            .lab-navigation {
                min-height: 76px;
                padding: 8px 16px;
            }

            .lab-navigation .logo {
                height: 52px;
            }

            .lab-navigation-links {
                gap: 16px;
            }

            .lab-content {
                padding: 0 12px;
            }

            .lab-panel,
            .product-page-container {
                padding: 20px;
            }

            .signin-hero {
                min-height: 500px;
                padding: 20px 12px;
            }

            .lab-product-page {
                flex-direction: column;
                gap: 24px;
            }

            .lab-product-page .product-image-section,
            .lab-product-page .product-details-section {
                width: 100%;
                max-width: none;
                min-width: 0;
            }

            .lab-product-image {
                height: auto;
                max-height: 340px;
            }
        }
    </style>
</head>

<body>
    <header class="security-banner">SECURITY TESTING ONLY — INTENTIONALLY VULNERABLE</header>
    <nav class="lab-navigation" aria-label="Security testing pages">
        <img src="{{ asset('timplatoLogo/Timplato-White2.png') }}" alt="Timplato" class="logo">
        <div class="lab-navigation-links">
            <a href="{{ route('security-testing.signin') }}">Login</a>
            <a href="{{ route('security-testing.reviews') }}">Reviews</a>
        </div>
    </nav>

    <main class="lab-content">
        @yield('content')
    </main>
</body>

</html>
