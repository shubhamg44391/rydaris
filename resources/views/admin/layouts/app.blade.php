<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed" dir="ltr"
  data-theme="theme-default" data-assets-path="{{ asset('assets/admin/')}}"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Edion Admin Dashboard</title>

  {{-- <title>Admin Dashboard</title> --}}

  <meta name="description" content="" />

  <!-- Favicon -->
  <link class="favicon" rel="icon" type="image/png" href="{{ asset('assets/logo/favicon.png') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/boxicons.css')}}">

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/core.css')}}"
    class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/theme-default.css')}}"
    class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/apex-charts/apex-charts.css')}}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="{{ asset('assets/styles.css') }}?v={{ time() }}" />

  <style>
    /* Force Premium Glassmorphism SweetAlert2 Redesign */
    body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) { background-color: rgba(5, 7, 17, 0.4) !important; backdrop-filter: blur(8px) !important; }
    div.swal2-container.swal2-backdrop-show { background: transparent !important; }
    div.swal2-popup { background: rgba(11, 16, 32, 0.95) !important; backdrop-filter: blur(16px) !important; border: 1px solid rgba(82, 234, 210, 0.25) !important; border-radius: 16px !important; color: #f8fafc !important; box-shadow: 0 0 40px rgba(82, 234, 210, 0.1), 0 24px 80px rgba(0, 0, 0, 0.5) !important; padding: 2.5em 2em !important; }
    div.swal2-title { color: #f8fafc !important; font-size: 1.5rem !important; font-weight: 700 !important; letter-spacing: -0.02em !important; margin-bottom: 0.5em !important; }
    div.swal2-html-container { color: #a8b3c5 !important; font-size: 1.05rem !important; line-height: 1.6 !important; }
    .swal2-icon.swal2-success { border-color: rgba(82, 234, 210, 0.5) !important; color: #52ead2 !important; box-shadow: 0 0 20px rgba(82, 234, 210, 0.1) !important; }
    .swal2-icon.swal2-success .swal2-success-ring { border-color: rgba(82, 234, 210, 0.4) !important; }
    .swal2-icon.swal2-success [class^=swal2-success-line] { background-color: #52ead2 !important; }
    .swal2-actions { margin-top: 2em !important; gap: 12px !important; }
    .swal2-confirm, .swal2-styled.swal2-confirm { background: linear-gradient(135deg, #52ead2, #2bc2a8) !important; color: #050711 !important; font-weight: 600 !important; border-radius: 8px !important; padding: 12px 28px !important; border: none !important; box-shadow: 0 8px 16px rgba(82, 234, 210, 0.2) !important; transition: all 0.3s ease !important; }
  </style>


  <!-- Helpers -->
  <script src="{{ asset('assets/admin/vendor/js/helpers.js')}}"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="{{ asset('assets/admin/js/config.js')}}"></script>
  <style>
    canvas {
      border: 1px dotted red;
    }

    .chart-container {
      position: relative;
      margin: auto;
      height: 80vh;
      width: 80vw;
    }
    
    /* Enforce Dark Theme on Sneat Layout elements */
    body, html, .layout-wrapper, .layout-container, .layout-page, .content-wrapper {
      background-color: var(--bg) !important;
      color: var(--text) !important;
    }
  </style>
</head>

<body class="admin-body">
  <div class="admin-shell">
    <aside class="admin-sidebar" aria-label="Admin navigation">
      <a class="brand" href="{{ route('home') }}" aria-label="Rydaris home" style="opacity: 0.9; transition: opacity 0.2s ease;">
        <img src="{{ asset('assets/logo/rydaris-logo.png') }}" alt="Rydaris Logo" style="height: 32px; width: auto; display: block;">
      </a>

      @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin'))
          @include('admin.layouts.sidebar')
      @else
          @include('vendor.layouts.sidebar')
      @endif
    </aside>

    <main class="admin-main" style="display: flex; flex-direction: column; min-height: 100vh;">
      <header class="admin-topbar">
        <div></div>
        <div class="admin-toolbar" style="display: flex; align-items: center; gap: 15px;">
          <span class="user-greeting" style="font-weight: 500;">Hello, {{ Auth::user()->name }}</span>
          
          @if(Auth::check() && Auth::user()->role === 'vendor')
          <a href="{{ route('vendor.profile.index') }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
            <svg viewBox="0 0 24 24" style="width:20px; height:20px; fill:none; stroke:currentColor; stroke-width:2;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </a>
          @endif
          
          <form method="POST" action="{{ route('logout') }}" style="margin: 0; display: inline;">
              @csrf
              <button type="submit" class="admin-action" style="cursor: pointer; border: none; background: transparent; font-family: inherit; font-size: inherit; display: flex; align-items: center; gap: 5px;">
                <svg viewBox="0 0 24 24" style="width:18px; height:18px; fill:none; stroke:currentColor; stroke-width:2;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg> Logout
              </button>
          </form>
        </div>
      </header>

      <div class="admin-content" style="flex: 1; padding: 24px;">
        @yield('main-content')
      </div>
      
      <!-- Footer -->
      <!-- <footer class="content-footer footer" style="padding: 20px 24px; border-top: 1px solid rgba(0,0,0,0.05); color: #64748b; font-size: 0.9rem; background: #ffffff;">
        <div>
          © <script>document.write(new Date().getFullYear());</script>, made with ❤️ by Edion Web Technologies
        </div>
      </footer> -->
    </main>
  </div>



  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.js"></script>
  <script src="{{ asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
  <script src="{{ asset('assets/admin/vendor/libs/popper/popper.js')}}"></script>
  <script src="{{ asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
  <script src="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

  <script src="{{ asset('assets/admin/vendor/js/menu.js')}}"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{ asset('assets/admin/vendor/libs/apex-charts/apexcharts.js')}}"></script>

  <!-- Main JS -->
  <script src="{{ asset('assets/admin/js/main.js')}}"></script>

  <!-- Page JS -->
  <script src="{{ asset('assets/admin/js/dashboards-analytics.js')}}"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  @yield('js')

  @if(session('success'))
  <script>
      Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: '{{ session('success') }}',
          confirmButtonText: 'OK'
      });
  </script>
  @endif

  @if(session('error'))
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: '{{ session('error') }}',
          confirmButtonText: 'OK'
      });
  </script>
  @endif
</body>

</html>
