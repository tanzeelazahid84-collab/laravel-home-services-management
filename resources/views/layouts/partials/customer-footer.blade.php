<footer id="footer" class="footer position-relative light-background">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
          <span class="sitename">Home Services</span>
        </a>
        <div class="footer-contact pt-3">
          <p>Lahore, Pakistan</p>
          <p class="mt-3"><strong>Phone:</strong> <span>+92 300 0000000</span></p>
          <p><strong>Email:</strong> <span>info@homeservices.test</span></p>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="{{ route('login') }}">Login</a></li>
          <li><a href="{{ route('register') }}">Register</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><a href="#">Cleaning</a></li>
          <li><a href="#">Plumbing</a></li>
          <li><a href="#">Electrical</a></li>
          <li><a href="#">Painting</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>© {{ date('Y') }} <strong class="px-1 sitename">Home Services</strong> All Rights Reserved</p>
  </div>

</footer>