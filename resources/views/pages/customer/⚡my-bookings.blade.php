<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Booking;
use App\Models\Review;
use Stripe\Stripe;
use Stripe\Checkout\Session;

new #[Layout('layouts::customer')] #[Title('My Bookings')] class extends Component
{
    public $bookings;

    public $reviewingBookingId = null;
    public $rating = 5;
    public $comment = '';

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->bookings = Booking::with(['provider', 'service', 'review'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->get();
    }

    public function payNow($bookingId)
    {
        $booking = Booking::where('customer_id', auth()->id())->findOrFail($bookingId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $booking->service->service_name ?? 'Home Service',
                    ],
                    'unit_amount' => (int) (max($booking->amount, 1) * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['booking' => $booking->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('customer.my-bookings'),
        ]);

        return redirect($session->url);
    }

    public function openReviewModal($bookingId)
    {
        $this->reviewingBookingId = $bookingId;
        $this->rating = 5;
        $this->comment = '';
        $this->dispatch('open-review-modal');
    }

    public function submitReview()
    {
        $validated = $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::where('customer_id', auth()->id())->findOrFail($this->reviewingBookingId);

        Review::create([
            'booking_id' => $booking->id,
            'customer_id' => auth()->id(),
            'provider_id' => $booking->provider_id,
            'service_id' => $booking->service_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'active',
        ]);

        $this->loadData();
        session()->flash('message', 'Thank you for your review!');
        $this->dispatch('close-review-modal');
    }
}; ?>

<div>
    <h3 class="page-title">My Bookings</h3>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking #</th>
                            <th>Service</th>
                            <th>Provider</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_no }}</td>
                                <td>{{ $booking->service->service_name ?? '—' }}</td>
                                <td>{{ $booking->provider->name ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                <td>Rs. {{ number_format($booking->amount, 2) }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($booking->status) }}</span></td>
                                <td>
                                    @if ($booking->payment_status === 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @else
                                        <button class="btn btn-sm btn-primary" wire:click="payNow({{ $booking->id }})">Pay Now</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($booking->status === 'completed')
                                        @if ($booking->review)
                                            <span class="badge badge-success">{{ $booking->review->rating }} ★ Reviewed</span>
                                        @else
                                            <button class="btn btn-sm btn-outline-primary" wire:click="openReviewModal({{ $booking->id }})">Leave a Review</button>
                                        @endif
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted">No bookings yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Leave a Review</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Rating</label>
                        <select class="form-control" wire:model="rating">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Good</option>
                            <option value="3">3 - Average</option>
                            <option value="2">2 - Poor</option>
                            <option value="1">1 - Very Poor</option>
                        </select>
                        @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Comment (optional)</label>
                        <textarea class="form-control" wire:model="comment" rows="3"></textarea>
                        @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
<button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" wire:click="submitReview">Submit Review</button>
                </div>
            </div>
        </div>
    </div>

   <script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-review-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
            modal.show();
        });
        Livewire.on('close-review-modal', () => {
            const modalEl = document.getElementById('reviewModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    });
</script>
</div>