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
        <!-- Profile Details -->
        <article class="kpi-card" style="padding: 30px;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #ffffff; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">Profile Information</h2>
            <form action="{{ route('vendor.profile.update') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Username</label>
                    <input type="text" value="{{ $user->username }}" disabled style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: var(--radius); color: var(--muted); cursor: not-allowed;">
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
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}" style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('company_name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Country Code</label>
                        <select name="country_code" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                            @include('partials.country-options', ['selected' => $user->country_code])
                        </select>
                        @error('country_code')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    </div>

                    <div style="flex: 2;">
                        <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                        @error('contact_number')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Save Changes</button>
            </form>
        </article>

        <!-- Change Password -->
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
    </div>
</section>
@endsection
