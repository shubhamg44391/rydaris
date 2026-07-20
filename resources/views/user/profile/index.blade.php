@extends('user.layouts.app')

@section('page_title', 'My Profile')

@section('main-content')
<section class="admin-hero">
    <div>
        <h1>My Profile</h1>
    </div>
</section>

<section class="admin-form-section" style="margin-top: 22px;">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        
        <article class="kpi-card" style="padding: 30px;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #ffffff; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">Profile Information</h2>
            <form action="{{ route('user.profile.update') }}" method="POST" id="profileUpdateForm">
                @csrf
                
                @if($user->role === 'user')
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Vendor</label>
                    <input type="text" value="{{ $user->vendor->company_name ?? ($user->vendor->name ?? 'N/A') }}" disabled style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: var(--radius); color: #888888; cursor: not-allowed;">
                </div>
                @endif

                @if($user->role === 'vendor')
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('company_name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>
                @endif

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('first_name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Email Address (Cannot be changed)</label>
                    <input type="email" value="{{ $user->email }}" readonly disabled style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: var(--radius); color: #888888; cursor: not-allowed;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Contact Details</label>
                    <input type="tel" id="profile_phone" value="{{ old('country_code', $user->country_code) }}{{ old('contact_number', $user->contact_number) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    
                    
                    <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code', $user->country_code) }}">
                    <input type="hidden" name="contact_number" id="hidden_contact_number" value="{{ old('contact_number', $user->contact_number) }}">
                    
                    @error('country_code')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    @error('contact_number')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Save Changes</button>
            </form>
        </article>

        
        <article class="kpi-card" style="padding: 30px;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #ffffff; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">Change Password</h2>
            <form action="{{ route('user.profile.password') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Current Password</label>
                    <input type="password" name="current_password" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('current_password')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">New Password</label>
                    <input type="password" name="new_password" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('new_password')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Update Password</button>
            </form>
        </article>
    </div>
</section>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        });
    });
</script>
@endif
@endsection

@section('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/js/intlTelInput.min.js"></script>
<style>
    /* intl-tel-input dark theme overrides */
    .iti { width: 100%; display: block; }
    .iti__country-list { background: rgba(11, 16, 32, 0.98); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; z-index: 9999; }
    .iti__country-list .iti__country:hover, .iti__country-list .iti__country.iti__highlight { background: rgba(59, 130, 246, 0.2); }
    .iti__selected-flag { background: transparent !important; padding: 0 12px; border-right: 1px solid rgba(255,255,255,0.1); display: flex !important; flex-direction: row !important; align-items: center !important; flex-wrap: nowrap !important; gap: 6px !important; }
    .iti__flag { order: 1 !important; }
    .iti__selected-dial-code { color: #fff !important; margin-left: 6px; display: inline-block !important; white-space: nowrap !important; order: 2 !important; }
    .iti__arrow { border-top-color: #fff !important; order: 3 !important; }
    .iti__arrow--up { border-bottom-color: #fff !important; }
    #profile_phone { padding-left: 115px !important; }
    .iti__search-input { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #fff; margin-bottom: 8px; padding: 8px; border-radius: 4px; width: calc(100% - 16px); display: block; margin-left: auto; margin-right: auto; }
    
    /* Hide country name - show only flag and country dial code */
    .iti__country-name { display: none !important; }
    .iti__dial-code { margin-left: 8px; font-weight: 600; color: #fff; }
    .iti__country { display: flex; align-items: center; padding: 8px 12px; gap: 4px; }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const phoneInputField = document.getElementById('profile_phone');
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
            const form = document.getElementById('profileUpdateForm');
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
