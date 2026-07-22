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
        <p style="color: var(--muted); font-size: 0.92rem; margin: 0;">
            Manage the platform Terms &amp; Conditions shown on the public website.
        </p>
    </div>

    @if(session('success'))
        <div style="background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.3); color: #34d399; padding: 13px 18px; border-radius: 10px; margin-bottom: 22px; display: flex; align-items: center; gap: 10px; font-size: 0.92rem;">
            <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-panel" style="border-radius: 16px; padding: 32px;">

        <form action="{{ route('admin.terms.store') }}" method="POST" id="tc-form">
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
                    onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='{{ $errors->has('title') ? '#fb7185' : 'var(--line, rgba(255,255,255,0.1))' }}'"
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
                    onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='{{ $errors->has('meta_title') ? '#fb7185' : 'var(--line, rgba(255,255,255,0.1))' }}'"
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
                    onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='{{ $errors->has('meta_description') ? '#fb7185' : 'var(--line, rgba(255,255,255,0.1))' }}'"
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
                <button type="submit"
                    style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: var(--brand, #52ead2); color: #051013; border: none; border-radius: 9px; font-weight: 700; font-size: 0.94rem; cursor: pointer; transition: opacity 0.2s; letter-spacing: 0.01em;"
                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:2;">
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
    (function() {
        try {
            if (typeof CKEDITOR !== 'undefined') {
                const isLightMode = document.body.classList.contains('light-mode');
                const editor = CKEDITOR.replace('tc_description', {
                    height: 480,
                    versionCheck: false,
                    uiColor: isLightMode ? '#f1f5f9' : '#2a3248',
                    contentsCss: isLightMode 
                        ? 'body { background-color: #ffffff; color: #0f172a; font-family: Inter, sans-serif; } a { color: #0284c7; }' 
                        : 'body { background-color: #050711; color: #f8fafc; font-family: Inter, sans-serif; } a { color: #52ead2; }'
                });

                // Function to update internal editor body style based on active theme
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

                // Sync styling as soon as the editor instance is ready
                editor.on('instanceReady', updateEditorTheme);

                // Watch body class list for changes and sync theme dynamically
                const observer = new MutationObserver(updateEditorTheme);
                observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });

            } else {
                console.warn('CKEDITOR is not defined, skipping initialization.');
            }
        } catch (error) {
            console.error('Error initializing CKEDITOR:', error);
        }
    })();
</script>
@endsection

@endsection
