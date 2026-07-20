@extends('admin.layouts.app')

@section('title', 'Edit Page SEO | Rydaris Admin')

@section('main-content')
    
    <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div>
            <h4 style="margin: 0; color: #fff; font-weight: 700; font-size: 1.4rem;">Edit Page SEO Tags</h4>
            <p style="margin: 4px 0 0; color: var(--muted); font-size: 0.85rem;">
                <a href="{{ route('dashboard') }}" style="color: var(--brand); text-decoration: none;">Dashboard</a> / 
                <a href="{{ route('admin.seo-settings.index', ['type' => $seoMetadata->portal_type]) }}" style="color: var(--brand); text-decoration: none;">SEO Settings</a> / 
                Edit
            </p>
        </div>
        <div>
            <a href="{{ route('admin.seo-settings.index', ['type' => $seoMetadata->portal_type]) }}" class="admin-action" style="border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; background: transparent; text-decoration: none; border-radius: var(--radius); padding: 8px 16px; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Back to List
            </a>
        </div>
    </div>

    
    <form id="editSeoForm" action="{{ route('admin.seo-settings.update', $seoMetadata->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="edit-seo-grid" style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 24px;">
            
            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="admin-panel" style="padding: 24px; border: 1px solid var(--line); border-radius: var(--radius); background: var(--panel);">
                    
                    <div style="margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label class="form-label" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; display: block; color: var(--muted);">Page Name</label>
                            <input type="text" class="form-control" value="{{ $seoMetadata->page_name }}" style="background: rgba(255,255,255,0.01) !important; border: 1px solid var(--line); border-radius: 8px; padding: 12px; font-size: 0.95rem; color: #fff; width: 100%; cursor: not-allowed; opacity: 0.8;" readonly>
                        </div>
                        <div>
                            <label class="form-label" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; display: block; color: var(--muted);">URL Path</label>
                            <input type="text" class="form-control" value="{{ $seoMetadata->url_path }}" style="background: rgba(255,255,255,0.01) !important; border: 1px solid var(--line); border-radius: 8px; padding: 12px; font-size: 0.95rem; color: #fff; width: 100%; cursor: not-allowed; opacity: 0.8;" readonly>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="form-label" for="meta_title" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; display: block; color: #fff;">Meta Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control" required value="{{ old('meta_title', $seoMetadata->meta_title) }}" placeholder="e.g. Premium Fleet & Car Rental Solutions | Rydaris" style="background: rgba(255,255,255,0.03) !important; border: 1px solid var(--line); border-radius: 8px; padding: 12px; font-size: 0.95rem; color: #fff; width: 100%;">
                        <div class="error-msg" id="error-meta_title" style="color: #ef4444; font-size: 0.8rem; margin-top: 6px; display: none;"></div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="form-label" for="meta_description" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; display: block; color: #fff;">Meta Description <span style="color: #ef4444;">*</span></label>
                        <textarea name="meta_description" id="meta_description" class="form-control" required rows="4" placeholder="Enter SEO page description..." style="background: rgba(255,255,255,0.03) !important; border: 1px solid var(--line); border-radius: 8px; padding: 12px; font-size: 0.95rem; color: #fff; width: 100%; height: 120px; resize: vertical;">{{ old('meta_description', $seoMetadata->meta_description) }}</textarea>
                        <div class="error-msg" id="error-meta_description" style="color: #ef4444; font-size: 0.8rem; margin-top: 6px; display: none;"></div>
                    </div>
                     <div style="margin-bottom: 20px;">
                        <label class="form-label" for="keyword" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; display: block; color: #fff;">Keywords</label>
                        <textarea name="keyword" id="keyword" class="form-control" rows="4" placeholder="Enter SEO keywords (comma-separated)..." style="background: rgba(255,255,255,0.03) !important; border: 1px solid var(--line); border-radius: 8px; padding: 12px; font-size: 0.95rem; color: #fff; width: 100%; height: 100px; resize: vertical;">{{ old('keyword', $seoMetadata->keyword) }}</textarea>
                        <div class="error-msg" id="error-keyword" style="color: #ef4444; font-size: 0.8rem; margin-top: 6px; display: none;"></div>
                    </div>

                </div>
            </div>

            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="admin-panel" style="padding: 24px; border: 1px solid var(--line); border-radius: var(--radius); background: var(--panel);">
                    <h3 style="margin-top: 0; margin-bottom: 20px; color: #fff; font-size: 1.1rem; font-weight: 600; border-bottom: 1px solid var(--line); padding-bottom: 12px;">Publish Info</h3>
                    
                    <div style="margin-bottom: 15px; display: flex; justify-content: space-between; font-size: 0.85rem;">
                        <span style="color: var(--muted);">Portal:</span>
                        <span style="color: #fff; font-weight: 600; text-transform: uppercase;">{{ $seoMetadata->portal_type }}</span>
                    </div>
                    
                    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; font-size: 0.85rem;">
                        <span style="color: var(--muted);">Updated At:</span>
                        <span style="color: #fff;">{{ $seoMetadata->updated_at->diffForHumans() }}</span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" id="submitBtn" class="admin-action" style="background: var(--brand); color: #061218; font-weight: 700; border-radius: 8px; padding: 12px 20px; width: 100%; border: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>
@endsection

@section('js')
<script>
    // AJAX Form submission
    document.getElementById('editSeoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        const originalBtnHtml = submitBtn.innerHTML;

        // Clear previous error messages & highlight states
        document.querySelectorAll('.error-msg').forEach(el => {
            el.style.display = 'none';
            el.innerText = '';
        });
        document.querySelectorAll('.form-control').forEach(el => {
            el.style.borderColor = 'rgba(255, 255, 255, 0.14)';
        });

        // Set Loading State
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    throw { status: response.status, data: data };
                }
                return data;
            });
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message || 'SEO Settings updated successfully.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    background: 'rgba(11, 16, 32, 0.95)',
                    color: '#f8fafc'
                }).then(() => {
                    window.location.href = data.redirect_url;
                });
            }
        })
        .catch(error => {
            // Restore button state
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.innerHTML = originalBtnHtml;

            if (error.status === 422 && error.data && error.data.errors) {
                const errors = error.data.errors;
                for (const key in errors) {
                    const inputField = document.getElementById(key);
                    const errorContainer = document.getElementById(`error-${key}`);
                    
                    if (inputField) {
                        inputField.style.borderColor = '#ef4444';
                    }
                    if (errorContainer) {
                        errorContainer.innerText = errors[key][0];
                        errorContainer.style.display = 'block';
                    }
                }
                
                Swal.fire({
                    title: 'Validation Failed',
                    text: 'Please review and correct the highlighted fields.',
                    icon: 'warning',
                    confirmButtonText: 'Got it',
                    background: 'rgba(11, 16, 32, 0.95)',
                    color: '#f8fafc',
                    confirmButtonColor: '#52ead2'
                });
            } else {
                console.error(error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong while saving. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    background: 'rgba(11, 16, 32, 0.95)',
                    color: '#f8fafc',
                    confirmButtonColor: '#52ead2'
                });
            }
        });
    });
</script>
@endsection
