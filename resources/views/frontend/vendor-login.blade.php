<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{asset('assets/admin/')}}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Rydaris Vendor Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/favicon.png') }}" />

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
        :root {
            --brand: #3cd4a0;
            --brand-2: #80a7ff;
        }

        /* Fallback Preloader Spinner Styling */
        .site-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #050711;
            z-index: 999999;
            overflow: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .site-preloader video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center center;
            display: block;
            z-index: 2;
        }
        .preloader-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1;
            pointer-events: none;
        }
        .preloader-spinner .spinner-circle {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.08);
            border-top: 3px solid var(--brand, #52ead2);
            border-radius: 50%;
            animation: preloader-spin 1s linear infinite;
        }
        .preloader-spinner span {
            margin-top: 16px;
            font-size: 13px;
            color: #f8fafc;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 500;
            opacity: 0.8;
        }
        @keyframes preloader-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        body {
            background: radial-gradient(circle at 50% 0%, rgba(82, 234, 210, 0.15), transparent 40rem), #050711 !important;
            color: #f8fafc !important;
            font-family: 'Inter', sans-serif !important;
        }

        .authentication-inner .card {
            background: rgba(11, 16, 32, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-top: 4px solid var(--brand) !important;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.5) !important;
            backdrop-filter: blur(12px) !important;
            color: #f8fafc !important;
            border-radius: 12px !important;
        }

        .card-body, .form-label, h4 {
            color: #f8fafc !important;
        }

        p, .form-check-label {
            color: #a8b3c5 !important;
        }

        .app-brand-logo img {
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
                                        src="{{ asset('assets/logo/rydaris-logo.png') }}" alt="Site Logo">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-6">Vendor Sign In</h4>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 text-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('vendor.login') }}">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
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

                        <p class="text-center mt-3 mb-0" style="font-size: 0.88rem;">
                            <span>New to Rydaris?</span>
                            <a href="{{ route('vendor.register') }}">
                                <span>Create an account</span>
                            </a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Content -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showForgotPasswordAlert(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Forgot Password?',
                html: '<p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.5; margin: 0;">To reset your vendor account password, please contact our administrator at <a href="mailto:sales@rydaris.com" style="color: #52ead2; font-weight: 600;">sales@rydaris.com</a>.</p>',
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

    <!-- ===== FULLSCREEN VIDEO LOADER (shows on login submit) ===== -->
    <div id="loginPreloader" class="site-preloader" style="display:none; opacity:0; position:fixed; top:0; left:0; width:100vw; height:100vh; background:#050711; z-index:999999; overflow:hidden; transition:opacity 0.3s ease;">
        <!-- Fallback Spinner -->
        <div class="preloader-spinner">
            <div class="spinner-circle"></div>
            <span>Logging in</span>
        </div>
        <video id="loginPreloaderVideo" src="{{ asset('assets/loader/loader.mp4') }}" playsinline webkit-playsinline preload="auto" style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:contain; object-position:center; display:block; z-index: 2;"></video>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var loginForm = document.querySelector('form');
            if (!loginForm) return;

            loginForm.addEventListener('submit', function (e) {
                var loader = document.getElementById('loginPreloader');
                var video  = document.getElementById('loginPreloaderVideo');
                if (!loader || !video) return;

                // Prevent immediate submit — wait for full video
                e.preventDefault();

                // Show loader
                loader.style.display = 'block';
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        loader.style.opacity = '1';
                    });
                });

                var submitted = false;
                function submitNow() {
                    if (submitted) return;
                    submitted = true;
                    loginForm.submit();
                }

                // Play video with sound
                video.muted = false;
                video.currentTime = 0;
                var playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise.catch(function (error) {
                        console.warn("Video login preloader unmuted play blocked. Trying muted.", error);
                        video.muted = true;
                        video.play().catch(function (err) {
                            console.error("Muted video login preloader play failed. Submitting.", err);
                            submitNow();
                        });
                    });
                }

                // Submit after video ends
                video.addEventListener('ended', submitNow);

                // Safety fallback — max 10 seconds
                setTimeout(submitNow, 10000);
            });
        });
    </script>
    <!-- ===== END LOADER ===== -->
</body>

</html>
