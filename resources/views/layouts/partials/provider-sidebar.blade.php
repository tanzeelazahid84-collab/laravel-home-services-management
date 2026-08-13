<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="profile-name">
          <p class="name">{{ auth()->user()->name }}</p>
          <p class="designation">Service Provider</p>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('provider.dashboard') }}">
        <i class="fa fa-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('provider.services') }}">
        <i class="fas fa-concierge-bell menu-icon"></i>
        <span class="menu-title">My Services</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('provider.availability') }}">
        <i class="fas fa-calendar-alt menu-icon"></i>
        <span class="menu-title">Availability</span>
      </a>
      <li class="nav-item">
    <a class="nav-link" href="{{ route('provider.bookings') }}">
        <i class="fas fa-calendar-check menu-icon"></i>
        <span class="menu-title">My Bookings</span>
    </a>
</li>
  </ul>
</nav>