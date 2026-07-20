@extends('admin.layouts.app')

@section('main-content')
    
    <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div>
            <h4 style="margin: 0; color: #fff; font-weight: 700; font-size: 1.4rem;">Create Custom Page</h4>
            <p style="margin: 4px 0 0; color: var(--muted); font-size: 0.85rem;">
                <a href="{{ route('dashboard') }}" style="color: var(--brand); text-decoration: none;">Dashboard</a> / 
                <a href="{{ route('admin.pages.index') }}" style="color: var(--brand); text-decoration: none;">Pages</a> / 
                Create
            </p>
        </div>
        <div>
            <a href="{{ route('admin.pages.index') }}" class="admin-action" style="border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; background: transparent; text-decoration: none; border-radius: var(--radius); padding: 8px 16px; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Back to List
            </a>
        </div>
    </div>

    @php
        $allowedPredefined = [
            'help-center' => 'Help Center',
            'roi-guide' => 'ROI Guide',
            'fleet-playbook' => 'Fleet Playbook',
            'support-desk' => 'Support Desk',
            'sitemap' => 'Sitemap',
            'security' => 'Security',
            'privacy-policy' => 'Privacy Policy'
        ];

        $existingSlugs = \App\Models\Page::pluck('slug')->toArray();
        $missingPredefined = [];
        foreach($allowedPredefined as $slug => $label) {
            if(!in_array($slug, $existingSlugs, true) || $slug === request('slug')) {
                $missingPredefined[$slug] = $label;
            }
        }
    @endphp

    
    <form id="createPageForm" action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="create-page-grid" style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 24px;">
            
            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="admin-panel" style="padding: 24px; border: 1px solid var(--line); border-radius: var(--radius); background: var(--panel);">
                    <div style="margin-bottom: 20px;">
                        <label class="form-label" for="title" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; display: block; color: #fff;">Page Title <span style="color: #ef4444;">*</span></label>
                        <select name="title" id="title" class="form-control" required style="background: rgba(255,255,255,0.03); border: 1px solid var(--line); border-radius: 8px; padding: 12px; font-size: 0.95rem; color: #fff; width: 100%; cursor: pointer;">
                            <option value="" style="background: #061218;">Select Page Title</option>
                            @foreach($missingPredefined as $slug => $label)
                                <option value="{{ $label }}" data-slug="{{ $slug }}" {{ request('slug') === $slug ? 'selected' : '' }} style="background: #061218;">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="error-msg" id="error-title" style="color: #ef4444; font-size: 0.8rem; margin-top: 6px; display: none;"></div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <input type="hidden" name="slug" id="slug" value="{{ request('slug') ?? old('slug') }}">
                        <p style="margin: 0; font-size: 0.82rem; color: var(--muted);">
                            Public Link preview: <code style="color: var(--brand); font-family: monospace;">{{ url('/page') }}/<span id="slug-preview">page-slug</span></code>
                        </p>
                        <div class="error-msg" id="error-slug" style="color: #ef4444; font-size: 0.8rem; margin-top: 6px; display: none;"></div>
                    </div>

                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <label class="form-label" for="content" style="font-weight: 600; font-size: 0.9rem; margin: 0; color: #fff;">Page Content (HTML Allowed) <span style="color: #ef4444;">*</span></label>
                            <span id="char-count" style="font-size: 0.75rem; color: var(--muted);">0 characters</span>
                        </div>
                        <textarea name="content" id="content" rows="14" class="form-control" required placeholder="Write page content here... Supports standard HTML formatting." oninput="updateCharCount()" style="background: rgba(255,255,255,0.03); border: 1px solid var(--line); border-radius: 8px; padding: 12px; font-size: 0.95rem; font-family: monospace; color: #fff; width: 100%; resize: vertical; line-height: 1.6;">{{ old('content') }}</textarea>
                        <div class="error-msg" id="error-content" style="color: #ef4444; font-size: 0.8rem; margin-top: 6px; display: none;"></div>
                    </div>
                </div>
            </div>

            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                
                <div class="admin-panel" style="padding: 20px; border: 1px solid var(--line); border-radius: var(--radius); background: var(--panel);">
                    <h5 style="margin: 0 0 15px; color: #fff; font-size: 1rem; font-weight: 700; border-bottom: 1px solid var(--line); padding-bottom: 10px;">Publishing</h5>
                    
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                        <span style="display: inline-block; width: 8px; height: 8px; background: var(--brand); border-radius: 50%;"></span>
                        <span style="color: var(--muted); font-size: 0.85rem; font-weight: 600;">Status: Drafting</span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <button type="submit" id="submitBtn" class="admin-action" style="background: var(--brand); color: #061218; font-weight: 700; width: 100%; padding: 12px; border-radius: 8px; border: none; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s;">
                            <i class="fa-solid fa-save"></i> Save Page
                        </button>
                        <button type="reset" onclick="resetFormPreview()" class="admin-action" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--line); color: var(--text); width: 100%; padding: 10px; border-radius: 8px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;">
                            Reset Form
                        </button>
                    </div>
                </div>

                
                <div class="admin-panel" style="padding: 20px; border: 1px solid var(--line); border-radius: var(--radius); background: var(--panel);">
                    <h5 style="margin: 0 0 15px; color: var(--brand); font-size: 1rem; font-weight: 700; border-bottom: 1px solid var(--line); padding-bottom: 10px;">SEO Settings</h5>
                    
                    <div style="margin-bottom: 18px;">
                        <label class="form-label" for="meta_title" style="font-weight: 600; font-size: 0.82rem; margin-bottom: 6px; display: block; color: var(--muted);">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="SEO title (recommended length: 50-60 chars)" style="background: rgba(255,255,255,0.03); border: 1px solid var(--line); border-radius: 8px; padding: 10px; font-size: 0.9rem; color: #fff; width: 100%;">
                        <div class="error-msg" id="error-meta_title" style="color: #ef4444; font-size: 0.8rem; margin-top: 6px; display: none;"></div>
                    </div>

                    <div>
                        <label class="form-label" for="meta_description" style="font-weight: 600; font-size: 0.82rem; margin-bottom: 6px; display: block; color: var(--muted);">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="4" class="form-control" placeholder="Brief page summary for search engine snippets..." style="background: rgba(255,255,255,0.03); border: 1px solid var(--line); border-radius: 8px; padding: 10px; font-size: 0.9rem; color: #fff; width: 100%; resize: none; line-height: 1.5;">{{ old('meta_description') }}</textarea>
                        <div class="error-msg" id="error-meta_description" style="color: #ef4444; font-size: 0.8rem; margin-top: 6px; display: none;"></div>
                    </div>
                </div>

            </div>

        </div>
    </form>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    let pageEditor;
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof CKEDITOR !== 'undefined') {
            pageEditor = CKEDITOR.replace('content', {
                height: 480,
                versionCheck: false,
                uiColor: '#2a3248',
                contentsCss: 'body { background-color: #050711; color: #f8fafc; font-family: Inter, sans-serif; } a { color: #52ead2; }'
            });

            pageEditor.on('instanceReady', function() {
                updateCharCount();
            });

            pageEditor.on('change', function() {
                updateCharCount();
            });
        }

        const titleSelect = document.getElementById('title');
        if (titleSelect) {
            titleSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const slug = selectedOption ? selectedOption.getAttribute('data-slug') : '';
                document.getElementById('slug').value = slug || '';
                document.getElementById('slug-preview').innerText = slug ? slug : 'page-slug';
            });

            // Initial check on load
            if (titleSelect.value) {
                const selectedOption = titleSelect.options[titleSelect.selectedIndex];
                const slug = selectedOption ? selectedOption.getAttribute('data-slug') : '';
                document.getElementById('slug').value = slug || '';
                document.getElementById('slug-preview').innerText = slug ? slug : 'page-slug';
            }
        }
    });

    function updateCharCount() {
        let text = '';
        if (pageEditor) {
            text = pageEditor.getData();
        } else {
            text = document.getElementById('content').value;
        }
        document.getElementById('char-count').innerText = `${text.length} characters`;
    }

    function resetFormPreview() {
        setTimeout(() => {
            document.getElementById('slug-preview').innerText = 'page-slug';
            if (pageEditor) {
                pageEditor.setData('');
            }
            updateCharCount();
            // Clear any validation visual highlights
            document.querySelectorAll('.error-msg').forEach(el => {
                el.style.display = 'none';
                el.innerText = '';
            });
            document.querySelectorAll('.form-control').forEach(el => {
                el.style.borderColor = 'rgba(255,255,255,0.14)';
            });
        }, 50);
    }

    // AJAX Form submission
    document.getElementById('createPageForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        const originalBtnHtml = submitBtn.innerHTML;

        // Sync CKEditor data to textarea
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.content) {
            CKEDITOR.instances.content.updateElement();
        }

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
                    // Throw validation errors
                    throw { status: response.status, data: data };
                }
                return data;
            });
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message || 'Page created successfully.',
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
                // Laravel validation failed, show inline errors
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
                
                // Show standard warning alert
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
                // Generic server error
                console.error(error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong while saving the page. Please try again.',
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
