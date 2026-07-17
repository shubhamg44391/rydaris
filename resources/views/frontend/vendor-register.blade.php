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

        .authentication-inner {
            max-width: 700px !important;
            width: 100% !important;
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

        /* Stepper Styles */
        .stepper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            position: relative;
        }
        .stepper::before {
            content: '';
            position: absolute;
            top: 18px;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.08);
            z-index: 1;
        }
        .stepper-progress {
            position: absolute;
            top: 18px;
            left: 0;
            height: 2px;
            background: var(--brand);
            z-index: 1;
            transition: width 0.3s ease;
            width: 0%;
        }
        .step-item {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        .step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #0b1020;
            border: 2px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a8b3c5;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .step-item.active .step-circle {
            border-color: var(--brand);
            color: #051013;
            background: var(--brand);
            box-shadow: 0 0 15px rgba(82, 234, 210, 0.4);
        }
        .step-item.completed .step-circle {
            border-color: var(--brand);
            color: #051013;
            background: var(--brand);
        }
        .step-title {
            font-size: 0.75rem;
            color: #a8b3c5;
            margin-top: 0.5rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .step-item.active .step-title, .step-item.completed .step-title {
            color: var(--brand);
            font-weight: 600;
        }
        .btn-secondary-wizard {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            transition: background 0.2s ease !important;
        }
        .btn-secondary-wizard:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }
    </style>
    @include('partials.phone-input')
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
                        @if(isset($invitation))
                            <h4 class="mb-6" id="form-title">Get Started as a User!</h4>
                        @else
                            <h4 class="mb-6" id="form-title">Get Started as a Vendor!</h4>
                        @endif

                        <!-- Stepper -->
                        <!--
                        <div class="stepper">
                            <div class="stepper-progress"></div>
                            <div class="step-item active">
                                <div class="step-circle">1</div>
                                <div class="step-title">Account</div>
                            </div>
                            <div class="step-item">
                                <div class="step-circle">2</div>
                                <div class="step-title">Address</div>
                            </div>
                            <div class="step-item">
                                <div class="step-circle">3</div>
                                <div class="step-title">Security</div>
                            </div>
                        </div>
                        -->

                        <form method="POST" action="{{ route('vendor.register.submit') }}" id="vendorRegisterForm">
                            @csrf
                            @if(request()->has('package_id'))
                                <input type="hidden" name="package_id" value="{{ request('package_id') }}" />
                            @elseif(old('package_id'))
                                <input type="hidden" name="package_id" value="{{ old('package_id') }}" />
                            @endif
                            
                            <!-- Step 1: Account Information -->
                            <div class="form-step">
                                <h5 class="mb-4" style="color: var(--brand); font-weight: 700; letter-spacing: 0.5px;">Account Information</h5>
                                <!-- Name Fields Row -->
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="first_name" class="form-label">{{ __('First Name') }} <span style="color: #ff4d4d;">*</span></label>
                                        <input id="first_name" class="form-control" type="text" name="first_name"
                                            value="{{ old('first_name', isset($invitation) ? $invitation->name : '') }}" required autofocus placeholder="First name" />
                                        @error('first_name')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Middle Name -->
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="middle_name" class="form-label">{{ __('Middle Name') }}</label>
                                        <input id="middle_name" class="form-control" type="text" name="middle_name"
                                            value="{{ old('middle_name') }}" placeholder="Middle name (optional)" />
                                        @error('middle_name')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="last_name" class="form-label">{{ __('Last Name') }} <span style="color: #ff4d4d;">*</span></label>
                                        <input id="last_name" class="form-control" type="text" name="last_name"
                                            value="{{ old('last_name') }}" required placeholder="Last name" />
                                        @error('last_name')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if(isset($invitation))
                                    <input type="hidden" name="invite_token" value="{{ $invitation->token }}" />
                                    <input type="hidden" name="role" value="user" />
                                    <input type="hidden" name="vendor_id" value="{{ $invitation->vendor_id }}" />
                                @else
                                    <input type="hidden" name="role" value="vendor" />
                                    
                                    <!-- Company Name (Required for direct Vendor signup) -->
                                    <div class="form-group mb-3" id="company_name_container">
                                        <label for="company_name" class="form-label">{{ __('Company Name') }} <span style="color: #ff4d4d;">*</span></label>
                                        <input id="company_name" class="form-control" type="text" name="company_name"
                                            value="{{ old('company_name') }}" required placeholder="Enter your company name" />
                                        @error('company_name')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <!-- Email Address -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }} <span style="color: #ff4d4d;">*</span></label>
                                    <input id="email" class="form-control" type="email" name="email"
                                        value="{{ old('email', isset($invitation) ? $invitation->email : '') }}" required placeholder="name@company.com" {{ isset($invitation) ? 'readonly' : '' }} />
                                    @error('email')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone and Country Code -->
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Contact Details') }} <span style="color: #ff4d4d;">*</span></label>
                                    <input type="tel" id="reg_phone" class="form-control" placeholder="Phone number" value="{{ old('country_code', isset($invitation) ? $invitation->vendor->country_code : '') }}{{ old('contact_number') }}" required style="width: 100%;">
                                    <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code', isset($invitation) ? $invitation->vendor->country_code : '') }}">
                                    <input type="hidden" name="contact_number" id="hidden_contact_number" value="{{ old('contact_number') }}">
                                    @error('country_code')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('contact_number')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Step 2: Address Details -->
                            <div class="form-step d-none">
                                <h5 class="mb-4" style="color: var(--brand); font-weight: 700; letter-spacing: 0.5px;">Address Details</h5>
                                <!-- Street Address -->
                                <div class="form-group mb-3">
                                    <label for="street_address" class="form-label">{{ __('Street Address') }} @if(!isset($invitation))<span style="color: #ff4d4d;">*</span>@endif</label>
                                    <input id="street_address" class="form-control" type="text" name="street_address"
                                        value="{{ old('street_address') }}" @if(!isset($invitation)) required @endif placeholder="Enter street address" />
                                    @error('street_address')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Landmark -->
                                <div class="form-group mb-3">
                                    <label for="landmark" class="form-label">{{ __('Landmark') }}</label>
                                    <input id="landmark" class="form-control" type="text" name="landmark"
                                        value="{{ old('landmark') }}" placeholder="Enter landmark (optional)" />
                                    @error('landmark')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <!-- City -->
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="city" class="form-label">{{ __('City') }} @if(!isset($invitation))<span style="color: #ff4d4d;">*</span>@endif</label>
                                        <input id="city" class="form-control" type="text" name="city"
                                            value="{{ old('city') }}" @if(!isset($invitation)) required @endif placeholder="City" />
                                        @error('city')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Pincode -->
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="pincode" class="form-label">{{ __('Pincode') }} @if(!isset($invitation))<span style="color: #ff4d4d;">*</span>@endif</label>
                                        <input id="pincode" class="form-control" type="text" name="pincode"
                                            value="{{ old('pincode') }}" @if(!isset($invitation)) required @endif placeholder="Pincode" />
                                        @error('pincode')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="form-group mb-3">
                                    <label for="country" class="form-label">{{ __('Country') }} @if(!isset($invitation))<span style="color: #ff4d4d;">*</span>@endif</label>
                                    <input id="country" class="form-control" type="text" name="country"
                                        value="{{ old('country') }}" @if(!isset($invitation)) required @endif placeholder="Country" />
                                    @error('country')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Step 3: Security Details -->
                            <div class="form-step d-none">
                                <h5 class="mb-4" style="color: var(--brand); font-weight: 700; letter-spacing: 0.5px;">Security Settings</h5>
                                <!-- Password -->
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">{{ __('Password') }} <span style="color: #ff4d4d;">*</span></label>
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
                                    <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }} <span style="color: #ff4d4d;">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input id="password_confirmation" class="form-control" type="password"
                                            name="password_confirmation" required placeholder="Repeat password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="d-flex justify-content-between mt-4 gap-2">
                                <button type="button" id="btnPrev" class="btn btn-secondary-wizard d-none w-100">
                                    {{ __('Back') }}
                                </button>
                                <button type="button" id="btnNext" class="btn btn-primary w-100">
                                    {{ __('Next') }}
                                </button>
                                <button type="submit" id="btnSubmit" class="btn btn-primary d-none w-100">
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
            const steps = document.querySelectorAll('.form-step');
            const stepItems = document.querySelectorAll('.step-item');
            const progressBar = document.querySelector('.stepper-progress');
            const btnPrev = document.getElementById('btnPrev');
            const btnNext = document.getElementById('btnNext');
            const btnSubmit = document.getElementById('btnSubmit');
            const form = document.getElementById('vendorRegisterForm');
            
            let currentStep = 0;

            function updateStep() {
                steps.forEach((step, idx) => {
                    if (idx === currentStep) {
                        step.classList.remove('d-none');
                    } else {
                        step.classList.add('d-none');
                    }
                });

                stepItems.forEach((item, idx) => {
                    if (idx < currentStep) {
                        item.classList.add('completed');
                        item.classList.remove('active');
                    } else if (idx === currentStep) {
                        item.classList.add('active');
                        item.classList.remove('completed');
                    } else {
                        item.classList.remove('active', 'completed');
                    }
                });

                const progressPercent = (currentStep / (steps.length - 1)) * 100;
                if (progressBar) {
                    progressBar.style.width = `${progressPercent}%`;
                }

                // Buttons visibility
                if (currentStep === 0) {
                    btnPrev.classList.add('d-none');
                    btnNext.classList.remove('d-none');
                    btnSubmit.classList.add('d-none');
                } else if (currentStep === steps.length - 1) {
                    btnPrev.classList.remove('d-none');
                    btnNext.classList.add('d-none');
                    btnSubmit.classList.remove('d-none');
                } else {
                    btnPrev.classList.remove('d-none');
                    btnNext.classList.remove('d-none');
                    btnSubmit.classList.add('d-none');
                }
            }

            btnNext.addEventListener('click', function () {
                // Validate inputs in current step
                const currentFields = steps[currentStep].querySelectorAll('input, select, textarea');
                let isValid = true;
                currentFields.forEach(field => {
                    if (!field.checkValidity()) {
                        field.reportValidity();
                        isValid = false;
                    }
                });

                if (isValid) {
                    currentStep++;
                    updateStep();
                }
            });

            btnPrev.addEventListener('click', function () {
                currentStep--;
                updateStep();
            });

            // Redirect back with validation errors
            const hasErrors = {!! $errors->any() ? 'true' : 'false' !!};
            if (hasErrors) {
                const step2Errors = {!! $errors->hasAny(['street_address', 'landmark', 'pincode', 'city', 'country']) ? 'true' : 'false' !!};
                const step3Errors = {!! $errors->hasAny(['password', 'password_confirmation']) ? 'true' : 'false' !!};

                if (step3Errors) {
                    currentStep = 2;
                } else if (step2Errors) {
                    currentStep = 1;
                } else {
                    currentStep = 0;
                }
            }

            // Init Phone Input
            initializeIntlTelInput('reg_phone', 'hidden_country_code', 'hidden_contact_number');

            updateStep();
        });
    </script>


    <!-- ===== FULLSCREEN VIDEO LOADER (shows on register submit) ===== -->
    <div id="registerPreloader" class="site-preloader" style="display:none; opacity:0; position:fixed; top:0; left:0; width:100vw; height:100vh; background:#050711; z-index:999999; overflow:hidden; transition:opacity 0.3s ease;">
        <!-- Fallback Spinner -->
        <div class="preloader-spinner">
            <div class="spinner-circle"></div>
            <span>Submitting</span>
        </div>
        <video id="registerPreloaderVideo" src="{{ asset('assets/loader/loader.mp4') }}" playsinline webkit-playsinline preload="auto" style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:contain; object-position:center; display:block; z-index: 2;"></video>
    </div>

    <script>
        (function() {
            var regForm = null;
            var loaderShown = false;

            function showAndSubmit(form) {
                if (loaderShown) return;
                loaderShown = true;

                var loader = document.getElementById('registerPreloader');
                var video  = document.getElementById('registerPreloaderVideo');
                if (!loader || !video) { form.submit(); return; }

                // Show loader fullscreen
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
                    form.submit();
                }

                // Play full video with sound
                video.muted = false;
                video.currentTime = 0;
                var playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise.catch(function (error) {
                        console.warn("Video register preloader unmuted play blocked. Trying muted.", error);
                        video.muted = true;
                        video.play().catch(function (err) {
                            console.error("Muted video register preloader play failed. Submitting.", err);
                            submitNow();
                        });
                    });
                }

                // Submit AFTER video ends
                video.addEventListener('ended', submitNow);

                // Safety fallback — max 10 seconds
                setTimeout(submitNow, 10000);
            }

            document.addEventListener('DOMContentLoaded', function () {
                regForm = document.querySelector('form');
                if (!regForm) return;

                // Intercept final "Register" button click
                var btnSubmit = document.getElementById('btnSubmit');
                if (btnSubmit) {
                    btnSubmit.addEventListener('click', function (e) {
                        // Let HTML5 validation run first (50ms)
                        setTimeout(function () {
                            if (regForm.checkValidity()) {
                                e.preventDefault();
                                showAndSubmit(regForm);
                            }
                        }, 50);
                    });
                }

                // Also intercept direct form submit event
                regForm.addEventListener('submit', function (e) {
                    if (!loaderShown) {
                        e.preventDefault();
                        showAndSubmit(regForm);
                    }
                });
            });
        })();
    </script>
    <!-- ===== END LOADER ===== -->

</body>

</html>
