<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

new #[Layout('layouts::admin')] #[Title('Manage Users')] class extends Component
{
    public $users;

    // Shared fields (used by both add and edit forms)
    public $editingUserId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'customer';
    public $phone = '';
    public $address = '';
    public $city = '';
    public $status = 'active';
    public $confirmingDeleteId = null;

    public function mount()
    {
        $this->users = User::latest()->get();
    }

    public function resetForm()
    {
        $this->reset(['editingUserId', 'name', 'email', 'password', 'phone', 'address', 'city']);
        $this->role = 'customer';
        $this->status = 'active';
    }

    // ---- ADD ----
    public function openAddModal()
    {
        $this->resetForm();
        $this->dispatch('open-add-modal');
    }

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,provider,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'status' => 'required|in:active,suspended',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        $this->users = User::latest()->get();
        session()->flash('message', 'User added successfully.');
        $this->dispatch('close-add-modal');
    }

    // ---- EDIT ----
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->city = $user->city;
        $this->status = $user->status ?? 'active';

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editingUserId,
            'role' => 'required|in:admin,provider,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'status' => 'required|in:active,suspended',
        ]);

        User::findOrFail($this->editingUserId)->update($validated);

        $this->users = User::latest()->get();
        session()->flash('message', 'User updated successfully.');
        $this->dispatch('close-edit-modal');
    }

    // ---- DELETE ----
    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function delete()
    {
        User::findOrFail($this->confirmingDeleteId)->delete();
        $this->users = User::latest()->get();
        session()->flash('message', 'User deleted successfully.');
        $this->dispatch('close-delete-modal');
    }
}; ?>

<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">Manage Users</h3>
        <button class="btn btn-primary" wire:click="openAddModal">
            <i class="fa fa-plus mr-1"></i> Add User
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($user->role) }}</span></td>
                                <td>{{ $user->phone ?? '—' }}</td>
                                <td>{{ $user->address ?? '—' }}</td>
                                <td>{{ $user->city ?? '—' }}</td>
                                <td>{{ $user->status ? ucfirst($user->status) : '—' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="edit({{ $user->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $user->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ADD USER MODAL --}}
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" wire:model="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" wire:model="email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" wire:model="password">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" wire:model="role">
                            <option value="admin">Admin</option>
                            <option value="provider">Service Provider</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" wire:model="phone">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" wire:model="address">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" wire:model="city">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" wire:click="store">Add User</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT USER MODAL --}}
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" wire:model="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" wire:model="email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" wire:model="role">
                            <option value="admin">Admin</option>
                            <option value="provider">Service Provider</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" wire:model="phone">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" wire:model="address">
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" wire:model="city">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
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

    {{-- DELETE USER MODAL --}}
    <div class="modal fade" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user? This cannot be undone.
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
            Livewire.on('open-add-modal', () => {
                $('#addUserModal').modal('show');
            });
            Livewire.on('close-add-modal', () => {
                $('#addUserModal').modal('hide');
            });
            Livewire.on('open-edit-modal', () => {
                $('#editUserModal').modal('show');
            });
            Livewire.on('close-edit-modal', () => {
                $('#editUserModal').modal('hide');
            });
            Livewire.on('open-delete-modal', () => {
                $('#deleteUserModal').modal('show');
            });
            Livewire.on('close-delete-modal', () => {
                $('#deleteUserModal').modal('hide');
            });
        });
    </script>
</div>