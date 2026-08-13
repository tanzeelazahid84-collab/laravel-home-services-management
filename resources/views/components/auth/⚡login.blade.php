<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts::auth')]
#[Title('Login')]
class extends Component
{
    public string $email = '';
    public string $password = '';

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();

            $role = strtolower(trim(Auth::user()->role));

            return match ($role) {
                'admin', 'administrator', 'superadmin' => redirect()->route('admin.dashboard'),
                'provider' => redirect()->route('provider.dashboard'),
                default => redirect()->route('customer.my-bookings'),
            };
        }

        $this->addError('email', 'These credentials do not match our records.');
    }
}; ?>

<div>
    <div class="brand-logo">
        <img src="{{ asset('admin/images/logo.svg') }}" alt="logo">
    </div>
    <h4>Welcome back!</h4>
    <h6 class="font-weight-light">Sign in to continue.</h6>

    <form class="pt-3" wire:submit="login">
        <div class="form-group">
            <input type="email" class="form-control form-control-lg" wire:model="email" placeholder="Email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control form-control-lg" wire:model="password" placeholder="Password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mt-3">
            <button type="submit" class="auth-form-btn btn btn-block btn-primary btn-lg">SIGN IN</button>
        </div>
        <div class="text-center mt-4 font-weight-light">
            Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
        </div>
    </form>
</div>
