<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Subcategory;

new #[Layout('layouts::admin')] #[Title('Manage Services')] class extends Component
{
    use WithFileUploads;

    public $services;
    public $categories;
    public $subcategories = [];

    public $editingId = null;
    public $category_id = '';
    public $subcategory_id = '';
    public $service_name = '';
    public $description = '';
    public $price = '';
    public $duration = '';
    public $status = 'active';
    public $image;
    public $existingImage = null;
    public $confirmingDeleteId = null;

   public function mount()
{
    $this->services = Service::with(['category', 'subcategory'])->latest()->get();
    $this->categories = ServiceCategory::where('status', 'active')->get();
}

    // Runs automatically whenever category_id changes in the form
public function updatedCategoryId($value)
{
    $this->subcategories = Subcategory::where('category_id', $value)
        ->where('status', 'active')
        ->get();

    $this->subcategory_id = '';
}
    public function resetForm()
    {
        $this->reset(['editingId', 'category_id', 'subcategory_id', 'service_name', 'description', 'price', 'duration', 'image', 'existingImage']);
        $this->subcategories = [];
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
            'category_id' => 'required|exists:service_categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $baseSlug = Str::slug($validated['service_name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Service::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        if ($this->image) {
            $validated['image'] = $this->image->store('services', 'public');
        } else {
            unset($validated['image']);
        }

        Service::create($validated);

        $this->services = Service::with(['category', 'subcategory'])->latest()->get();
        session()->flash('message', 'Service added successfully.');
        $this->dispatch('close-add-modal');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->editingId = $service->id;
        $this->category_id = $service->category_id;
        $this->subcategories = Subcategory::where('category_id', $service->category_id)->get();
        $this->subcategory_id = $service->subcategory_id;
        $this->service_name = $service->service_name;
        $this->description = $service->description;
        $this->price = $service->price;
        $this->duration = $service->duration;
        $this->status = $service->status;
        $this->existingImage = $service->image;
        $this->image = null;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $validated = $this->validate([
            'category_id' => 'required|exists:service_categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $baseSlug = Str::slug($validated['service_name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Service::where('slug', $slug)->where('id', '!=', $this->editingId)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        if ($this->image) {
            $validated['image'] = $this->image->store('services', 'public');
        } else {
            unset($validated['image']);
        }

        Service::findOrFail($this->editingId)->update($validated);

        $this->services = Service::with(['category', 'subcategory'])->latest()->get();
        session()->flash('message', 'Service updated successfully.');
        $this->dispatch('close-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function delete()
    {
        Service::findOrFail($this->confirmingDeleteId)->delete();
        $this->services = Service::with(['category', 'subcategory'])->latest()->get();
        session()->flash('message', 'Service deleted successfully.');
        $this->dispatch('close-delete-modal');
    }
}; ?>

<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">Manage Services</h3>
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
                            <th>Image</th>
                            <th>Service Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>
                                    @if ($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" width="50" height="50" style="object-fit: cover; border-radius: 6px;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $service->service_name }}</td>
                                <td>{{ $service->category->category_name ?? '—' }}</td>
                                <td>{{ $service->subcategory->subcategory_name ?? '—' }}</td>
                                <td>Rs. {{ number_format($service->price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $service->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="edit({{ $service->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $service->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ADD MODAL --}}
    <div wire:ignore.self class="modal fade" id="addServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Service</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" wire:model.live ="category_id">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                   <div class="form-group">
    <label>Subcategory</label>
    <select class="form-control" wire:model="subcategory_id">
        <option value="">-- Select Subcategory --</option>
        @foreach ($subcategories as $sub)
            <option value="{{ $sub->id }}">{{ $sub->subcategory_name }}</option>
        @endforeach
    </select>
    @error('subcategory_id') <span class="text-danger">{{ $message }}</span> @enderror
</div>
                    <div class="form-group">
                        <label>Service Name</label>
                        <input type="text" class="form-control" wire:model="service_name">
                        @error('service_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" wire:model="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" class="form-control" wire:model="price">
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Duration</label>
                        <input type="text" class="form-control" wire:model="duration" placeholder="e.g. 1-2 hours">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" wire:model="image">
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" width="80" class="mt-2 rounded">
                        @endif
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
                    <button class="btn btn-primary" wire:click="store">Add Service</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div wire:ignore.self class="modal fade" id="editServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" wire:model.live ="category_id">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Subcategory</label>
                        <select class="form-control" wire:model="subcategory_id">
                            <option value="">-- Select Subcategory --</option>
                            @foreach ($subcategories as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->subcategory_name }}</option>
                            @endforeach
                        </select>
                        @error('subcategory_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Service Name</label>
                        <input type="text" class="form-control" wire:model="service_name">
                        @error('service_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" wire:model="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" class="form-control" wire:model="price">
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Duration</label>
                        <input type="text" class="form-control" wire:model="duration" placeholder="e.g. 1-2 hours">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        @if ($existingImage && !$image)
                            <div class="mb-2"><img src="{{ asset('storage/' . $existingImage) }}" width="80" class="rounded"></div>
                        @endif
                        <input type="file" class="form-control" wire:model="image">
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" width="80" class="mt-2 rounded">
                        @endif
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
    <div wire:ignore.self class="modal fade" id="deleteServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Service</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this service? This cannot be undone.
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
            Livewire.on('open-add-modal', () => $('#addServiceModal').modal('show'));
            Livewire.on('close-add-modal', () => $('#addServiceModal').modal('hide'));
            Livewire.on('open-edit-modal', () => $('#editServiceModal').modal('show'));
            Livewire.on('close-edit-modal', () => $('#editServiceModal').modal('hide'));
            Livewire.on('open-delete-modal', () => $('#deleteServiceModal').modal('show'));
            Livewire.on('close-delete-modal', () => $('#deleteServiceModal').modal('hide'));
        });
    </script>
</div>