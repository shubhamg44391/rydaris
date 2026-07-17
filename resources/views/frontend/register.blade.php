<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{asset('assets/admin/')}}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Vendor Registration | Rydaris</title>

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
            --brand: #52ead2;
            --brand-2: #80a7ff;
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
            box-shadow: 0 0 0 0.25rem rgba(82, 234, 210, 0.15) !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }

        .form-select {
            background-color: #0b1020 !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2352ead2' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 16px 12px !important;
        }

        .form-select:focus {
            border-color: var(--brand) !important;
            box-shadow: 0 0 0 0.25rem rgba(82, 234, 210, 0.15) !important;
            background-color: #0b1020 !important;
            color: #ffffff !important;
        }

        .form-select option {
            background-color: #0b1020 !important;
            color: #ffffff !important;
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
                        <h4 class="mb-6" id="form-title">Get Started! 👋</h4>

                        <form method="POST" action="{{ route('vendor.register.submit') }}">
                            @csrf
                            
                            <!-- Registration Type -->
                            <div class="form-group mb-4">
                                <label class="form-label d-block">{{ __('Register As') }}</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="role_user" value="user" {{ old('role') === 'user' ? 'checked' : 'checked' }}>
                                    <label class="form-check-label" for="role_user">User</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="role_vendor" value="vendor" {{ old('role') === 'vendor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_vendor">Vendor</label>
                                </div>
                                @error('role')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Name (For Vendors Only) -->
                            <div class="form-group mb-3" id="company_name_container" style="display: {{ old('role') === 'vendor' ? 'block' : 'none' }};">
                                <label for="company_name" class="form-label">{{ __('Company Name') }}</label>
                                <input id="company_name" class="form-control" type="text" name="company_name"
                                    value="{{ old('company_name') }}" placeholder="Enter your company name" />
                                @error('company_name')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- First Name -->
                            <div class="form-group mb-3">
                                <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                                <input id="first_name" class="form-control" type="text" name="first_name"
                                    value="{{ old('first_name') }}" required autofocus placeholder="Enter your first name" />
                                @error('first_name')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" class="form-control" type="email" name="email"
                                    value="{{ old('email') }}" required placeholder="name@company.com" />
                                @error('email')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone and Country Code -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('Contact Details') }}</label>
                                <div class="input-group">
                                    <select name="country_code" class="form-select" style="max-width: 130px;" required>
                                        @include('partials.country-options')
                                    </select>
                                    <input type="tel" name="contact_number" class="form-control"
                                        placeholder="Phone number" value="{{ old('contact_number') }}" required />
                                </div>
                                @error('country_code')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                                @error('contact_number')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input id="password" class="form-control" type="password" name="password" required
                                        autocomplete="new-password" placeholder="Min 8 characters" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input id="password_confirmation" class="form-control" type="password"
                                        name="password_confirmation" required placeholder="Repeat password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary d-grid w-100">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>

                        <p class="text-center mt-3">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">
                                <span>Sign in instead</span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const companyContainer = document.getElementById('company_name_container');
            const companyInput = document.getElementById('company_name');
            const formTitle = document.getElementById('form-title');

            function toggleFields() {
                const checkedRadio = document.querySelector('input[name="role"]:checked');
                if (!checkedRadio) return;
                
                if (checkedRadio.value === 'vendor') {
                    companyContainer.style.display = 'block';
                    companyInput.required = true;
                    formTitle.textContent = 'Get Started as a Vendor! 👋';
                } else {
                    companyContainer.style.display = 'none';
                    companyInput.required = false;
                    formTitle.textContent = 'Get Started as a User! 👋';
                }
            }

            roleRadios.forEach(radio => radio.addEventListener('change', toggleFields));
            
            // Initial run on page load
            toggleFields();
        });
    </script>
</body>

</html>
