<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
      <h1 class="sitename">Home Services</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ url('/') }}" class="active">Home<br></a></li>
         <a href="{{ route('customer.services') }}">Services</a>
      <li><a href="{{ route('customer.providers') }}">Providers</a></li>
        <li><a href="#">Pricing</a></li>
      <li><a href="{{ route('customer.contact') }}">Contact</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    @auth
      @php
        $userRole = strtolower(trim(auth()->user()->role));
      @endphp
      @if(in_array($userRole, ['admin', 'administrator', 'superadmin']))
        <a class="btn-getstarted" href="{{ route('admin.dashboard') }}">Dashboard</a>
      @elseif($userRole === 'provider')
        <a class="btn-getstarted" href="{{ route('provider.dashboard') }}">Dashboard</a>
      @else
        <div class="d-flex gap-2">
          <a class="btn-getstarted" href="{{ route('customer.book-service') }}">Book Now</a>
          <a class="btn-getstarted" href="{{ route('customer.my-bookings') }}">My Bookings</a>
        </div>
      @endif
    @else
      <a class="btn-getstarted" href="{{ route('login') }}">Get Started</a>
    @endauth

  </div>
</header>