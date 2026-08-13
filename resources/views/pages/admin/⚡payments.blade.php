<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


new #[Layout('layouts::admin')] #[Title('Payments')] class extends Component
{
    public $payments;

    public function mount()
    {
        $this->payments = Payment::with(['booking', 'customer'])->latest()->get();
    }
}; ?>

<div>
    <h3 class="page-title">Payments</h3>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking #</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->booking->booking_no ?? '—' }}</td>
                                <td>{{ $payment->customer->name ?? '—' }}</td>
                                <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td><span class="badge badge-success">{{ ucfirst($payment->status) }}</span></td>
                                <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, g:i A') : '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">No payments recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>