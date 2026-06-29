<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{asset('assets/admin/')}}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Rydaris Admin Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets/admin/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/admin/vendor/css/core.css')}}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/admin/vendor/css/theme-default.css')}}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/admin/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/admin/vendor/css/pages/page-auth.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('assets/admin/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/admin/js/config.js')}}"></script>

    <style>
        .btn-primary {
            background-color: #e60000 !important;
            border-color: #e60000 !important;
        }

        .btn-primary:hover {
            background-color: #cc0000 !important;
            border-color: #cc0000 !important;
        }

        .app-brand-link:hover {
            opacity: 0.9;
        }

        .authentication-inner .card {
            border-top: 4px solid #e60000;
        }

        .app-brand-logo img {
            width: 170px !important;
            margin-bottom: 10px;
        }

        a {
            color: #e60000;
        }

        a:hover {
            color: #cc0000;
        }
    </style>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ route('home') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img class="dark-mode" width="150px"
                                        src="{{ asset('assets/logo/logo.png') }}" alt="Site Logo">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to Admin Dashboard! 👋</h4>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 text-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" class="form-control" type="email" name="email"
                                    value="{{ old('email') }}" required autofocus autocomplete="username" />
                                @error('email')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input id="password" class="form-control" type="password" name="password" required
                                        autocomplete="current-password" />
                                    @error('password')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>


                            <!-- Remember Me -->
                            <div class="form-group form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                            </div>

                            <div class="form-group mb-3">

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary d-grid w-100">
                                        {{ __('Log in') }}
                                    </button>
                                </div>

                            </div>
                        </form>

                        <p class="text-center mt-3 mb-0">
                            <span>New to Rydaris?</span>
                            <a href="{{ route('vendor.register') }}">
                                <span>Register as Vendor</span>
                            </a>
                        </p>


                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('assets/admin/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{asset('assets/admin/js/main.js')}}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
