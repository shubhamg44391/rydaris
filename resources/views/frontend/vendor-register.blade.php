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
                        <h4 class="mb-6">Get Started as a Vendor! 👋</h4>

                        <form method="POST" action="{{ route('vendor.register.submit') }}">
                            @csrf
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
                                        <option value="+93">+93 (AF)</option>
                                        <option value="+355">+355 (AL)</option>
                                        <option value="+213">+213 (DZ)</option>
                                        <option value="+376">+376 (AD)</option>
                                        <option value="+244">+244 (AO)</option>
                                        <option value="+54">+54 (AR)</option>
                                        <option value="+374">+374 (AM)</option>
                                        <option value="+61">+61 (AU)</option>
                                        <option value="+43">+43 (AT)</option>
                                        <option value="+994">+994 (AZ)</option>
                                        <option value="+1">+1 (BS)</option>
                                        <option value="+973">+973 (BH)</option>
                                        <option value="+880">+880 (BD)</option>
                                        <option value="+375">+375 (BY)</option>
                                        <option value="+32">+32 (BE)</option>
                                        <option value="+591">+591 (BO)</option>
                                        <option value="+387">+387 (BA)</option>
                                        <option value="+55">+55 (BR)</option>
                                        <option value="+673">+673 (BN)</option>
                                        <option value="+359">+359 (BG)</option>
                                        <option value="+855">+855 (KH)</option>
                                        <option value="+237">+237 (CM)</option>
                                        <option value="+1">+1 (CA)</option>
                                        <option value="+56">+56 (CL)</option>
                                        <option value="+86">+86 (CN)</option>
                                        <option value="+57">+57 (CO)</option>
                                        <option value="+506">+506 (CR)</option>
                                        <option value="+385">+385 (HR)</option>
                                        <option value="+53">+53 (CU)</option>
                                        <option value="+357">+357 (CY)</option>
                                        <option value="+420">+420 (CZ)</option>
                                        <option value="+45">+45 (DK)</option>
                                        <option value="+593">+593 (EC)</option>
                                        <option value="+20">+20 (EG)</option>
                                        <option value="+503">+503 (SV)</option>
                                        <option value="+372">+372 (EE)</option>
                                        <option value="+251">+251 (ET)</option>
                                        <option value="+358">+358 (FI)</option>
                                        <option value="+33">+33 (FR)</option>
                                        <option value="+995">+995 (GE)</option>
                                        <option value="+49">+49 (DE)</option>
                                        <option value="+233">+233 (GH)</option>
                                        <option value="+30">+30 (GR)</option>
                                        <option value="+502">+502 (GT)</option>
                                        <option value="+504">+504 (HN)</option>
                                        <option value="+852">+852 (HK)</option>
                                        <option value="+36">+36 (HU)</option>
                                        <option value="+354">+354 (IS)</option>
                                        <option value="+91" selected>+91 (IN)</option>
                                        <option value="+62">+62 (ID)</option>
                                        <option value="+98">+98 (IR)</option>
                                        <option value="+964">+964 (IQ)</option>
                                        <option value="+353">+353 (IE)</option>
                                        <option value="+972">+972 (IL)</option>
                                        <option value="+39">+39 (IT)</option>
                                        <option value="+1">+1 (JM)</option>
                                        <option value="+81">+81 (JP)</option>
                                        <option value="+962">+962 (JO)</option>
                                        <option value="+7">+7 (KZ)</option>
                                        <option value="+254">+254 (KE)</option>
                                        <option value="+965">+965 (KW)</option>
                                        <option value="+371">+371 (LV)</option>
                                        <option value="+961">+961 (LB)</option>
                                        <option value="+218">+218 (LY)</option>
                                        <option value="+370">+370 (LT)</option>
                                        <option value="+352">+352 (LU)</option>
                                        <option value="+853">+853 (MO)</option>
                                        <option value="+389">+389 (MK)</option>
                                        <option value="+60">+60 (MY)</option>
                                        <option value="+960">+960 (MV)</option>
                                        <option value="+356">+356 (MT)</option>
                                        <option value="+52">+52 (MX)</option>
                                        <option value="+373">+373 (MD)</option>
                                        <option value="+377">+377 (MC)</option>
                                        <option value="+382">+382 (ME)</option>
                                        <option value="+212">+212 (MA)</option>
                                        <option value="+95">+95 (MM)</option>
                                        <option value="+977">+977 (NP)</option>
                                        <option value="+31">+31 (NL)</option>
                                        <option value="+64">+64 (NZ)</option>
                                        <option value="+234">+234 (NG)</option>
                                        <option value="+47">+47 (NO)</option>
                                        <option value="+968">+968 (OM)</option>
                                        <option value="+92">+92 (PK)</option>
                                        <option value="+507">+507 (PA)</option>
                                        <option value="+595">+595 (PY)</option>
                                        <option value="+51">+51 (PE)</option>
                                        <option value="+63">+63 (PH)</option>
                                        <option value="+48">+48 (PL)</option>
                                        <option value="+351">+351 (PT)</option>
                                        <option value="+974">+974 (QA)</option>
                                        <option value="+40">+40 (RO)</option>
                                        <option value="+7">+7 (RU)</option>
                                        <option value="+966">+966 (SA)</option>
                                        <option value="+221">+221 (SN)</option>
                                        <option value="+381">+381 (RS)</option>
                                        <option value="+65">+65 (SG)</option>
                                        <option value="+421">+421 (SK)</option>
                                        <option value="+386">+386 (SI)</option>
                                        <option value="+27">+27 (ZA)</option>
                                        <option value="+82">+82 (KR)</option>
                                        <option value="+34">+34 (ES)</option>
                                        <option value="+94">+94 (LK)</option>
                                        <option value="+46">+46 (SE)</option>
                                        <option value="+41">+41 (CH)</option>
                                        <option value="+886">+886 (TW)</option>
                                        <option value="+66">+66 (TH)</option>
                                        <option value="+216">+216 (TN)</option>
                                        <option value="+90">+90 (TR)</option>
                                        <option value="+380">+380 (UA)</option>
                                        <option value="+971">+971 (AE)</option>
                                        <option value="+44">+44 (GB)</option>
                                        <option value="+1">+1 (US)</option>
                                        <option value="+598">+598 (UY)</option>
                                        <option value="+998">+998 (UZ)</option>
                                        <option value="+58">+58 (VE)</option>
                                        <option value="+84">+84 (VN)</option>
                                        <option value="+967">+967 (YE)</option>
                                        <option value="+263">+263 (ZW)</option>
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
</body>

</html>
