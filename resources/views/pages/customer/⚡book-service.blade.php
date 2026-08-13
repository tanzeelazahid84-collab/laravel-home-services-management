<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Service;
use App\Models\ProviderService;
use App\Models\Booking;
use Illuminate\Support\Str;

new #[Layout('layouts::customer')] #[Title('Book a Service')] class extends Component
{
    public $services;
    public $providers = [];
    public $noProvidersMessage = '';

    public $service_id = '';
    public $provider_id = '';
    public $booking_date = '';
    public $booking_time = '';
    public $address = '';
    public $remarks = '';

    public function mount()
    {
        $this->services = Service::where('status', 'active')->get();
    }

    private function loadProviders()
    {
        if (empty($this->service_id)) {
            $this->providers = [];
            $this->provider_id = '';
            $this->noProvidersMessage = '';
            return;
        }

        $this->providers = ProviderService::with('provider')
            ->where('service_id', $this->service_id)
            ->where('status', 'active')
            ->get();

        $this->provider_id = '';
        $this->noProvidersMessage = '';

        if ($this->providers->isEmpty()) {
            $this->noProvidersMessage = 'No active providers are available for this service yet.';
            return;
        }

        if ($this->providers->count() === 1) {
            $this->provider_id = $this->providers->first()->provider_id;
        }
    }

    public function updatedServiceId($value)
    {
        $this->service_id = $value;
        $this->loadProviders();
    }

    public function store()
    {
        $this->loadProviders();

        if ($this->providers->isEmpty()) {
            session()->flash('error', 'No active providers are available for this service yet.');
            return;
        }

        if (empty($this->provider_id) && $this->providers->count() === 1) {
            $this->provider_id = $this->providers->first()->provider_id;
        }

        $validated = $this->validate([
            'service_id' => 'required|exists:services,id',
            'provider_id' => 'required|exists:users,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'address' => 'required|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $providerService = ProviderService::where('provider_id', $validated['provider_id'])
            ->where('service_id', $validated['service_id'])
            ->firstOrFail();

        Booking::create([
            'booking_no' => 'BK-' . strtoupper(Str::random(8)),
            'customer_id' => auth()->id(),
            'provider_id' => $validated['provider_id'],
            'service_id' => $validated['service_id'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'address' => $validated['address'],
            'amount' => $providerService->price,
            'remarks' => $validated['remarks'],
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        session()->flash('message', 'Booking submitted! You can track it in My Bookings.');
        $this->reset(['service_id', 'provider_id', 'booking_date', 'booking_time', 'address', 'remarks']);
        $this->providers = [];
        $this->noProvidersMessage = '';
    }
}; ?>

<div>
    <h3 class="page-title">Book a Service</h3>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

            @if (session('error'))
                <div class="alert alert-warning">{{ session('error') }}</div>
            @endif
            <div class="form-group">
                <label>Select Service</label>
                <select class="form-control" wire:model.live="service_id">
                    <option value="">-- Select Service --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                    @endforeach
                </select>
                @error('service_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Select Provider</label>
                <select class="form-control" wire:model="provider_id">
                    <option value="">-- Select Provider --</option>
                    @foreach ($providers as $ps)
                        <option value="{{ $ps->provider_id }}">
                            {{ $ps->provider->name }} — Rs. {{ number_format($ps->price, 2) }}
                        </option>
                    @endforeach
                </select>
                @if ($service_id && $providers->isEmpty())
                    <small class="text-warning d-block mt-2">{{ $noProvidersMessage }}</small>
                @endif
                @error('provider_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" wire:model="booking_date">
                @error('booking_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Time</label>
                <input type="time" class="form-control" wire:model="booking_time">
                @error('booking_time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Your Address</label>
                <input type="text" class="form-control" wire:model="address">
                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Notes (optional)</label>
                <textarea class="form-control" wire:model="remarks" rows="2"></textarea>
            </div>

            <button class="btn btn-primary" wire:click="store">Confirm Booking</button>
        </div>
    </div>
</div>