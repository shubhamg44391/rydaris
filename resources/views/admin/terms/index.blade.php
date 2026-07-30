@extends('admin.layouts.app')

@section('title', 'Terms & Conditions')

@section('main-content')

<div style="padding: 0 0 40px 0;">

    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 1.55rem; font-weight: 800; color: var(--text); margin: 0 0 6px 0; display: flex; align-items: center; gap: 10px;">
            <svg viewBox="0 0 24 24" style="width:22px;height:22px;fill:none;stroke:var(--brand, #52ead2);stroke-width:2;flex-shrink:0;">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            Terms &amp; Conditions
        </h1>
    </div>

    @if(session('success'))
        <div style="background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.3); color: #34d399; padding: 13px 18px; border-radius: 10px; margin-bottom: 22px; display: flex; align-items: center; gap: 10px; font-size: 0.92rem;">
            <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-panel" style="border-radius: 16px; padding: 32px;">

        <form action="{{ route('admin.terms.store') }}" method="POST" id="tc-form" novalidate>
            @csrf

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.84rem; font-weight: 600; color: var(--muted); margin-bottom: 8px; letter-spacing: 0.03em; text-transform: uppercase;">
                    Title <span style="color: #fb7185; font-size: 1rem;">*</span>
                </label>
                <input
                    type="text"
                    name="title"
                    id="tc_title"
                    value="{{ old('title', $page->title ?? 'Terms & Conditions') }}"
                    placeholder="e.g., Terms & Conditions"
                    style="width: 100%; padding: 12px 16px; background: var(--bg-2, rgba(255,255,255,0.04)); border: 1px solid {{ $errors->has('title') ? '#fb7185' : 'var(--line, rgba(255,255,255,0.1))' }}; border-radius: 9px; color: var(--text, #f1f5f9); font-size: 0.95rem; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
                />
                @error('title')
                    <p style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.84rem; font-weight: 600; color: var(--muted); margin-bottom: 8px; letter-spacing: 0.03em; text-transform: uppercase;">
                    Meta Title
                </label>
                <input
                    type="text"
                    name="meta_title"
                    id="tc_meta_title"
                    value="{{ old('meta_title', $page->meta_title ?? '') }}"
                    placeholder="SEO title for search engines"
                    style="width: 100%; padding: 12px 16px; background: var(--bg-2, rgba(255,255,255,0.04)); border: 1px solid {{ $errors->has('meta_title') ? '#fb7185' : 'var(--line, rgba(255,255,255,0.1))' }}; border-radius: 9px; color: var(--text, #f1f5f9); font-size: 0.95rem; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
                />
                @error('meta_title')
                    <p style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.84rem; font-weight: 600; color: var(--muted); margin-bottom: 8px; letter-spacing: 0.03em; text-transform: uppercase;">
                    Meta Description
                </label>
                <textarea
                    name="meta_description"
                    id="tc_meta_description"
                    rows="3"
                    maxlength="500"
                    placeholder="Short SEO description for search engines (max 500 characters)"
                    style="width: 100%; padding: 12px 16px; background: var(--bg-2, rgba(255,255,255,0.04)); border: 1px solid {{ $errors->has('meta_description') ? '#fb7185' : 'var(--line, rgba(255,255,255,0.1))' }}; border-radius: 9px; color: var(--text, #f1f5f9); font-size: 0.95rem; outline: none; box-sizing: border-box; resize: vertical; transition: border-color 0.2s;"
                >{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                @error('meta_description')
                    <p style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 0.84rem; font-weight: 600; color: var(--muted); margin-bottom: 8px; letter-spacing: 0.03em; text-transform: uppercase;">
                    Content / Description <span style="color: #fb7185; font-size: 1rem;">*</span>
                </label>

                <textarea
                    name="description"
                    id="tc_description"
                    rows="12"
                    placeholder="Write your full terms and conditions content here..."
                    style="width: 100%; box-sizing: border-box;"
                >{{ old('description', $page->description ?? '') }}</textarea>

                @error('description')
                    <p style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; align-items: center; gap: 12px; padding-top: 8px;">
                <button type="submit" id="tcSubmitBtn" class="btn btn-primary rounded-pill px-4" style="font-weight: 800 !important;">
                    <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:2.5;">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    {{ $page ? 'Update Terms & Conditions' : 'Save Terms & Conditions' }}
                </button>

                @if($page)
                    <span style="color: var(--muted); font-size: 0.82rem;">
                        Last updated: {{ $page->updated_at->format('d M Y, h:i A') }}
                    </span>
                @endif
            </div>

        </form>
    </div>

</div>

@section('js')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        if (typeof CKEDITOR !== 'undefined') {
            try {
                const isLightMode = document.body.classList.contains('light-mode');
                const editor = CKEDITOR.replace('tc_description', {
                    height: 480,
                    versionCheck: false,
                    uiColor: isLightMode ? '#f1f5f9' : '#2a3248',
                    contentsCss: isLightMode 
                        ? 'body { background-color: #ffffff; color: #0f172a; font-family: Inter, sans-serif; } a { color: #0284c7; }' 
                        : 'body { background-color: #050711; color: #f8fafc; font-family: Inter, sans-serif; } a { color: #52ead2; }'
                });

                const updateEditorTheme = () => {
                    if (editor && editor.document) {
                        const body = editor.document.getBody();
                        if (body) {
                            const isLight = document.body.classList.contains('light-mode');
                            if (isLight) {
                                body.setStyle('background-color', '#ffffff');
                                body.setStyle('color', '#0f172a');
                            } else {
                                body.setStyle('background-color', '#050711');
                                body.setStyle('color', '#f8fafc');
                            }
                        }
                    }
                };

                editor.on('instanceReady', updateEditorTheme);
                const observer = new MutationObserver(updateEditorTheme);
                observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });
            } catch (err) {
                console.error('CKEditor init error:', err);
            }
        }

        // Real-time error clearing
        $('#tc_title').on('input change', function () {
            if ($.trim($(this).val())) {
                $(this).css('border-color', 'var(--line, rgba(255,255,255,0.1))');
                $(this).next('.ajax-error').remove();
            }
        });

        // Submit form via jQuery AJAX
        $('#tc-form').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $submitBtn = $('#tcSubmitBtn');
            var origText = $submitBtn.text();

            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.tc_description) {
                CKEDITOR.instances.tc_description.updateElement();
            }

            $('.ajax-error').remove();
            $('#tc_title').css('border-color', 'var(--line, rgba(255,255,255,0.1))');

            var titleVal = $.trim($('#tc_title').val());
            var descVal = $.trim($('#tc_description').val());
            var hasError = false;

            if (!titleVal) {
                $('#tc_title').css('border-color', '#fb7185');
                $('#tc_title').after('<p class="ajax-error" style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px; font-weight: 600;">Title is required.</p>');
                hasError = true;
            }

            if (!descVal) {
                $('#tc_description').parent().append('<p class="ajax-error" style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px; font-weight: 600;">Description / Content is required.</p>');
                hasError = true;
            }

            if (hasError) return;

            $submitBtn.prop('disabled', true).css('opacity', '0.65');

            var formData = new FormData(this);

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (data) {
                    $submitBtn.prop('disabled', false).css('opacity', '1');
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Terms & Conditions saved successfully!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (xhr) {
                    $submitBtn.prop('disabled', false).css('opacity', '1');
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, msgs) {
                            if (field === 'title') {
                                $('#tc_title').css('border-color', '#fb7185');
                                $('#tc_title').after('<p class="ajax-error" style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px; font-weight: 600;">' + msgs[0] + '</p>');
                            } else if (field === 'description') {
                                $('#tc_description').parent().append('<p class="ajax-error" style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px; font-weight: 600;">' + msgs[0] + '</p>');
                            }
                        });
                        var firstErr = Object.values(errors)[0][0];
                        Swal.fire('Validation Error', firstErr, 'warning');
                    } else {
                        Swal.fire('Error!', 'An error occurred while saving Terms & Conditions.', 'error');
                    }
                }
            });
        });
    });
</script>
@endsection

@endsection
