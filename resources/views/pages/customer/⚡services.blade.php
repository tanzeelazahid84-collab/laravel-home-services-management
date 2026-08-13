<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Service;
use Illuminate\Support\Str;

new #[Layout('layouts::customer')] #[Title('Services')] class extends Component
{
    public $services;

    public function mount()
    {
        $this->services = Service::with(['category', 'subcategory'])
            ->where('status', 'active')
            ->latest()
            ->get();
    }
}; ?>

<div>
    <div class="page-title dark-background" data-aos="fade">
        <div class="container position-relative">
            <h1>Our Services</h1>
            <p>Browse everything our verified providers offer</p>
        </div>
    </div>

    <section id="courses" class="courses section">
        <div class="container">
            <div class="row">
                @forelse ($services as $service)
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                        <div class="course-item">
                            @if ($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" class="img-fluid" alt="{{ $service->service_name }}">
                            @else
                                <img src="{{ asset('customer/assets/img/course-1.jpg') }}" class="img-fluid" alt="{{ $service->service_name }}">
                            @endif
                            <div class="course-content">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p class="category">{{ $service->category->category_name ?? '' }}</p>
                                    <p class="price">Rs. {{ number_format($service->price, 0) }}</p>
                                </div>
                                <h3><a href="{{ route('customer.book-service') }}">{{ $service->service_name }}</a></h3>
                                <p class="description">{{ Str::limit($service->description, 90) }}</p>
                                <div class="trainer d-flex justify-content-between align-items-center">
                                    <div class="trainer-profile d-flex align-items-center">
                                        <span class="trainer-link">{{ $service->subcategory->subcategory_name ?? '' }}</span>
                                    </div>
                                    <a href="{{ route('customer.book-service') }}" class="btn btn-sm btn-primary">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No services available right now. Check back soon.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>