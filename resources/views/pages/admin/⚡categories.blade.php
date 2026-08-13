<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\ServiceCategory;

new #[Layout('layouts::admin')] #[Title('Manage Categories')] class extends Component
{
    use WithFileUploads;

    public $categories;

    public $editingId = null;
    public $category_name = '';
    public $description = '';
    public $status = 'active';
    public $image;
    public $existingImage = null;
    public $confirmingDeleteId = null;

    public function mount()
    {
        $this->categories = ServiceCategory::latest()->get();
    }

    public function resetForm()
    {
        $this->reset(['editingId', 'category_name', 'description', 'image', 'existingImage']);
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
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
           'image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['category_name']);

      if ($this->image) {
    $validated['image'] = $this->image->store('categories', 'public');
} else {
    unset($validated['image']);
}

        ServiceCategory::create($validated);

        $this->categories = ServiceCategory::latest()->get();
        session()->flash('message', 'Category added successfully.');
        $this->dispatch('close-add-modal');
    }

    public function edit($id)
    {
        $category = ServiceCategory::findOrFail($id);
        $this->editingId = $category->id;
        $this->category_name = $category->category_name;
        $this->description = $category->description;
        $this->status = $category->status;
        $this->existingImage = $category->image;
        $this->image = null;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $validated = $this->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['category_name']);

       if ($this->image) {
    $validated['image'] = $this->image->store('categories', 'public');
} else {
    unset($validated['image']);
}

        ServiceCategory::findOrFail($this->editingId)->update($validated);

        $this->categories = ServiceCategory::latest()->get();
        session()->flash('message', 'Category updated successfully.');
        $this->dispatch('close-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function delete()
    {
        ServiceCategory::findOrFail($this->confirmingDeleteId)->delete();
        $this->categories = ServiceCategory::latest()->get();
        session()->flash('message', 'Category deleted successfully.');
        $this->dispatch('close-delete-modal');
    }
}; ?>

<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">Manage Categories</h3>
        <button class="btn btn-primary" wire:click="openAddModal">
            <i class="fa fa-plus mr-1"></i> Add Category
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
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" width="50" height="50" style="object-fit: cover; border-radius: 6px;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ Str::limit($category->description, 50) ?: '—' }}</td>
                                <td>
                                    <span class="badge {{ $category->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($category->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="edit({{ $category->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $category->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ADD MODAL --}}
   <div wire:ignore.self class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" wire:model="category_name">
                        @error('category_name') <span class="text-danger">{{ $message }}</span> @enderror
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
                    <button class="btn btn-primary" wire:click="store">Add Category</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
  <div wire:ignore.self class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" wire:model="category_name">
                        @error('category_name') <span class="text-danger">{{ $message }}</span> @enderror
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
  <div wire:ignore.self class="modal fade" id="deleteCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category? This cannot be undone.
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
            Livewire.on('open-add-modal', () => $('#addCategoryModal').modal('show'));
            Livewire.on('close-add-modal', () => $('#addCategoryModal').modal('hide'));
            Livewire.on('open-edit-modal', () => $('#editCategoryModal').modal('show'));
            Livewire.on('close-edit-modal', () => $('#editCategoryModal').modal('hide'));
            Livewire.on('open-delete-modal', () => $('#deleteCategoryModal').modal('show'));
            Livewire.on('close-delete-modal', () => $('#deleteCategoryModal').modal('hide'));
        });
    </script>
</div>