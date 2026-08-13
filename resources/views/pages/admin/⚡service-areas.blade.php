<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\ServiceArea;

new #[Layout('layouts::admin')] #[Title('Manage Service Areas')] class extends Component
{
    public $serviceAreas;

    public $editingId = null;
    public $city_name = '';
    public $state = '';
    public $zipcode = '';
    public $status = 'active';
    public $confirmingDeleteId = null;

    public function mount()
    {
        $this->serviceAreas = ServiceArea::latest()->get();
    }

    public function resetForm()
    {
        $this->reset(['editingId', 'city_name', 'state', 'zipcode']);
        $this->status = 'active';
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->dispatch('open-add-modal');
    }

    public function store()
    {
        $validated = $this->validate([
            'city_name' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        ServiceArea::create($validated);

        $this->serviceAreas = ServiceArea::latest()->get();
        session()->flash('message', 'Service area added successfully.');
        $this->dispatch('close-add-modal');
    }

    public function edit($id)
    {
        $area = ServiceArea::findOrFail($id);
        $this->editingId = $area->id;
        $this->city_name = $area->city_name;
        $this->state = $area->state;
        $this->zipcode = $area->zipcode;
        $this->status = $area->status;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $validated = $this->validate([
            'city_name' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        ServiceArea::findOrFail($this->editingId)->update($validated);

        $this->serviceAreas = ServiceArea::latest()->get();
        session()->flash('message', 'Service area updated successfully.');
        $this->dispatch('close-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function delete()
    {
        ServiceArea::findOrFail($this->confirmingDeleteId)->delete();
        $this->serviceAreas = ServiceArea::latest()->get();
        session()->flash('message', 'Service area deleted successfully.');
        $this->dispatch('close-delete-modal');
    }
}; ?>

<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">Manage Service Areas</h3>
        <button class="btn btn-primary" wire:click="openAddModal">
            <i class="fa fa-plus mr-1"></i> Add Service Area
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
                            <th>City</th>
                            <th>State</th>
                            <th>Zipcode</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($serviceAreas as $area)
                            <tr>
                                <td>{{ $area->city_name }}</td>
                                <td>{{ $area->state }}</td>
                                <td>{{ $area->zipcode }}</td>
                                <td>
                                    <span class="badge {{ $area->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($area->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="edit({{ $area->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $area->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ADD MODAL --}}
    <div wire:ignore.self class="modal fade" id="addAreaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Service Area</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>City Name</label>
                        <input type="text" class="form-control" wire:model="city_name">
                        @error('city_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" class="form-control" wire:model="state">
                        @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Zipcode</label>
                        <input type="text" class="form-control" wire:model="zipcode">
                        @error('zipcode') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" wire:click="store">Add Service Area</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div wire:ignore.self class="modal fade" id="editAreaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service Area</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>City Name</label>
                        <input type="text" class="form-control" wire:model="city_name">
                        @error('city_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" class="form-control" wire:model="state">
                        @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Zipcode</label>
                        <input type="text" class="form-control" wire:model="zipcode">
                        @error('zipcode') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
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
    <div wire:ignore.self class="modal fade" id="deleteAreaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Service Area</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this service area? This cannot be undone.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" wire:click="delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-add-modal', () => $('#addAreaModal').modal('show'));
            Livewire.on('close-add-modal', () => $('#addAreaModal').modal('hide'));
            Livewire.on('open-edit-modal', () => $('#editAreaModal').modal('show'));
            Livewire.on('close-edit-modal', () => $('#editAreaModal').modal('hide'));
            Livewire.on('open-delete-modal', () => $('#deleteAreaModal').modal('show'));
            Livewire.on('close-delete-modal', () => $('#deleteAreaModal').modal('hide'));
        });
    </script>
</div>