<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="profile-image">
          <img src="{{ asset('admin/images/faces/face5.jpg') }}" alt="profile">
        </div>
        <div class="profile-name">
          <p class="name">{{ auth()->user()->name }}</p>
          <p class="designation">Administrator</p>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fa fa-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ Route::has('admin.users') ? route('admin.users') : url('/admin/users') }}">
        <i class="fas fa-users menu-icon"></i>
        <span class="menu-title">Manage Users</span>
      </a>
    </li>
    <li class="nav-item">
  <a class="nav-link" href="{{ route('admin.categories') }}">
    <i class="fas fa-list menu-icon"></i>
    <span class="menu-title">Categories</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.subcategories') }}">
    <i class="fas fa-sitemap menu-icon"></i>
    <span class="menu-title">Subcategories</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.service-areas') }}">
    <i class="fas fa-map-marker-alt menu-icon"></i>
    <span class="menu-title">Service Areas</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.services') }}">
    <i class="fas fa-concierge-bell menu-icon"></i>
    <span class="menu-title">Services</span>
  </a>
</li>
   <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.bookings') }}">
        <i class="fas fa-calendar-check menu-icon"></i>
        <span class="menu-title">Manage Bookings</span>
    </a>
</li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.contact-queries') }}">
            <i class="fas fa-envelope menu-icon"></i>
            <span class="menu-title">Contact Messages</span>
          </a>
        </li>
  </ul>
</nav>
