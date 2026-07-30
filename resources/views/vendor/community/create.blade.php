@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Create Community Post</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form id="communityPostForm" method="POST" action="{{ route('vendor.community.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Post Title -->
                <div class="mb-4">
                    <label for="title" class="form-label-custom">Post Title <span style="color: #fb7185;">*</span></label>
                    <input type="text" class="form-control form-input-custom @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title') }}" required placeholder="Enter post title" style="border: 1px solid var(--line, #d7e0e8); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; color: var(--text, #1e293b);" />
                    @error('title')
                        <div class="invalid-feedback d-block" style="margin-top: 8px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Post Content -->
                <div class="mb-4">
                    <label for="content" class="form-label-custom">Post Content <span style="color: #fb7185;">*</span></label>
                    <textarea class="form-control form-input-custom @error('content') is-invalid @enderror" id="content" name="content"
                        rows="7" required placeholder="Write your community post content here..." style="border: 1px solid var(--line, #d7e0e8); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; color: var(--text, #1e293b);">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback d-block" style="margin-top: 8px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Attachment with Custom Upload & Real-time Preview -->
                <div class="mb-4">
                    <label class="form-label-custom">Attachment Image (Optional)</label>
                    
                    <div id="upload-box" style="border: 2px dashed var(--line, #cbd5e1); border-radius: var(--radius, 10px); padding: 24px; text-align: center; background: var(--bg-2, #f8fafc); cursor: pointer; transition: border-color 0.2s;" onclick="document.getElementById('image').click();">
                        <input type="file" id="image" name="image" accept="image/*" class="d-none" onchange="handleImagePreview(this)">
                        
                        <!-- Upload Prompt Placeholder -->
                        <div id="upload-prompt">
                            <svg viewBox="0 0 24 24" style="width: 42px; height: 42px; fill: none; stroke: var(--brand, #52ead2); stroke-width: 2; margin-bottom: 8px;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <p style="margin: 0 0 4px 0; font-weight: 700; color: var(--text, #1e293b); font-size: 0.95rem;">Click to upload image</p>
                            <span style="color: var(--muted, #64748b); font-size: 0.82rem;">Supported formats: PNG, JPG, JPEG, WEBP (Max 5MB)</span>
                        </div>

                        <!-- Image Preview Box -->
                        <div id="preview-box" style="display: none; flex-direction: column; align-items: center; justify-content: center; text-align: center; margin-top: 8px;">
                            <img id="preview-img" src="#" alt="Preview" style="max-height: 250px; max-width: 100%; border-radius: 8px; border: 1px solid var(--line, #cbd5e1); object-fit: contain; margin: 0 auto 12px auto; display: block;">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation(); removeImage();" style="border-radius: 20px; font-size: 0.8rem; padding: 6px 16px; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="bx bx-trash me-1"></i> Remove Image
                            </button>
                        </div>
                    </div>
                    @error('image')
                        <div class="invalid-feedback d-block" style="margin-top: 8px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" id="submitBtn" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer;">Publish Post</button>
                    <a href="{{ route('vendor.community.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Preview & AJAX Submit Scripts -->
    <script>
    function handleImagePreview(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('upload-prompt').style.display = 'none';
                document.getElementById('preview-box').style.display = 'flex';
            }
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        const input = document.getElementById('image');
        input.value = '';
        document.getElementById('preview-img').src = '#';
        document.getElementById('preview-box').style.display = 'none';
        document.getElementById('upload-prompt').style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('communityPostForm');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Publishing...';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Community post published successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        window.location.href = data.redirect || "{{ route('vendor.community.index') }}";
                    });
                } else {
                    alert(data.message || 'An error occurred while publishing the post.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('AJAX error:', error);
                form.submit();
            });
        });
    });
    </script>
@endsection
