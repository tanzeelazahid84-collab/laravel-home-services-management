<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use App\Models\ServiceCategory;

new #[Layout('layouts::admin')] #[Title('Manage Subcategories')] class extends Component
{
    use WithFileUploads;

    public $subcategories;
    public $categories;

    public $editingId = null;
    public $category_id = '';
    public $subcategory_name = '';
    public $description = '';
    public $status = 'active';
    public $image;
    public $existingImage = null;
    public $confirmingDeleteId = null;

    public function mount()
    {
        $this->subcategories = Subcategory::with('category')->latest()->get();
        $this->categories = ServiceCategory::where('status', 'active')->get();
    }

    public function resetForm()
    {
        $this->reset(['editingId', 'category_id', 'subcategory_name', 'description', 'image', 'existingImage']);
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
            'subcategory_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['subcategory_name']);

        if ($this->image) {
            $validated['image'] = $this->image->store('subcategories', 'public');
        } else {
            unset($validated['image']);
        }

        Subcategory::create($validated);

        $this->subcategories = Subcategory::with('category')->latest()->get();
        session()->flash('message', 'Subcategory added successfully.');
        $this->dispatch('close-add-modal');
    }

    public function edit($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $this->editingId = $subcategory->id;
        $this->category_id = $subcategory->category_id;
        $this->subcategory_name = $subcategory->subcategory_name;
        $this->description = $subcategory->description;
        $this->status = $subcategory->status;
        $this->existingImage = $subcategory->image;
        $this->image = null;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $validated = $this->validate([
            'category_id' => 'required|exists:service_categories,id',
            'subcategory_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['subcategory_name']);

        if ($this->image) {
            $validated['image'] = $this->image->store('subcategories', 'public');
        } else {
            unset($validated['image']);
        }

        Subcategory::findOrFail($this->editingId)->update($validated);

        $this->subcategories = Subcategory::with('category')->latest()->get();
        session()->flash('message', 'Subcategory updated successfully.');
        $this->dispatch('close-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function delete()
    {
        Subcategory::findOrFail($this->confirmingDeleteId)->delete();
        $this->subcategories = Subcategory::with('category')->latest()->get();
        session()->flash('message', 'Subcategory deleted successfully.');
        $this->dispatch('close-delete-modal');
    }
}; ?>

<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">Manage Subcategories</h3>
        <button class="btn btn-primary" wire:click="openAddModal">
            <i class="fa fa-plus mr-1"></i> Add Subcategory
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
                            <th>Subcategory Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subcategories as $subcategory)
                            <tr>
                                <td>
                                    @if ($subcategory->image)
                                        <img src="{{ asset('storage/' . $subcategory->image) }}" width="50" height="50" style="object-fit: cover; border-radius: 6px;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $subcategory->subcategory_name }}</td>
                                <td>{{ $subcategory->category->category_name ?? '—' }}</td>
                                <td>{{ Str::limit($subcategory->description, 50) ?: '—' }}</td>
                                <td>
                                    <span class="badge {{ $subcategory->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($subcategory->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="edit({{ $subcategory->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $subcategory->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ADD MODAL --}}
    <div wire:ignore.self class="modal fade" id="addSubcategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Subcategory</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" wire:model="category_id">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Subcategory Name</label>
                        <input type="text" class="form-control" wire:model="subcategory_name">
                        @error('subcategory_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" wire:model="description" rows="3"></textarea>
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
                    <button class="btn btn-primary" wire:click="store">Add Subcategory</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div wire:ignore.self class="modal fade" id="editSubcategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Subcategory</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" wire:model="category_id">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Subcategory Name</label>
                        <input type="text" class="form-control" wire:model="subcategory_name">
                        @error('subcategory_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" wire:model="description" rows="3"></textarea>
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
    <div wire:ignore.self class="modal fade" id="deleteSubcategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Subcategory</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this subcategory? This cannot be undone.
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
            Livewire.on('open-add-modal', () => $('#addSubcategoryModal').modal('show'));
            Livewire.on('close-add-modal', () => $('#addSubcategoryModal').modal('hide'));
            Livewire.on('open-edit-modal', () => $('#editSubcategoryModal').modal('show'));
            Livewire.on('close-edit-modal', () => $('#editSubcategoryModal').modal('hide'));
            Livewire.on('open-delete-modal', () => $('#deleteSubcategoryModal').modal('show'));
            Livewire.on('close-delete-modal', () => $('#deleteSubcategoryModal').modal('hide'));
        });
    </script>
</div>