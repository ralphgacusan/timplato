<x-customer-layout>

    @section('title', 'Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
    @endpush

    <div class="hero-section">
        <div class="heroGrid">
            <div class="heroImageCol">
                <img src="{{ asset('Assets/heroPlate.png') }}" alt="hero header image" class="heroImage">
            </div>
            <div class="heroTextCol">
                <h1 class="heroTitle">WELCOME TO</h1>
                <img src="{{ asset('timplatoLogo/Timplato-White2.png') }}" alt="" class="heroLogo">
                <p class="heroSubtitle">
                    an e-commerce platform that focuses on providing kitchenware and cooking
                    essentials to Filipino households. The name "Timplato" comes from two Filipino words, "timpla" which
                    means to mix or season, and "plato" which means plate. This reflects the brand’s goal of helping
                    people prepare and enjoy meals with the right tools.
                </p>
            </div>
            <div class="shopNow">
                <a href="{{ route('customer.products') }}" class="shop-now-btn">Shop Now</a>
            </div>
        </div>
    </div>

    <div class="promo-carousel">
        <div id="carouselExampleControls" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('Assets/timplatoLandingBanner.png') }}" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('Assets/testing1.png') }}" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('Assets/timplatoLandingBanner.png') }}" alt="Third slide">
                </div>
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

</x-customer-layout>
