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
  <link rel="stylesheet" href="{{ asset('assets/styles.css') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/apex-charts/apex-charts.css')}}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.css">
  <!-- Page CSS -->

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
          <span class="user-greeting" style="font-weight: 500; color: #64748b;">Hello, {{ Auth::user()->name }}</span>
          
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
</body>

</html>
