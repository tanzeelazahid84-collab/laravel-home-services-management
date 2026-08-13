<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Subcategory;
use App\Models\ContactQuery;
use App\Models\ServiceArea;
use App\Models\Booking;

new #[Layout('layouts::admin')] #[Title('Dashboard')] class extends Component {
    public $totalUsers = 0;
    public $totalServices = 0;
    public $totalCategories = 0;
    public $totalSubcategories = 0;
    public $totalcontact = 0;
    public $totalServicesarea = 0;
    public $totalbooking = 0;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->totalServices = Service::count();
        $this->totalCategories = ServiceCategory::count();
        $this->totalSubcategories = Subcategory::count();
       $this->totalcontact = ContactQuery::count();
        $this->totalServicesarea = ServiceArea::count();
        $this->totalbooking = Booking::count();
    }
}; ?>

<div>
    <div class="page-header mb-4">
        <h3 class="page-title">Dashboard</h3>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fa fa-user mb-2"></i>
                    <h5>Users</h5>
                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                    <a class="small" href="{{ route('admin.users') }}">Manage users</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-list mb-2"></i>
                    <h5>Categories</h5>
                    <h2 class="mb-0">{{ $totalCategories }}</h2>
                    <a class="small" href="{{ route('admin.categories') }}">View categories</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-sitemap mb-2"></i>
                    <h5>Subcategories</h5>
                    <h2 class="mb-0">{{ $totalSubcategories }}</h2>
                    <a class="small" href="{{ route('admin.subcategories') }}">View subcategories</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-concierge-bell mb-2"></i>
                    <h5>Services</h5>
                    <h2 class="mb-0">{{ $totalServices }}</h2>
                    <a class="small" href="{{ route('admin.services') }}">View services</a>
                </div>
            </div>
        </div>
    </div>
    <!-- second row  -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fa fa-user mb-2"></i>
                    <h5>Contact</h5>
                    <h2 class="mb-0">{{ $totalcontact }}</h2>
                    <a class="small" href="{{ route('admin.contact-queries') }}">View contact queries</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-list mb-2"></i>
                    <h5>Services Area</h5>
                    <h2 class="mb-0">{{ $totalServicesarea }}</h2>
                    <a class="small" href="{{ route('admin.service-areas') }}">View service areas</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="icon-lg fas fa-sitemap mb-2"></i>
                    <h5>Manage Booking</h5>
                    <h2 class="mb-0">{{ $totalbooking }}</h2>
                    <a class="small" href="{{ route('admin.bookings') }}">View bookings</a>
                </div>
            </div>
        </div>
    </div>
</div>