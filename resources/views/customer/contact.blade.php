<x-customer-layout>

    @section('title', $contactPage->title ?? 'Contact - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
        <style>
            .contact-section {
                max-width: 1200px;
                margin: 60px auto;
                padding: 0 50px;
            }

            .contact-title {
                font-size: 1.8rem;
                font-weight: 700;
                margin-bottom: 25px;
                text-align: center;
                color: #0a143b;
            }

            .contact-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 40px;
                justify-content: space-between;
            }

            .contact-info,
            .contact-form {
                flex: 0 0 48%;
                background: #fff;
                padding: 30px;
                border-radius: 20px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            }

            .contact-info h3,
            .contact-form h3 {
                color: #0a143b;
                font-weight: 700;
                margin-bottom: 15px;
            }

            .contact-info p {
                color: #6C757D;
                font-size: 1rem;
                margin-bottom: 10px;
            }

            .contact-form input,
            .contact-form textarea {
                width: 100%;
                padding: 12px 16px;
                margin-bottom: 15px;
                border-radius: 12px;
                border: 1px solid #ccc;
                font-size: 1rem;
            }

            .contact-form button {
                background-color: #4A8FE7;
                color: #fff;
                font-weight: 600;
                padding: 12px 24px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                transition: background 0.2s, transform 0.2s;
            }

            .contact-form button:hover {
                background-color: #3a7ad1;
                transform: scale(1.05);
            }

            /* Map box */
            #storeMap {
                width: 100%;
                height: 400px;
                border-radius: 20px;
                margin-top: 40px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            }

            @media (max-width: 768px) {

                .contact-info,
                .contact-form {
                    flex: 0 0 100%;
                }

                .contact-section {
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
                    {!! $sections['hero']->title ?? 'Contact Us' !!}
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

    {{-- Contact Section --}}
    <section class="contact-section">
        <h2 class="contact-title">{{ $sections['contact-info']->title ?? 'Contact Info' }}</h2>
        <div class="contact-grid">

            {{-- Dynamic Contact Info --}}
            <div class="contact-info">
                <h3>Contact Information</h3>
                {!! $sections['contact-info']->content ?? 'N/A' !!}
            </div>

            {{-- Static Contact Form --}}
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                {!! $sections['contact-form']->content ?? '' !!}
                <input type="text" name="name" placeholder="Your Name" value="John Doe" disabled>
                <input type="email" name="email" placeholder="Your Email" value="johndoe@example.com" disabled>
                <input type="text" name="subject" placeholder="Subject" value="Inquiry about products" disabled>
                <textarea name="message" rows="6" placeholder="Your Message" disabled>
Hi, I am interested in learning more about your products. Please provide more details.
                </textarea>
                <button type="button" disabled>Send Message</button>
            </div>

        </div>

        {{-- ✅ Google Map
        <h2 class="contact-title" style="margin-top: 60px;">Our Store Locations</h2>
        <div id="storeMap"></div> --}}

    </section>


    @push('scripts')
        {{-- <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4iUAW0oPbUL6lSfzE0hf1mUgjiz8qpqY&callback=initStoreMap&v=beta&libraries=marker"
            defer></script>


        <script>
            function initStoreMap() {
                const map = new google.maps.Map(document.getElementById("storeMap"), {
                    center: {
                        lat: 14.5995,
                        lng: 120.9842
                    }, // Manila default
                    zoom: 11,
                });

                // Store locations
                const stores = [{
                        name: "Main Branch",
                        lat: 14.5995,
                        lng: 120.9842
                    },
                    {
                        name: "QC Branch",
                        lat: 14.681,
                        lng: 121.0437
                    },
                    {
                        name: "Makati Branch",
                        lat: 14.5547,
                        lng: 121.0244
                    }
                ];

                stores.forEach(store => {
                    new google.maps.marker.AdvancedMarkerElement({
                        position: {
                            lat: store.lat,
                            lng: store.lng
                        },
                        map,
                        title: store.name
                    });
                });
            }
        </script> --}}
    @endpush

</x-customer-layout>
