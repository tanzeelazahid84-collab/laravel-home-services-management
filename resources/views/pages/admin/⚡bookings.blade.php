<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Booking;

new #[Layout('layouts::admin')] #[Title('Manage Bookings')] class extends Component
{
    public $bookings;

    public function mount()
    {
        $this->bookings = Booking::with(['customer', 'provider', 'service'])->latest()->get();
    }
}; ?>

<div>
    <h3 class="page-title">Manage Bookings</h3>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking #</th>
                            <th>Customer</th>
                            <th>Provider</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_no }}</td>
                                <td>{{ $booking->customer->name ?? '—' }}</td>
                                <td>{{ $booking->provider->name ?? '—' }}</td>
                                <td>{{ $booking->service->service_name ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                <td>Rs. {{ number_format($booking->amount, 2) }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($booking->status) }}</span></td>
                                <td><span class="badge {{ $booking->payment_status === 'paid' ? 'badge-success' : 'badge-secondary' }}">{{ ucfirst($booking->payment_status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted">No bookings yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>