@extends('admin.layouts.app')

@section('page_title', 'Admin Profile Settings')

@section('main-content')
<style>
    .admin-profile-card {
        background: linear-gradient(145deg, rgba(15, 23, 42, 0.8), rgba(7, 12, 26, 0.9));
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 28px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }
    body.light-mode .admin-profile-card,
    html.light-mode .admin-profile-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.05) !important;
    }

    .admin-profile-card h2 {
        color: #ffffff;
    }
    body.light-mode .admin-profile-card h2,
    html.light-mode .admin-profile-card h2 {
        color: #0f172a !important;
    }

    .admin-profile-card .card-subtitle {
        color: #aab7cb;
    }
    body.light-mode .admin-profile-card .card-subtitle,
    html.light-mode .admin-profile-card .card-subtitle {
        color: #64748b !important;
    }

    .admin-profile-card label {
        color: #f8fafc;
    }
    body.light-mode .admin-profile-card label,
    html.light-mode .admin-profile-card label {
        color: #1e293b !important;
    }

    .admin-profile-card input[type="text"],
    .admin-profile-card input[type="email"],
    .admin-profile-card input[type="password"] {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }
    body.light-mode .admin-profile-card input[type="text"],
    body.light-mode .admin-profile-card input[type="email"],
    body.light-mode .admin-profile-card input[type="password"],
    html.light-mode .admin-profile-card input[type="text"],
    html.light-mode .admin-profile-card input[type="email"],
    html.light-mode .admin-profile-card input[type="password"] {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
    }
    body.light-mode .admin-profile-card input:focus,
    html.light-mode .admin-profile-card input:focus {
        background: #ffffff !important;
        border-color: #0d9488 !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
    }

    .admin-profile-card .card-header-border {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    body.light-mode .admin-profile-card .card-header-border,
    html.light-mode .admin-profile-card .card-header-border {
        border-bottom: 1px solid #e2e8f0 !important;
    }

    .admin-profile-card .icon-box-primary {
        background: rgba(82, 234, 210, 0.12);
        color: #52ead2;
    }
    body.light-mode .admin-profile-card .icon-box-primary,
    html.light-mode .admin-profile-card .icon-box-primary {
        background: rgba(13, 148, 136, 0.12) !important;
        color: #0d9488 !important;
    }

    .admin-profile-card .icon-box-secondary {
        background: rgba(128, 167, 255, 0.12);
        color: #80a7ff;
    }
    body.light-mode .admin-profile-card .icon-box-secondary,
    html.light-mode .admin-profile-card .icon-box-secondary {
        background: rgba(37, 99, 235, 0.12) !important;
        color: #2563eb !important;
    }

    /* Primary Save Button */
    .admin-btn-primary {
        background: linear-gradient(135deg, #52ead2 0%, #36bda8 100%) !important;
        color: #051013 !important;
        border: none !important;
        font-weight: 800 !important;
        font-size: 0.9rem !important;
        padding: 12px 24px !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        transition: all 0.25s ease !important;
        box-shadow: 0 4px 14px rgba(82, 234, 210, 0.3) !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .admin-btn-primary:hover {
        background: linear-gradient(135deg, #52ead2 0%, #36bda8 100%) !important;
        color: #051013 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 22px rgba(82, 234, 210, 0.45) !important;
    }

    /* Secondary White Button for Password Update */
    .admin-btn-white {
        background: rgba(128, 167, 255, 0.15) !important;
        color: #80a7ff !important;
        border: 1px solid rgba(128, 167, 255, 0.4) !important;
        font-weight: 700 !important;
        font-size: 0.9rem !important;
        padding: 12px 24px !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        transition: all 0.25s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .admin-btn-white:hover {
        background: rgba(128, 167, 255, 0.25) !important;
        color: #80a7ff !important;
        transform: translateY(-2px) !important;
    }

    body.light-mode .admin-btn-white,
    html.light-mode .admin-btn-white {
        background: #ffffff !important;
        color: #2563eb !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    }
    body.light-mode .admin-btn-white:hover,
    html.light-mode .admin-btn-white:hover {
        background: #ffffff !important;
        border-color: #2563eb !important;
        color: #1d4ed8 !important;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.2) !important;
        transform: translateY(-2px) !important;
    }
</style>

<section class="admin-form-section">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        
        <!-- Left Column: Account Details (Username & Email) -->
        <article class="admin-profile-card">
            <div>
                <div class="card-header-border" style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 14px;">
                    <div class="icon-box-primary" style="width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 1.15rem; font-weight: 700; margin: 0;">Account Information</h2>
                        <span class="card-subtitle" style="font-size: 0.82rem;">Update your username and email address</span>
                    </div>
                </div>

                <form id="profileInfoForm" action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 0.88rem; font-weight: 600;">Username <span style="color: #f43f5e;">*</span></label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username ?? $user->name) }}" required style="width: 100%; padding: 12px 14px; border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 0.88rem; font-weight: 600;">Email Address <span style="color: #f43f5e;">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 12px 14px; border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;">
                    </div>

                    <div style="text-align: right;">
                        <button type="submit" class="admin-btn-primary">
                            Save Profile Changes
                        </button>
                    </div>
                </form>
            </div>
        </article>

        <!-- Right Column: Password & Security -->
        <article class="admin-profile-card">
            <div>
                <div class="card-header-border" style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 14px;">
                    <div class="icon-box-secondary" style="width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 1.15rem; font-weight: 700; margin: 0;">Security & Password</h2>
                        <span class="card-subtitle" style="font-size: 0.82rem;">Update your account password</span>
                    </div>
                </div>

                <form id="profilePasswordForm" action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 0.88rem; font-weight: 600;">Current Password <span style="color: #f43f5e;">*</span></label>
                        <input type="password" name="current_password" required style="width: 100%; padding: 11px 14px; border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;">
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 0.88rem; font-weight: 600;">New Password <span style="color: #f43f5e;">*</span></label>
                        <input type="password" name="password" required style="width: 100%; padding: 11px 14px; border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;">
                        <div style="font-size: 0.76rem; color: #64748b; margin-top: 4px;">Minimum 8 characters with letters & numbers</div>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 0.88rem; font-weight: 600;">Confirm New Password <span style="color: #f43f5e;">*</span></label>
                        <input type="password" name="password_confirmation" required style="width: 100%; padding: 11px 14px; border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;">
                    </div>

                    <div style="text-align: right;">
                        <button type="submit" class="admin-btn-white">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </article>

    </div>
</section>

<script>
$(document).ready(function() {
    // Profile Info Form Submit via AJAX
    $('#profileInfoForm').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $btn = $form.find('button[type="submit"]');
        var originalText = $btn.html();

        $btn.prop('disabled', true).html('<svg class="spinner-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite; vertical-align: middle; margin-right: 6px;"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="0.8"/></svg> Saving...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                $btn.prop('disabled', false).html(originalText);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message || 'Admin profile updated successfully.',
                        confirmButtonText: 'OK'
                    });
                    if (response.user && response.user.username) {
                        $('.header-user-name').text(response.user.username);
                    }
                } else {
                    Swal.fire('Error!', response.message || 'Failed to update profile.', 'error');
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(originalText);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = Object.values(errors)[0][0];
                    Swal.fire('Validation Error', errorMsg, 'warning');
                } else {
                    Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                }
            }
        });
    });

    // Password Update Form Submit via AJAX
    $('#profilePasswordForm').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $btn = $form.find('button[type="submit"]');
        var originalText = $btn.html();

        $btn.prop('disabled', true).html('<svg class="spinner-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite; vertical-align: middle; margin-right: 6px;"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="0.8"/></svg> Updating...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                $btn.prop('disabled', false).html(originalText);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message || 'Password updated successfully.',
                        confirmButtonText: 'OK'
                    });
                    $form[0].reset();
                } else {
                    Swal.fire('Error!', response.message || 'Failed to update password.', 'error');
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(originalText);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = Object.values(errors)[0][0];
                    Swal.fire('Validation Error', errorMsg, 'warning');
                } else {
                    Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                }
            }
        });
    });
});
</script>
<style>
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endsection
