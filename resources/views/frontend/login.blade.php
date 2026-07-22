<!DOCTYPE html>
<html lang="en" class="dark-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Customer Login - Rydaris | Car Rental Management System</title>
    <meta name="description" content="Log in to your Rydaris customer account." />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/pages/page-auth.css') }}" />

    <!-- Core Helpers -->
    <script src="{{ asset('assets/admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/admin/js/config.js') }}"></script>

    <!-- Theme Overrides for Rydaris Design System -->
    <style>
        :root {
            --brand: #52ead2;
            --brand-2: #79f3df;
            --bg-dark: #050711;
            --card-bg: #0b1020;
        }

        body {
            background-color: var(--bg-dark) !important;
            color: #f8fafc !important;
            font-family: 'Public Sans', sans-serif !important;
        }

        .authentication-wrapper.authentication-basic .authentication-inner {
            max-width: 420px !important;
        }

        .card {
            background-color: var(--card-bg) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6) !important;
        }

        .card-body {
            padding: 2.2rem !important;
        }

        h4 {
            color: #ffffff !important;
            font-weight: 700 !important;
            text-align: center;
        }

        .app-brand-logo.demo img {
            width: 150px !important;
            margin-bottom: 10px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
        }

        .form-control:focus {
            border-color: var(--brand) !important;
            box-shadow: 0 0 0 0.25rem rgba(60, 212, 160, 0.15) !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }

        /* Fix autocomplete/autofill text visibility */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 50px #0b1020 inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff !important;
        }

        .input-group-text {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #a8b3c5 !important;
            border-radius: 0 8px 8px 0 !important;
        }

        .input-group-merge .form-control {
            border-radius: 8px 0 0 8px !important;
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .form-check-input:checked {
            background-color: var(--brand) !important;
            border-color: var(--brand) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand-2), var(--brand)) !important;
            border: none !important;
            color: #051013 !important;
            font-weight: 800 !important;
            border-radius: 8px !important;
            padding: 10px 20px !important;
            transition: transform 0.1s ease, box-shadow 0.2s ease !important;
            box-shadow: 0 10px 25px rgba(82, 234, 210, 0.15) !important;
        }

        .btn-primary:hover {
            transform: translateY(-1px) !important;
            background: linear-gradient(135deg, var(--brand-2), var(--brand)) !important;
            box-shadow: 0 12px 30px rgba(82, 234, 210, 0.25) !important;
            color: #051013 !important;
        }

        a {
            color: var(--brand) !important;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }

        a:hover {
            color: #ffffff !important;
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="{{ route('home') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img class="dark-mode" width="150px"
                                        src="{{ asset('assets/logo/rydaris-logo.png') }}" alt="Site Logo">
                                </span>
                            </a>
                        </div>
                        
                        <h4 class="mb-6">Sign In</h4>

                        @if (session('status'))
                            <div class="mb-4 text-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.login') }}">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
                            
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" class="form-control" type="email" name="email"
                                    value="{{ old('email') }}" required autofocus autocomplete="username" />
                                @error('email')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="#" onclick="showForgotPasswordAlert(event)" style="font-size: 0.8rem; font-weight: 500;">Forgot Password?</a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showForgotPasswordAlert(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Forgot Password?',
                html: '<p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.5; margin: 0;">To reset your customer account password, please contact our support team at <a href="mailto:{{ $site_setting->contact_email ?? 'support@rydaris.com' }}" style="color: #52ead2; font-weight: 600;">{{ $site_setting->contact_email ?? 'support@rydaris.com' }}</a> or call {{ $site_setting->contact_phone ?? '+918882688646' }}.</p>',
                background: '#0b1020',
                color: '#f8fafc',
                confirmButtonColor: '#52ead2',
                confirmButtonText: 'Got it',
                customClass: {
                    popup: 'swal2-popup'
                }
            });
        }
    </script>
    
    <script src="{{asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/js/menu.js')}}"></script>
    <script src="{{asset('assets/admin/js/main.js')}}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>

</body>
</html>
