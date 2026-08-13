<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Booking;

new #[Layout('layouts::customer')] #[Title('My Dashboard')] class extends Component {
    public $totalBookings = 0;
    public $pendingBookings = 0;
    public $completedBookings = 0;

    public function mount()
    {
        $customerId = auth()->id();

        $this->totalBookings = Booking::where('customer_id', $customerId)->count();

        // Same caveat as the provider dashboard: confirm the exact 'status'
        // string values (case, wording) so these aren't silently 0.
        $this->pendingBookings = Booking::where('customer_id', $customerId)
            ->where('status', 'pending')
            ->count();

        $this->completedBookings = Booking::where('customer_id', $customerId)
            ->where('status', 'completed')
            ->count();
    }
}; ?>

<div>
    {{-- Hero Section --}}
    <section id="hero" class="hero section dark-background">
        <img src="{{ asset('customer/assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">
        <div class="container">
            <h2 data-aos="fade-up" data-aos-delay="100">Welcome back, {{ auth()->user()->name }}</h2>
            <p data-aos="fade-up" data-aos-delay="200">Here's a quick look at your bookings</p>
            <div class="d-flex mt-4 gap-2" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('customer.book-service') }}" class="btn-get-started">Book Now</a>
                <a href="{{ route('customer.my-bookings') }}" class="btn-get-started">My Bookings</a>
            </div>
        </div>
    </section>

    {{-- Quick Stats Section --}}
    <section id="dashboard-stats" class="about section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="bi bi-calendar-check icon-lg mb-2"></i>
                            <h5>Total Bookings</h5>
                            <h2 class="mb-0">{{ $totalBookings }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="bi bi-hourglass-split icon-lg mb-2"></i>
                            <h5>Pending</h5>
                            <h2 class="mb-0">{{ $pendingBookings }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="bi bi-check-circle icon-lg mb-2"></i>
                            <h5>Completed</h5>
                            <h2 class="mb-0">{{ $completedBookings }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>