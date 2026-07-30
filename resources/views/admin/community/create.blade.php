@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Create Community Post (Admin)</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form id="adminCommunityForm" method="POST" action="{{ route('admin.community.store') }}" enctype="multipart/form-data" novalidate>
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
                        rows="7" required placeholder="Write post announcement, guide, or update for vendors..." style="border: 1px solid var(--line, #d7e0e8); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; color: var(--text, #1e293b);">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback d-block" style="margin-top: 8px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Attachment with Drag & Drop / Real-time Preview -->
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
                    <button type="submit" id="submitBtn" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800 !important; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer;">Publish Post</button>
                    <a href="{{ route('admin.community.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Preview & jQuery AJAX Submit Scripts -->
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

    $(document).ready(function () {
        // Real-time error clearing on typing
        $('#title, #content').on('input change', function () {
            if ($.trim($(this).val())) {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').hide();
            }
        });

        $('#adminCommunityForm').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $submitBtn = $('#submitBtn');
            var originalText = $submitBtn.html();

            // Client-side validation
            var titleVal = $.trim($('#title').val());
            var contentVal = $.trim($('#content').val());
            var hasError = false;
            var $firstInvalid = null;

            // Clear previous errors
            $('.is-invalid').removeClass('is-invalid');
            $('.ajax-error').remove();

            if (!titleVal) {
                $('#title').addClass('is-invalid');
                $('#title').parent().append('<div class="invalid-feedback d-block ajax-error" style="margin-top: 8px; color: #fb7185; font-weight: 600; font-size: 0.85rem;">Post Title is required.</div>');
                hasError = true;
                if (!$firstInvalid) $firstInvalid = $('#title');
            }

            if (!contentVal) {
                $('#content').addClass('is-invalid');
                $('#content').parent().append('<div class="invalid-feedback d-block ajax-error" style="margin-top: 8px; color: #fb7185; font-weight: 600; font-size: 0.85rem;">Post Content is required.</div>');
                hasError = true;
                if (!$firstInvalid) $firstInvalid = $('#content');
            }

            if (hasError) {
                if ($firstInvalid) {
                    $('html, body').animate({ scrollTop: $firstInvalid.offset().top - 100 }, 300);
                    $firstInvalid.focus();
                }
                return;
            }

            $submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Publishing...');

            var formData = new FormData(this);

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            title: 'Published!',
                            text: data.message || 'Community post published successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function () {
                            window.location.href = data.redirect || "{{ route('admin.community.index') }}";
                        });
                    } else {
                        $submitBtn.prop('disabled', false).html(originalText);
                        Swal.fire('Error!', data.message || 'Failed to publish post.', 'error');
                    }
                },
                error: function (xhr) {
                    $submitBtn.prop('disabled', false).html(originalText);

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, msgs) {
                            var $input = $('#' + field);
                            if (!$input.length) $input = $('[name="' + field + '"]');
                            if ($input.length) {
                                $input.addClass('is-invalid');
                                $input.parent().append('<div class="invalid-feedback d-block ajax-error" style="margin-top: 8px; color: #fb7185; font-weight: 600; font-size: 0.85rem;">' + msgs[0] + '</div>');
                            }
                        });
                        var firstErr = Object.values(errors)[0][0];
                        Swal.fire('Validation Error', firstErr, 'warning');
                    } else {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'An error occurred while publishing the post.';
                        Swal.fire('Error!', msg, 'error');
                    }
                }
            });
        });
    });
    </script>
@endsection
