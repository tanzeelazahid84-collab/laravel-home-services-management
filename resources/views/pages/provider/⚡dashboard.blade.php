<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

new #[Layout('layouts::provider')] #[Title('Provider Dashboard')] class extends Component {
    public $totalServices = 0;
    public $totalBookings = 0;
    public $pendingBookings = 0;

    public function mount()
    {
        $providerId = auth()->id();

        // provider_services pivot table confirmed (provider_id, service_id,
        // price, duration, status) — counting directly via query builder since
        // no dedicated model class has been confirmed for this table.
        $this->totalServices = DB::table('provider_services')
            ->where('provider_id', $providerId)
            ->count();
        $this->totalBookings = Booking::where('provider_id', $providerId)->count();

        // ASSUMPTION: Booking has a 'status' column with a 'pending' value.
        $this->pendingBookings = Booking::where('provider_id', $providerId)
            ->where('status', 'pending')
            ->count();
    }
}; ?>

<div>
    <div class="page-header mb-4">
        <h3 class="page-title">Service provider Dashboard</h3>
        <p>Welcome, {{ auth()->user()->name }}. This is your provider dashboard.</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-concierge-bell mb-2"></i>
                    <h5>Services Offered</h5>
                    <h2 class="mb-0">{{ $totalServices }}</h2>
                    <a class="small" href="{{ route('provider.services') }}">Manage services</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-calendar-check mb-2"></i>
                    <h5>Total Bookings</h5>
                    <h2 class="mb-0">{{ $totalBookings }}</h2>
                    <a class="small" href="{{ route('provider.bookings') }}">View bookings</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-hourglass-half mb-2"></i>
                    <h5>Pending Bookings</h5>
                    <h2 class="mb-0">{{ $pendingBookings }}</h2>
                    <a class="small" href="{{ route('provider.bookings') }}">Review pending</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-clock mb-2"></i>
                    <h5>Availability</h5>
                    <h2 class="mb-0">&nbsp;</h2>
                    <a class="small" href="{{ route('provider.availability') }}">Set availability</a>
                </div>
            </div>
        </div>
    </div>
</div>
