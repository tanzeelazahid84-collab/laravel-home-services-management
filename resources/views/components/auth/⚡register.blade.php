<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

new #[Layout('layouts::auth')]
#[Title('Register')]
class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'customer';
    public string $phone = '';
    public string $city = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:customer,provider',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
        ]);

        auth()->login($user);

        return redirect('/');
    }
}; ?>

<div>
    <div class="brand-logo">
        <img src="{{ asset('admin/images/logo.svg') }}" alt="logo">
    </div>
    <h4>New here?</h4>
    <h6 class="font-weight-light">Signing up is easy. It only takes a few steps.</h6>

    <form class="pt-3" wire:submit="register">
        <div class="form-group">
            <input type="text" class="form-control form-control-lg" wire:model="name" placeholder="Name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input type="email" class="form-control form-control-lg" wire:model="email" placeholder="Email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-lg" wire:model="password" placeholder="Password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-lg" wire:model="password_confirmation" placeholder="Confirm password">
        </div>

        <div class="form-group">
            <select class="form-control form-control-lg" wire:model="role">
                <option value="customer">Customer</option>
                <option value="provider">Service Provider</option>
            </select>
        </div>

        <div class="form-group">
            <input type="text" class="form-control form-control-lg" wire:model="phone" placeholder="Phone">
        </div>

        <div class="form-group">
            <input type="text" class="form-control form-control-lg" wire:model="city" placeholder="City">
        </div>

        <div class="mt-3">
            <button type="submit" class="auth-form-btn btn btn-block btn-primary btn-lg">SIGN up</button>
        </div>
        <div class="text-center mt-4 font-weight-light">
            Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
        </div>
    </form>
</div>
