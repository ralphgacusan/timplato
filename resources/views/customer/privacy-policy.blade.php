<x-customer-layout>
    @section('title', 'Privacy Policy - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
        <style>
            .privacy-section {
                max-width: 1000px;
                margin: 60px auto;
                padding: 0 50px;
                color: #212529;
            }

            .privacy-title {
                font-size: 1.8rem;
                font-weight: 700;
                margin-bottom: 25px;
                text-align: center;
                color: #0a143b;
            }

            .privacy-content {
                line-height: 1.8;
                font-size: 1rem;
                color: #6C757D;
            }

            .privacy-section h3 {
                margin-top: 25px;
                margin-bottom: 10px;
                font-size: 1.2rem;
                color: #0a143b;
                font-weight: 700;
            }

            @media (max-width: 768px) {
                .privacy-section {
                    padding: 0 25px;
                }
            }
        </style>
    @endpush
    {{-- Hero Section --}}
    <div class="hero-section" style="padding-top: 150px; background: #304C89;">
        <div class="heroGrid">
            <div class="heroTextCol">
                <h1 class="heroTitle" style="font-size: 3.5rem;">
                    {!! $sections['hero']->title ?? 'Privacy Policy' !!}
                </h1>
                <p class="heroSubtitle" style="text-align: justify; font-size: 1.3rem;">
                    {!! $sections['hero']->content ?? '' !!}
                </p>
            </div>
            <div class="heroImageCol">
                <img src="{{ asset('Assets/heroPlate.png') }}" alt="Contact Us Image" class="heroImage">
            </div>
        </div>
    </div>

    {{-- Privacy Policy Content --}}
    <section class="privacy-section">
        <h2 class="privacy-title">Privacy Policy Overview</h2>
        <div class="privacy-content">
            {!! $sections['privacy-content']->content ??
                '
                                                                                                                <p>At Timplato, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and protect your data when you visit our website or use our services.</p>
                                                                                                                <h3>1. Information We Collect</h3>
                                                                                                                <p>We may collect personal information such as your name, email address, phone number, shipping address, and payment details when you make purchases or interact with our website.</p>
                                                                                                                <h3>2. How We Use Your Information</h3>
                                                                                                                <p>We use your information to process orders, provide customer support, improve our services, and send you promotional updates if you have opted in.</p>
                                                                                                                
                                                                                                            ' !!}
        </div>
    </section>
</x-customer-layout>
