<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ $title ?? 'Admin Dashboard' }} - Home Services</title>
  <link rel="stylesheet" href="{{ asset('admin/vendors/iconfonts/font-awesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/vendors/iconfonts/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.addons.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}">
  @livewireStyles
</head>
<body>
  <div class="container-scroller">
    @include('layouts.partials.navbar')

    <div class="container-fluid page-body-wrapper">
      @include('layouts.partials.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          {{ $slot }}
        </div>

        @include('layouts.partials.footer')
      </div>
    </div>
  </div>

  <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('admin/vendors/js/vendor.bundle.addons.js') }}"></script>
  <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
  <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('admin/js/misc.js') }}"></script>
  <script src="{{ asset('admin/js/settings.js') }}"></script>
  @livewireScripts
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const replyModalEl = document.getElementById('replyModal');
      let replyModal = null;
      if (replyModalEl && typeof bootstrap !== 'undefined') {
        replyModal = new bootstrap.Modal(replyModalEl);
      }

      window.addEventListener('open-reply-modal', () => { replyModal?.show(); });
      window.addEventListener('close-reply-modal', () => { replyModal?.hide(); });
    });
  </script>
</body>
</html>
