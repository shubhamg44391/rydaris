@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title" style="color: var(--text);">General Contact &amp; Support Settings</h2>
            </div>
        </div>
        
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.settings.general.update') }}" id="generalSettingsForm" enctype="multipart/form-data">
                @csrf

                {{-- WEBSITE BRANDING & LOGO SECTION --}}
                <div style="background: var(--panel-strong, rgba(255, 255, 255, 0.02)); border: 1px solid var(--line, rgba(82, 234, 210, 0.1)); border-radius: var(--radius); padding: 24px; margin-bottom: 24px;">
                    <div style="margin-bottom: 20px; border-bottom: 1px solid var(--line, rgba(255,255,255,0.05)); padding-bottom: 15px;">
                        <h4 style="margin: 0; color: var(--text, #f8fafc); font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand, #52ead2);">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                            </svg>
                            Website Branding &amp; Logo Settings
                        </h4>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                        <!-- Site Logo (Dark Theme) Upload -->
                        <div>
                            <label for="site_logo" class="form-label-custom">Logo (For Dark Theme)</label>
                            <input type="file" 
                                   class="form-control form-input-custom @error('site_logo') is-invalid @enderror" 
                                   id="site_logo" 
                                   name="site_logo"
                                   accept="image/*"
                                   onchange="previewImage(this, 'siteLogoPreview')" />
                            <small style="color: var(--muted); display: block; margin-top: 4px;">Recommended: Light SVG/PNG for dark backgrounds (Max 2MB)</small>
                            @error('site_logo')
                                <div style="color: #ef4444; font-size: 0.82rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                            
                            <div style="margin-top: 14px; padding: 12px; background: #050711; border: 1px dashed rgba(255,255,255,0.15); border-radius: 8px; display: flex; align-items: center; gap: 14px; justify-content: center; min-height: 60px;">
                                <img id="siteLogoPreview" 
                                     src="{{ $settings->site_logo ? asset('storage/' . $settings->site_logo) : asset('assets/logo/rydaris-logo.png') }}" 
                                     alt="Dark Theme Logo" 
                                     style="max-height: 38px; max-width: 100%; object-fit: contain;">
                            </div>
                        </div>

                        <!-- Site Logo (Light Theme) Upload -->
                        <div>
                            <label for="site_logo_light" class="form-label-custom">Logo (For Light Theme)</label>
                            <input type="file" 
                                   class="form-control form-input-custom @error('site_logo_light') is-invalid @enderror" 
                                   id="site_logo_light" 
                                   name="site_logo_light"
                                   accept="image/*"
                                   onchange="previewImage(this, 'siteLogoLightPreview')" />
                            <small style="color: var(--muted); display: block; margin-top: 4px;">Recommended: Dark SVG/PNG for light backgrounds (Max 2MB)</small>
                            @error('site_logo_light')
                                <div style="color: #ef4444; font-size: 0.82rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                            
                            <div style="margin-top: 14px; padding: 12px; background: #f8fafc; border: 1px dashed rgba(15,23,42,0.15); border-radius: 8px; display: flex; align-items: center; gap: 14px; justify-content: center; min-height: 60px;">
                                <img id="siteLogoLightPreview" 
                                     src="{{ $settings->site_logo_light ? asset('storage/' . $settings->site_logo_light) : asset('assets/logo/rydaris-logo-light.png') }}" 
                                     alt="Light Theme Logo" 
                                     style="max-height: 38px; max-width: 100%; object-fit: contain;">
                            </div>
                        </div>

                        <!-- Favicon Upload -->
                        <div>
                            <label for="favicon" class="form-label-custom">Favicon (Browser Tab Icon)</label>
                            <input type="file" 
                                   class="form-control form-input-custom @error('favicon') is-invalid @enderror" 
                                   id="favicon" 
                                   name="favicon"
                                   accept="image/*"
                                   onchange="previewImage(this, 'faviconPreview')" />
                            <small style="color: var(--muted); display: block; margin-top: 4px;">Recommended: 32x32 PNG/ICO (Max 1MB)</small>
                            @error('favicon')
                                <div style="color: #ef4444; font-size: 0.82rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror

                            <div style="margin-top: 14px; padding: 12px; background: var(--bg-2, #0b1020); border: 1px dashed var(--line, rgba(255,255,255,0.1)); border-radius: 8px; display: flex; align-items: center; gap: 14px; justify-content: center; min-height: 60px;">
                                <img id="faviconPreview" 
                                     src="{{ $settings->favicon ? asset('storage/' . $settings->favicon) : asset('assets/logo/favicon.png') }}" 
                                     alt="Favicon" 
                                     style="width: 28px; height: 28px; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTACT DETAILS SECTION -->
                <div style="background: var(--panel-strong, rgba(255, 255, 255, 0.02)); border: 1px solid var(--line, rgba(82, 234, 210, 0.1)); border-radius: var(--radius); padding: 24px; margin-bottom: 24px;">
                    <div style="margin-bottom: 20px; border-bottom: 1px solid var(--line, rgba(255,255,255,0.05)); padding-bottom: 15px;">
                        <h4 style="margin: 0; color: var(--text, #f8fafc); font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand, #52ead2);">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            Contact Details Management
                        </h4>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label for="contact_email" class="form-label-custom">Contact / Support Email</label>
                            <input type="email" 
                                   class="form-control form-input-custom @error('contact_email') is-invalid @enderror" 
                                   id="contact_email" 
                                   name="contact_email"
                                   value="{{ old('contact_email', $settings->contact_email ?? 'support@rydaris.com') }}" 
                                   placeholder="support@rydaris.com" 
                                   required />
                            @error('contact_email')
                                <div style="color: #ef4444; font-size: 0.82rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_phone" class="form-label-custom">Contact Phone Number</label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('contact_phone') is-invalid @enderror" 
                                   id="contact_phone" 
                                   name="contact_phone"
                                   value="{{ old('contact_phone', $settings->contact_phone ?? '+918882688646') }}" 
                                   placeholder="+918882688646" 
                                   required />
                            @error('contact_phone')
                                <div style="color: #ef4444; font-size: 0.82rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- AJAX & SweetAlert Modal Script -->
    <script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('generalSettingsForm');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Saving...';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;

                // Dynamically detect theme to style SweetAlert accordingly
                const isLight = document.body.classList.contains('light-mode');
                const swalBg = isLight ? '#ffffff' : '#0b1020';
                const swalColor = isLight ? '#0f172a' : '#f8fafc';
                const confirmBtnColor = '#52ead2';

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'General contact settings updated successfully.',
                        background: swalBg,
                        color: swalColor,
                        confirmButtonColor: confirmBtnColor,
                        confirmButtonText: 'OK'
                    });
                    
                    // Update header/branding logos dynamically on successful save
                    if (data.site_logo_url) {
                        const darkLogoEl = document.getElementById('siteLogoPreview');
                        if (darkLogoEl) darkLogoEl.src = data.site_logo_url;
                        
                        // Also update any sidebar/topbar main logos that use it
                        const sidebarLogo = document.querySelector('.admin-sidebar .brand-full img');
                        if (sidebarLogo && !isLight) sidebarLogo.src = data.site_logo_url;
                    }
                    if (data.site_logo_light_url) {
                        const lightLogoEl = document.getElementById('siteLogoLightPreview');
                        if (lightLogoEl) lightLogoEl.src = data.site_logo_light_url;
                        
                        const sidebarLogo = document.querySelector('.admin-sidebar .brand-full img');
                        if (sidebarLogo && isLight) sidebarLogo.src = data.site_logo_light_url;
                    }
                    if (data.favicon_url) {
                        const faviconEl = document.getElementById('faviconPreview');
                        if (faviconEl) faviconEl.src = data.favicon_url;
                        
                        // Dynamically update the document head favicon
                        const headFavicon = document.querySelector('link[rel="icon"]');
                        if (headFavicon) headFavicon.href = data.favicon_url;
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to update settings.',
                        background: swalBg,
                        color: swalColor,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Try Again'
                    });
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                
                const isLight = document.body.classList.contains('light-mode');
                const swalBg = isLight ? '#ffffff' : '#0b1020';
                const swalColor = isLight ? '#0f172a' : '#f8fafc';
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    background: swalBg,
                    color: swalColor,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
    </script>
@endsection
