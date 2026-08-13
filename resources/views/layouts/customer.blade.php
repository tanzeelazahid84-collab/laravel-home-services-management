<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Home Services' }}</title>
  <link href="{{ asset('customer/assets/img/favicon.png') }}" rel="icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="{{ asset('customer/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('customer/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('customer/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('customer/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('customer/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('customer/assets/css/main.css') }}" rel="stylesheet">
  @livewireStyles
</head>
<body class="index-page">

  @include('layouts.partials.customer-header')

  <main class="main">
    {{ $slot }}
  </main>

  @include('layouts.partials.customer-footer')

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{ asset('customer/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('customer/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('customer/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('customer/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('customer/assets/js/main.js') }}"></script>
  @livewireScripts
</body>
</html>