<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\ProviderAvailability;

new #[Layout('layouts::provider')] #[Title('My Availability')] class extends Component
{
    public $availabilities;

    public $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public $availableDays = [];

    public $day = '';
    public $start_time = '';
    public $end_time = '';
    public $editingId = null;
    public $confirmingDeleteId = null;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $providerId = auth()->id();

        $this->availabilities = ProviderAvailability::where('provider_id', $providerId)
            ->orderByRaw("FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->get();

        $alreadySetDays = $this->availabilities->pluck('day')->toArray();
        $this->availableDays = array_values(array_diff($this->days, $alreadySetDays));
    }

    public function resetForm()
    {
        $this->reset(['day', 'start_time', 'end_time', 'editingId']);
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->dispatch('open-add-modal');
    }

    public function store()
    {
        $validated = $this->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $validated['provider_id'] = auth()->id();
        $validated['status'] = 'active';

        ProviderAvailability::create($validated);

        $this->loadData();
        session()->flash('message', 'Availability added successfully.');
        $this->dispatch('close-add-modal');
    }

    public function edit($id)
    {
        $availability = ProviderAvailability::where('provider_id', auth()->id())->findOrFail($id);
        $this->editingId = $availability->id;
        $this->day = $availability->day;
        $this->start_time = $availability->start_time;
        $this->end_time = $availability->end_time;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $validated = $this->validate([
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        ProviderAvailability::where('provider_id', auth()->id())
            ->findOrFail($this->editingId)
            ->update($validated);

        $this->loadData();
        session()->flash('message', 'Availability updated successfully.');
        $this->dispatch('close-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function delete()
    {
        ProviderAvailability::where('provider_id', auth()->id())
            ->findOrFail($this->confirmingDeleteId)
            ->delete();

        $this->loadData();
        session()->flash('message', 'Availability removed successfully.');
        $this->dispatch('close-delete-modal');
    }
}; ?>

<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">My Availability</h3>
        <button class="btn btn-primary" wire:click="openAddModal" @if(count($availableDays) === 0) disabled @endif>
            <i class="fa fa-plus mr-1"></i> Add Day
        </button>
    </div>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if (count($availableDays) === 0 && count($availabilities) > 0)
        <div class="alert alert-info">You've set availability for all 7 days.</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($availabilities as $availability)
                            <tr>
                                <td>{{ $availability->day }}</td>
                                <td>{{ \Carbon\Carbon::parse($availability->start_time)->format('g:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($availability->end_time)->format('g:i A') }}</td>
                                <td>
                                    <span class="badge {{ $availability->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($availability->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="edit({{ $availability->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $availability->id }})">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">You haven't set your availability yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ADD MODAL --}}
    <div wire:ignore.self class="modal fade" id="addAvailabilityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Availability</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Day</label>
                        <select class="form-control" wire:model="day">
                            <option value="">-- Select Day --</option>
                            @foreach ($availableDays as $d)
                                <option value="{{ $d }}">{{ $d }}</option>
                            @endforeach
                        </select>
                        @error('day') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" class="form-control" wire:model="start_time">
                        @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" class="form-control" wire:model="end_time">
                        @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" wire:click="store">Add</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div wire:ignore.self class="modal fade" id="editAvailabilityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit {{ $day }} Hours</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" class="form-control" wire:model="start_time">
                        @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" class="form-control" wire:model="end_time">
                        @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
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
    <div wire:ignore.self class="modal fade" id="deleteAvailabilityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove Availability</h5>
                </div>
                <div class="modal-body">
                    Remove this day from your schedule?
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
            Livewire.on('open-add-modal', () => $('#addAvailabilityModal').modal('show'));
            Livewire.on('close-add-modal', () => $('#addAvailabilityModal').modal('hide'));
            Livewire.on('open-edit-modal', () => $('#editAvailabilityModal').modal('show'));
            Livewire.on('close-edit-modal', () => $('#editAvailabilityModal').modal('hide'));
            Livewire.on('open-delete-modal', () => $('#deleteAvailabilityModal').modal('show'));
            Livewire.on('close-delete-modal', () => $('#deleteAvailabilityModal').modal('hide'));
        });
    </script>
</div>