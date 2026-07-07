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
        <!-- Profile Details -->
        <article class="kpi-card" style="padding: 30px;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #ffffff; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">Profile Information</h2>
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('name')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--muted-2); font-size: 0.875rem;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: var(--radius); color: #ffffff;">
                    @error('email')<div style="color: #ff6b6b; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Save Changes</button>
            </form>
        </article>

        <!-- Change Password -->
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
