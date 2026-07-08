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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/css/intlTelInput.css"/>

    <style>
        :root {
            --brand: #52ead2;
        }

        .authentication-inner {
            max-width: 520px !important;
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
            background: linear-gradient(135deg, var(--brand), #ffffff) !important;
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

        /* intl-tel-input dark theme overrides */
        .iti { width: 100%; display: block; }
        .iti__country-list { background: rgba(11, 16, 32, 0.98); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; z-index: 9999; }
        .iti__country-list .iti__country:hover, .iti__country-list .iti__country.iti__highlight { background: rgba(59, 130, 246, 0.2); }
        .iti__selected-flag { background: transparent !important; padding: 0 12px; border-right: 1px solid rgba(255, 255, 255, 0.12); display: flex !important; flex-direction: row !important; align-items: center !important; flex-wrap: nowrap !important; gap: 6px !important; }
        .iti__flag { order: 1 !important; }
        .iti__selected-dial-code { color: #fff !important; margin-left: 6px; display: inline-block !important; white-space: nowrap !important; order: 2 !important; }
        .iti__arrow { border-top-color: #fff !important; order: 3 !important; }
        .iti__arrow--up { border-bottom-color: #fff !important; }
        #reg_phone { padding-left: 115px !important; }
        .iti__search-input { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #fff; margin-bottom: 8px; padding: 8px; border-radius: 4px; width: calc(100% - 16px); display: block; margin-left: auto; margin-right: auto; }
        
        /* Hide country name - show only flag and country dial code */
        .iti__country-name { display: none !important; }
        .iti__dial-code { margin-left: 8px; font-weight: 600; color: #fff; }
        .iti__country { display: flex; align-items: center; padding: 8px 12px; gap: 4px; }
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

                        <form method="POST" action="{{ route('vendor.register.submit') }}" id="vendorRegisterForm">
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

                            <!-- Select Vendor (For Users Only) -->
                            <div class="form-group mb-3" id="vendor_select_container" style="display: {{ old('role', 'user') === 'user' ? 'block' : 'none' }};">
                                <label for="vendor_id" class="form-label">{{ __('Select Vendor') }}</label>
                                <select id="vendor_id" name="vendor_id" class="form-select" style="background-color: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.12); padding: 12px; border-radius: 8px;">
                                    <option value="" style="background: #0f172a;">-- Select a Vendor --</option>
                                    @if(isset($vendors) && count($vendors) > 0)
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" style="background: #0f172a;" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->company_name ?? $vendor->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('vendor_id')
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
                                <input type="tel" id="reg_phone" class="form-control" placeholder="Phone number" value="{{ old('country_code') }}{{ old('contact_number') }}" required style="width: 100%;">
                                <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code') }}">
                                <input type="hidden" name="contact_number" id="hidden_contact_number" value="{{ old('contact_number') }}">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const companyContainer = document.getElementById('company_name_container');
            const companyInput = document.getElementById('company_name');
            const vendorContainer = document.getElementById('vendor_select_container');
            const vendorInput = document.getElementById('vendor_id');
            const formTitle = document.getElementById('form-title');

            function toggleFields() {
                const checkedRadio = document.querySelector('input[name="role"]:checked');
                if (!checkedRadio) return;
                
                if (checkedRadio.value === 'vendor') {
                    companyContainer.style.display = 'block';
                    companyInput.required = true;
                    vendorContainer.style.display = 'none';
                    vendorInput.required = false;
                    formTitle.textContent = 'Get Started as a Vendor! 👋';
                } else {
                    companyContainer.style.display = 'none';
                    companyInput.required = false;
                    vendorContainer.style.display = 'block';
                    vendorInput.required = true;
                    formTitle.textContent = 'Get Started as a User! 👋';
                }
            }

            roleRadios.forEach(radio => radio.addEventListener('change', toggleFields));
            
            // Initial run on page load
            toggleFields();

            // Init Phone Input
            const phoneInputField = document.getElementById('reg_phone');
            if (phoneInputField) {
                const storedPhone = phoneInputField.value || '';
                const options = {
                    preferredCountries: ["ae", "sa", "in", "us", "gb", "au"],
                    initialCountry: "ae", // Instantly show UAE (no grey box!)
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/js/utils.js",
                    showSelectedDialCode: true,
                    formatOnDisplay: true,
                    countrySearch: true
                };

                // Only allow numbers to be entered
                phoneInputField.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });

                const iti = window.intlTelInput(phoneInputField, options);

                // Fetch IP country in the background if number has no prefix
                if (!storedPhone.startsWith('+')) {
                    fetch('https://ipapi.co/json/')
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.country_code) {
                                iti.setCountry(data.country_code.toLowerCase());
                            }
                        })
                        .catch(() => console.log('IP lookup failed, using fallback UAE.'));
                }

                // Before submit, split country code and phone number
                const form = document.getElementById('vendorRegisterForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const countryData = iti.getSelectedCountryData();
                        const fullNumber = iti.getNumber();
                        const dialCode = '+' + countryData.dialCode;
                        
                        let nationalNumber = fullNumber.replace(dialCode, '').trim();
                        if (!nationalNumber && phoneInputField.value) {
                            nationalNumber = phoneInputField.value;
                        }

                        document.getElementById('hidden_country_code').value = dialCode;
                        document.getElementById('hidden_contact_number').value = nationalNumber;
                    });
                }
            }
        });
    </script>
</body>

</html>
