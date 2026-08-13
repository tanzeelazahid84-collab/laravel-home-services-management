<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\ProviderService;
use App\Models\Service;

new #[Layout('layouts::provider')] #[Title('My Services')] class extends Component
{
    public $providerServices;
    public $availableServices;

    public $service_id = '';
    public $price = '';
    public $duration = '';
    public $editingId = null;
    public $confirmingDeleteId = null;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $providerId = auth()->id();

        $this->providerServices = ProviderService::with('service')
            ->where('provider_id', $providerId)
            ->latest()
            ->get();

        $alreadyAddedIds = $this->providerServices->pluck('service_id');

        $this->availableServices = Service::where('status', 'active')
            ->whereNotIn('id', $alreadyAddedIds)
            ->get();
    }

    public function resetForm()
    {
        $this->reset(['service_id', 'price', 'duration', 'editingId']);
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->dispatch('open-add-modal');
    }

    public function store()
    {
        $validated = $this->validate([
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
        ]);

        $validated['provider_id'] = auth()->id();
        $validated['status'] = 'active';

        ProviderService::create($validated);

        $this->loadData();
        session()->flash('message', 'Service added to your offerings.');
        $this->dispatch('close-add-modal');
    }

    public function edit($id)
    {
        $ps = ProviderService::findOrFail($id);
        $this->editingId = $ps->id;
        $this->price = $ps->price;
        $this->duration = $ps->duration;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $validated = $this->validate([
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
        ]);

        ProviderService::where('provider_id', auth()->id())
            ->findOrFail($this->editingId)
            ->update($validated);

        $this->loadData();
        session()->flash('message', 'Price updated successfully.');
        $this->dispatch('close-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function delete()
    {
        ProviderService::where('provider_id', auth()->id())
            ->findOrFail($this->confirmingDeleteId)
            ->delete();

        $this->loadData();
        session()->flash('message', 'Service removed from your offerings.');
        $this->dispatch('close-delete-modal');
    }
}; ?>

<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">My Services</h3>
        <button class="btn btn-primary" wire:click="openAddModal">
            <i class="fa fa-plus mr-1"></i> Add Service
        </button>
    </div>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>My Price</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($providerServices as $ps)
                            <tr>
                                <td>{{ $ps->service->service_name ?? '—' }}</td>
                                <td>Rs. {{ number_format($ps->price, 2) }}</td>
                                <td>{{ $ps->duration ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $ps->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($ps->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="edit({{ $ps->id }})">Edit Price</button>
                                    <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $ps->id }})">Remove</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">You haven't added any services yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ADD MODAL --}}
    <div wire:ignore.self class="modal fade" id="addProviderServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a Service You Offer</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Service</label>
                        <select class="form-control" wire:model="service_id">
                            <option value="">-- Select Service --</option>
                            @foreach ($availableServices as $service)
                                <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                            @endforeach
                        </select>
                        @error('service_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Your Price (Rs.)</label>
                        <input type="number" step="0.01" class="form-control" wire:model="price">
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Duration</label>
                        <input type="text" class="form-control" wire:model="duration" placeholder="e.g. 1-2 hours">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" wire:click="store">Add Service</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div wire:ignore.self class="modal fade" id="editProviderServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Your Price</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Your Price (Rs.)</label>
                        <input type="number" step="0.01" class="form-control" wire:model="price">
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Duration</label>
                        <input type="text" class="form-control" wire:model="duration" placeholder="e.g. 1-2 hours">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" wire:click="update">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div wire:ignore.self class="modal fade" id="deleteProviderServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove Service</h5>
                </div>
                <div class="modal-body">
                    Remove this service from your offerings? Customers won't see it listed under you anymore.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" wire:click="delete">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-add-modal', () => $('#addProviderServiceModal').modal('show'));
            Livewire.on('close-add-modal', () => $('#addProviderServiceModal').modal('hide'));
            Livewire.on('open-edit-modal', () => $('#editProviderServiceModal').modal('show'));
            Livewire.on('close-edit-modal', () => $('#editProviderServiceModal').modal('hide'));
            Livewire.on('open-delete-modal', () => $('#deleteProviderServiceModal').modal('show'));
            Livewire.on('close-delete-modal', () => $('#deleteProviderServiceModal').modal('hide'));
        });
    </script>
</div>