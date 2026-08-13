<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;

new #[Layout('layouts::customer')] #[Title('Providers')] class extends Component
{
    public $providers;

   public function mount()
{
    $this->providers = User::where('role', 'provider')
        ->where('status', 'active')
        ->withCount('providerServices')
        ->withAvg('receivedReviews', 'rating')
        ->get();
}
}; ?>

<div>
    <div class="page-title dark-background" data-aos="fade">
        <div class="container position-relative">
            <h1>Our Providers</h1>
            <p>Meet the verified professionals ready to help</p>
        </div>
    </div>

    <section id="trainers" class="section trainers">
        <div class="container">
            <div class="row gy-5">
                @forelse ($providers as $provider)
                    <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
                        <div class="member-img">
                            @if ($provider->profile_image)
                                <img src="{{ asset('storage/' . $provider->profile_image) }}" class="img-fluid" alt="{{ $provider->name }}">
                            @else
                                <img src="{{ asset('customer/assets/img/team/team-1.jpg') }}" class="img-fluid" alt="{{ $provider->name }}">
                            @endif
                        </div>
                       <div class="member-info text-center">
    <h4>{{ $provider->name }}</h4>
    <span>{{ $provider->city ?? 'Home Services Provider' }}</span>
    <p>{{ $provider->provider_services_count }} service{{ $provider->provider_services_count === 1 ? '' : 's' }} offered</p>
    @if ($provider->receivedReviews_avg_rating)
        <p>⭐ {{ number_format($provider->receivedReviews_avg_rating, 1) }} / 5</p>
    @endif
</div>
                    </div>
                @empty
                    <p class="text-center">No providers available right now. Check back soon.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>