@extends('admin.layouts.app')

@section('page_title', 'Vendor Profile')

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
            <form id="vendorProfileForm" action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Company Logo --}}
                <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 20px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 2px dashed rgba(82, 234, 210, 0.3); display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        @if($user->company_logo)
                            <img id="profileLogoPreview" src="{{ asset('storage/' . $user->company_logo) }}" alt="Company Logo" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div id="profileLogoPreviewContainer" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                                <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="var(--brand)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Company Logo</label>
                        <input type="file" name="company_logo" accept="image/*" class="form-control-custom" style="padding: 10px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff; width: 100%;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Email Address</label>
                    <input type="email" value="{{ $user->email }}" disabled style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: var(--radius); color: var(--muted); cursor: not-allowed;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}" style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Contact Details <span style="color: #ff4d4d;">*</span></label>
                    <input type="tel" id="reg_phone" class="form-control-custom" placeholder="Phone number" value="{{ old('country_code', $user->country_code) }}{{ old('contact_number', $user->contact_number) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code', $user->country_code) }}">
                    <input type="hidden" name="contact_number" id="hidden_contact_number" value="{{ old('contact_number', $user->contact_number) }}">
                </div>

                <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--brand); margin-top: 30px; margin-bottom: 15px;">Address Information</h3>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Street Address</label>
                    <input type="text" name="street_address" value="{{ old('street_address', $user->street_address) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Landmark</label>
                    <input type="text" name="landmark" value="{{ old('landmark', $user->landmark) }}" style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">City</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Pincode</label>
                        <input type="text" name="pincode" value="{{ old('pincode', $user->pincode) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Country</label>
                    <input type="text" name="country" value="{{ old('country', $user->country) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-size: 0.875rem; font-weight: 700;">
                        Default Currency / Price Format <span style="color: var(--brand, #52ead2); font-size: 0.78rem;">(Select Currency)</span>
                    </label>
                    <select name="currency" required style="width: 100%; padding: 12px; background: #0b1020; border: 1px solid rgba(82, 234, 210, 0.25); border-radius: var(--radius); color: #ffffff; font-size: 0.9rem; outline: none; cursor: pointer;">
                        <option value="USD" {{ old('currency', $user->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($) - US Dollar</option>
                        <option value="EUR" {{ old('currency', $user->currency) == 'EUR' ? 'selected' : '' }}>EUR (€) - Euro</option>
                        <option value="AED" {{ old('currency', $user->currency) == 'AED' ? 'selected' : '' }}>AED (AED) - UAE Dirham</option>
                        <option value="INR" {{ old('currency', $user->currency) == 'INR' ? 'selected' : '' }}>INR (₹) - Indian Rupee</option>
                        <option value="GBP" {{ old('currency', $user->currency) == 'GBP' ? 'selected' : '' }}>GBP (£) - British Pound</option>
                    </select>
                </div>

                <input type="hidden" name="current_branch_id" value="{{ $user->current_branch_id }}">

                <button type="submit" id="profileSaveBtn" class="btn btn-primary" style="margin-top: 15px;">Save Changes</button>
            </form>
        </article>

        {{-- Right Side Cards --}}
        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <article class="kpi-card" style="padding: 30px;">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #ffffff; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">Change Password</h2>
                <form id="vendorPasswordForm" action="{{ route('vendor.profile.password') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Current Password</label>
                        <input type="password" name="current_password" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">New Password</label>
                        <input type="password" name="password" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    </div>

                    <button type="submit" id="passwordSaveBtn" class="btn btn-primary" style="margin-top: 15px;">Update Password</button>
                </form>
            </article>

            {{-- Branch Switcher --}}
            <article class="kpi-card" style="padding: 30px;">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #ffffff; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">Default Active Branch</h2>
                <form id="branchSelectForm">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Select Branch</label>
                        <select name="branch_id" id="profileBranchSelect" style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff; outline: none; cursor: pointer;">
                            <option value="" style="background-color: #0b1020; color: #f8fafc;" {{ is_null($user->current_branch_id) ? 'selected' : '' }}>All Branches</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}" style="background-color: #0b1020; color: #f8fafc;" {{ $user->current_branch_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Switch Branch</button>
                </form>
            </article>
        </div>
    </div>
</section>
@endsection

@section('js')
    @include('partials.phone-input')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initializeIntlTelInput('reg_phone', 'hidden_country_code', 'hidden_contact_number');

            // Profile Form Submit via AJAX
            $('#vendorProfileForm').on('submit', function (e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);
                var btn = $('#profileSaveBtn');

                btn.prop('disabled', true).css('opacity', '0.7');

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function (response) {
                        btn.prop('disabled', false).css('opacity', '1');
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'Profile updated successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            if (response.logo_url) {
                                $('#profileLogoPreview').attr('src', response.logo_url).show();
                                $('#profileLogoPreviewContainer').hide();
                            }
                        } else {
                            Swal.fire('Error', response.message || 'Failed to update profile.', 'error');
                        }
                    },
                    error: function (xhr) {
                        btn.prop('disabled', false).css('opacity', '1');
                        var msg = 'Failed to update profile.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Validation Error', msg, 'error');
                    }
                });
            });

            // Password Form Submit via AJAX
            $('#vendorPasswordForm').on('submit', function (e) {
                e.preventDefault();
                var form = this;
                var btn = $('#passwordSaveBtn');

                btn.prop('disabled', true).css('opacity', '0.7');

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function (response) {
                        btn.prop('disabled', false).css('opacity', '1');
                        if (response.status === 'success') {
                            form.reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Password Updated!',
                                text: response.message || 'Password updated successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire('Error', response.message || 'Failed to update password.', 'error');
                        }
                    },
                    error: function (xhr) {
                        btn.prop('disabled', false).css('opacity', '1');
                        var msg = 'Failed to update password.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Validation Error', msg, 'error');
                    }
                });
            });

            // Branch Select Form
            const branchForm = document.getElementById('branchSelectForm');
            if (branchForm) {
                branchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const branchId = document.getElementById('profileBranchSelect').value;
                    
                    fetch('{{ route("vendor.branches.select") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ branch_id: branchId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to switch branch.'
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while switching branch.'
                        });
                    });
                });
            }
        });
    </script>
@endsection
