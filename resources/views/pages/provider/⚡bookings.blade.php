<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Booking;

new #[Layout('layouts::provider')] #[Title('My Bookings')] class extends Component
{
    public $bookings;
    public $editingId = null;
    public $status = '';
    public $cancellation_reason = '';

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->bookings = Booking::with(['customer', 'service'])
            ->where('provider_id', auth()->id())
            ->latest()
            ->get();
    }

    public function openStatusModal($id)
    {
        $booking = Booking::findOrFail($id);
        $this->editingId = $booking->id;
        $this->status = $booking->status;
        $this->cancellation_reason = '';
        $this->dispatch('open-status-modal');
    }

    public function updateStatus()
    {
        $validated = $this->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'cancellation_reason' => 'nullable|string|required_if:status,cancelled',
        ]);

        $booking = Booking::where('provider_id', auth()->id())->findOrFail($this->editingId);

        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === 'cancelled') {
            $updateData['cancelled_by'] = auth()->id();
            $updateData['cancelled_at'] = now();
            $updateData['cancellation_reason'] = $validated['cancellation_reason'];
        }

        if ($validated['status'] === 'completed') {
            $updateData['completed_at'] = now();
        }

        $booking->update($updateData);

        $this->loadData();
        session()->flash('message', 'Booking status updated.');
        $this->dispatch('close-status-modal');
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
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_no }}</td>
                                <td>{{ $booking->customer->name ?? '—' }}</td>
                                <td>{{ $booking->service->service_name ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                <td>Rs. {{ number_format($booking->amount, 2) }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($booking->status) }}</span></td>
                              <td>
    <span class="badge {{ $booking->payment_status === 'paid' ? 'badge-success' : 'badge-secondary' }}">
        {{ ucfirst($booking->payment_status) }}
    </span>
</td>
<td>
    <button class="btn btn-sm btn-primary" wire:click="openStatusModal({{ $booking->id }})">Update Status</button>
</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">No bookings assigned yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Update Booking Status</h5></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    @if ($status === 'cancelled')
                        <div class="form-group">
                            <label>Cancellation Reason</label>
                            <textarea class="form-control" wire:model="cancellation_reason" rows="2"></textarea>
                            @error('cancellation_reason') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" wire:click="updateStatus">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-status-modal', () => $('#statusModal').modal('show'));
            Livewire.on('close-status-modal', () => $('#statusModal').modal('hide'));
        });
    </script>
</div>