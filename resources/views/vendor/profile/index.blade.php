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
            <form action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                
                <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 20px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 2px dashed rgba(82, 234, 210, 0.3); display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        @if($user->company_logo)
                            <img src="{{ asset('storage/' . $user->company_logo) }}" alt="Company Logo" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="var(--brand)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        @endif
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Company Logo</label>
                        <input type="file" name="company_logo" accept="image/*" class="form-control-custom" style="padding: 10px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff; width: 100%;">
                        @error('company_logo')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('username')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Email Address</label>
                    <input type="email" value="{{ $user->email }}" disabled style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: var(--radius); color: var(--muted); cursor: not-allowed;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('first_name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('middle_name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('last_name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}" style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('company_name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Contact Details <span style="color: #ff4d4d;">*</span></label>
                    <input type="tel" id="reg_phone" class="form-control-custom" placeholder="Phone number" value="{{ old('country_code', $user->country_code) }}{{ old('contact_number', $user->contact_number) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code', $user->country_code) }}">
                    <input type="hidden" name="contact_number" id="hidden_contact_number" value="{{ old('contact_number', $user->contact_number) }}">
                    @error('country_code')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    @error('contact_number')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--brand); margin-top: 30px; margin-bottom: 15px;">Address Information</h3>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Street Address</label>
                    <input type="text" name="street_address" value="{{ old('street_address', $user->street_address) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('street_address')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Landmark</label>
                    <input type="text" name="landmark" value="{{ old('landmark', $user->landmark) }}" style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('landmark')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">City</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                        @error('city')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Pincode</label>
                        <input type="text" name="pincode" value="{{ old('pincode', $user->pincode) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                        @error('pincode')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Country</label>
                    <input type="text" name="country" value="{{ old('country', $user->country) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('country')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <input type="hidden" name="current_branch_id" value="{{ $user->current_branch_id }}">

                <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Save Changes</button>
            </form>
        </article>

        
        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <article class="kpi-card" style="padding: 30px;">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #ffffff; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">Change Password</h2>
                <form action="{{ route('vendor.profile.password') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Current Password</label>
                        <input type="password" name="current_password" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                        @error('current_password')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">New Password</label>
                        <input type="password" name="password" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                        @error('password')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Update Password</button>
                </form>
            </article>

            
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
