<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::customer')] #[Title('Home')] class extends Component {
    //
}; ?>

<div>
    {{-- Hero Section --}}
    <section id="hero" class="hero section dark-background">
        <img src="{{ asset('customer/assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">
        <div class="container">
            <h2 data-aos="fade-up" data-aos-delay="100">Trusted Help,<br>Right At Your Door</h2>
            <p data-aos="fade-up" data-aos-delay="200">Book verified professionals for cleaning, plumbing, electrical work and more</p>
            <div class="d-flex mt-4 gap-2" data-aos="fade-up" data-aos-delay="300">
                @auth
                    @php
                        $userRole = strtolower(trim(auth()->user()->role));
                    @endphp
                    @if($userRole === 'customer')
                        <a href="{{ route('customer.book-service') }}" class="btn-get-started">Book Now</a>
                        <a href="{{ route('customer.my-bookings') }}" class="btn-get-started">My Bookings</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-get-started">Get Started</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-get-started">Get Started</a>
                @endauth
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="about section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{ asset('customer/assets/img/about.jpg') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
                    <h3>Why Choose Home Services</h3>
                    <p class="fst-italic">
                        We connect you with skilled, background-checked service providers in your area, ready to help whenever you need them.
                    </p>
                    <ul>
                        <li><i class="bi bi-check-circle"></i> <span>Verified and reviewed local professionals.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Transparent pricing set by each provider.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Book in minutes, track your booking status in real time.</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>