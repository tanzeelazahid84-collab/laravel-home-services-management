<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use Livewire\Livewire;

Route::get('/', function () {
    if (auth()->check()) {
        $role = strtolower(trim(auth()->user()->role));

        return match ($role) {
            'admin', 'administrator', 'superadmin' => redirect()->route('admin.dashboard'),
            'provider' => redirect()->route('provider.dashboard'),
            default => redirect()->route('customer.dashboard'),
        };
    }

    return \Livewire\Livewire::mount('pages::customer.home')->html();
})->name('home');


Route::livewire('/admin/dashboard', 'pages::admin.dashboard')->name('admin.dashboard')->middleware(['auth', 'role:admin']);
Route::livewire('/provider/dashboard', 'pages::provider.dashboard')->name('provider.dashboard')->middleware(['auth', 'role:provider']);
Route::livewire('/customer/dashboard', 'pages::customer.dashboard')->name('customer.dashboard')->middleware(['auth', 'role:customer']);

Route::livewire('/register', 'auth.register')->name('register');
Route::livewire('/login', 'auth.login')->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::livewire('/admin/users', 'pages::admin.users')->name('admin.users')->middleware(['auth', 'role:admin']);
Route::livewire('/admin/categories', 'pages::admin.categories')->name('admin.categories')->middleware(['auth', 'role:admin']);
Route::livewire('/admin/subcategories', 'pages::admin.subcategories')->name('admin.subcategories')->middleware(['auth', 'role:admin']);
Route::livewire('/admin/service-areas', 'pages::admin.service-areas')->name('admin.service-areas')->middleware(['auth', 'role:admin']);
Route::livewire('/admin/services', 'pages::admin.services')->name('admin.services')->middleware(['auth', 'role:admin']);
Route::livewire('/provider/services', 'pages::provider.services')->name('provider.services')->middleware(['auth', 'role:provider']);
Route::livewire('/provider/availability', 'pages::provider.availability')->name('provider.availability')->middleware(['auth', 'role:provider']);

Route::livewire('/book-service', 'pages::customer.book-service')->name('customer.book-service')->middleware(['auth', 'role:customer']);
Route::livewire('/my-bookings', 'pages::customer.my-bookings')->name('customer.my-bookings')->middleware(['auth', 'role:customer']);
Route::livewire('/provider/bookings', 'pages::provider.bookings')->name('provider.bookings')->middleware(['auth', 'role:provider']);
Route::livewire('/admin/bookings', 'pages::admin.bookings')->name('admin.bookings')->middleware(['auth', 'role:admin']);
Route::livewire('/services', 'pages::customer.services')->name('customer.services');
Route::livewire('/providers', 'pages::customer.providers')->name('customer.providers');
Route::livewire('/admin/payments', 'pages::admin.payments')->name('admin.payments')->middleware(['auth', 'role:admin']);



Route::get('/payment/success/{booking}', [PaymentController::class, 'success'])->name('payment.success')->middleware('auth');
Route::livewire('/contact', 'pages::customer.contact')->name('customer.contact');
Route::livewire('/admin/contact-queries', 'pages::admin.contact-queries')->name('admin.contact-queries')->middleware(['auth', 'role:admin']);