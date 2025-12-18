<x-customer-layout>
    @section('title', $aboutPage->title ?? 'About Us - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
        <style>
            /* === General Section Styles === */
            .home-section {
                max-width: 1200px;
                margin: 60px auto;
                padding: 0 30px;
            }

            .section-title {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 25px;
                text-align: center;
                color: #0a143b;
            }

            /* === Hero Section === */
            .hero-section {
                padding-top: 150px;
                background: #304C89;
            }

            .heroGrid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 40px;
                align-items: center;
                max-width: 1200px;
                margin: 0 auto;
            }

            .heroTextCol {
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            .heroTitle {
                font-size: 3.5rem;
                font-weight: 800;
                color: #ffbe82;
            }

            .heroSubtitle {
                font-size: 1.3rem;
                color: #f6f6f6;
                text-align: justify;
            }

            .heroImageCol img {
                width: 100%;
                max-width: 500px;
                border-radius: 18px;
                object-fit: cover;
            }

            /* === Carousel Section === */
            .promo-carousel {
                margin-top: 60px;
            }

            #carouselExampleControls .carousel-item img {
                border-radius: 20px;
                max-height: 400px;
                object-fit: cover;
                width: 100%;
            }

            .carousel-control-prev,
            .carousel-control-next {
                width: 45px;
                height: 45px;
                background: rgba(0, 0, 0, 0.25);
                border-radius: 50%;
                top: 50%;
                transform: translateY(-50%);
            }

            /* === Story & Team Cards === */
            .story-card,
            .team-card {
                background: #fff;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
                flex: 1 1 300px;
                text-align: center;
            }

            .team-card img {
                width: 100%;
                height: 220px;
                object-fit: cover;
                border-radius: 20px;
                margin-bottom: 12px;
            }

            /* === Call to Action === */
            .cta-section {
                text-align: center;
                background: #F4AE71;
                padding: 40px;
                border-radius: 20px;
                margin: 40px auto;
                max-width: 900px;
            }

            .cta-section h2 {
                color: #fff;
                font-weight: 700;
                margin-bottom: 20px;
            }

            .shop-now-btn {
                display: inline-block;
                background: #4A8FE7;
                color: #fff;
                font-weight: 700;
                font-size: 1.2rem;
                padding: 14px 36px;
                border-radius: 12px;
                text-decoration: none;
                transition: background 0.2s, transform 0.2s;
            }

            .shop-now-btn:hover {
                background: #3a7ad1;
                transform: scale(1.05);
            }

            /* === Responsive Styles === */
            @media (max-width: 992px) {
                .heroGrid {
                    grid-template-columns: 1fr;
                    text-align: center;
                }

                .heroTextCol {
                    align-items: center;
                }

                .heroImageCol img {
                    max-width: 100%;
                }
            }

            @media (max-width: 576px) {
                .heroTitle {
                    font-size: 2.5rem;
                }

                .heroSubtitle {
                    font-size: 1rem;
                }
            }
        </style>
    @endpush

    {{-- Hero Section --}}
    <div class="hero-section">
        <div class="heroGrid">
            <div class="heroTextCol">
                <h1 class="heroTitle">{{ $aboutPage->title ?? 'About Us' }}</h1>
                <p class="heroSubtitle">{!! $aboutPage->content ?? '' !!}</p>
            </div>
            <div class="heroImageCol">
                <img src="{{ asset($aboutPage->image ?? 'Assets/heroPlate.png') }}" alt="About Us Image">
            </div>
        </div>
    </div>

    {{-- Banners / Promotions Carousel --}}
    @if ($banners->count())
        <section class="home-section">
            <div class="promo-carousel">
                <div id="carouselExampleControls" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach ($banners as $banner)
                            @if ($banner->active)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>
    @endif

    {{-- Our Story Section --}}
    @if ($aboutPage->sections)
        <section class="home-section">
            <h2 class="section-title">Our Story</h2>
            <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
                @foreach ($aboutPage->sections as $section)
                    <div class="story-card">
                        <h3>{{ $section['title'] }}</h3>
                        <p>{{ $section['content'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Meet the Team Section --}}
    @if ($teamMembers->count())
        <section class="home-section">
            <h2 class="section-title">Meet the Team</h2>
            <div style="display: flex; flex-wrap: wrap; gap: 25px; justify-content: center;">
                @foreach ($teamMembers as $member)
                    <div class="team-card">
                        <img src="{{ asset($member->image) }}" alt="{{ $member->name }}">
                        <h5>{{ $member->name }}</h5>
                        <p>{{ $member->title }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Call to Action --}}
    @if ($aboutPage->cta_text && $aboutPage->cta_link)
        <section class="home-section">
            <div class="cta-section">
                <h2>{{ $aboutPage->cta_text }}</h2>
                <a href="{{ $aboutPage->cta_link }}" class="shop-now-btn">Shop Now</a>
            </div>
        </section>
    @endif
</x-customer-layout>
