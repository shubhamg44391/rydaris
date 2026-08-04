@extends('admin.layouts.app')

@section('title', 'Terms & Conditions & Agreement Management')

@section('main-content')

<div style="padding: 0 0 40px 0;">

    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 1.55rem; font-weight: 800; color: var(--text, #f1f5f9); margin: 0 0 6px 0; display: flex; align-items: center; gap: 10px;">
            <svg viewBox="0 0 24 24" style="width:22px;height:22px;fill:none;stroke:var(--brand, #52ead2);stroke-width:2;flex-shrink:0;">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            Terms &amp; Conditions &amp; Agreement Management
        </h1>
        <p style="color: var(--muted, #94a3b8); font-size: 0.92rem; margin: 0;">
            Customize your platform Terms &amp; Conditions and Vehicle Rental Agreement terms below.
        </p>
    </div>

    @if(session('success'))
        <div style="background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.3); color: #34d399; padding: 13px 18px; border-radius: 10px; margin-bottom: 22px; display: flex; align-items: center; gap: 10px; font-size: 0.92rem;">
            <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-panel" style="border-radius: 16px; padding: 32px;">

        <form action="{{ route('vendor.pages.store') }}" method="POST" id="vendor-tc-form" novalidate>
            @csrf

            <!-- Section 1: Terms & Conditions -->
            <div style="margin-bottom: 35px; border-bottom: 1px solid var(--line, rgba(255,255,255,0.08)); padding-bottom: 30px;">
                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--brand, #52ead2); margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Terms &amp; Conditions
                </h4>

                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-size: 0.84rem; font-weight: 600; color: var(--muted, #94a3b8); margin-bottom: 8px; letter-spacing: 0.03em; text-transform: uppercase;">
                        Terms Title <span style="color: #fb7185; font-size: 1rem;">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="vendor_tc_title"
                        value="{{ old('title', $page->title ?? 'Terms & Conditions') }}"
                        placeholder="e.g., Terms & Conditions"
                        style="width: 100%; padding: 12px 16px; background: var(--bg-2, rgba(255,255,255,0.04)); border: 1px solid {{ $errors->has('title') ? '#fb7185' : 'var(--line, rgba(255,255,255,0.1))' }}; border-radius: 999px; color: var(--text, #f1f5f9); font-size: 0.95rem; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
                    />
                    @error('title')
                        <p style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-size: 0.84rem; font-weight: 600; color: var(--muted, #94a3b8); margin-bottom: 8px; letter-spacing: 0.03em; text-transform: uppercase;">
                        Terms Content / Description (Rich Text Editor) <span style="color: #fb7185; font-size: 1rem;">*</span>
                    </label>

                    <textarea
                        name="description"
                        id="vendor_tc_description"
                        rows="12"
                        placeholder="Write your general vendor terms and conditions content here..."
                        style="width: 100%; box-sizing: border-box;"
                    >{{ old('description', $page->description ?? '') }}</textarea>

                    @error('description')
                        <p style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 2: Agreement -->
            <div style="margin-bottom: 25px;">
                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--brand, #52ead2); margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15l2 2 4-4"/></svg>
                    Agreement
                </h4>

                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-size: 0.84rem; font-weight: 600; color: var(--muted, #94a3b8); margin-bottom: 8px; letter-spacing: 0.03em; text-transform: uppercase;">
                        Agreement Title
                    </label>
                    <input
                        type="text"
                        name="agreement_title"
                        id="vendor_agreement_title"
                        value="{{ old('agreement_title', $page->agreement_title ?? 'Terms & Conditions of Vehicle Rental') }}"
                        placeholder="e.g., Terms & Conditions of Vehicle Rental"
                        style="width: 100%; padding: 12px 16px; background: var(--bg-2, rgba(255,255,255,0.04)); border: 1px solid {{ $errors->has('agreement_title') ? '#fb7185' : 'var(--line, rgba(255,255,255,0.1))' }}; border-radius: 999px; color: var(--text, #f1f5f9); font-size: 0.95rem; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
                    />
                    @error('agreement_title')
                        <p style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-size: 0.84rem; font-weight: 600; color: var(--muted, #94a3b8); margin-bottom: 8px; letter-spacing: 0.03em; text-transform: uppercase;">
                        Agreement Content / Description (Rich Text Editor)
                    </label>

                    @php
                        $defaultAgreement = '<p><strong>1. Vehicle Operation & Driver Qualification:</strong> The Renter warrants holding a valid government-issued Driver\'s License and promises that the vehicle will only be operated by authorized drivers listed in the reservation. Sub-leasing or transferring the vehicle to third parties is strictly prohibited.</p><p><strong>2. Vehicle Inspection & Fuel Policy:</strong> The Renter acknowledges inspecting the vehicle prior to departure. The vehicle must be returned with the same fuel level as provided at pickup and in a clean condition. Fuel shortages will be charged as per vendor branch rate.</p><p><strong>3. Security Deposit & Damage Liability:</strong> Any traffic violations, toll charges, towing fees, or accidental physical damages incurred during the rental period are the sole liability of the Renter and will be deducted from the security deposit or billed directly.</p><p><strong>4. Return Schedule & Late Penalty:</strong> The vehicle must be returned at the agreed return location and time. Overstaying beyond the scheduled return time without prior vendor authorization will incur hourly/daily penalty charges.</p><p><strong>5. Prohibited Use & Safety Compliance:</strong> Vehicle shall not be used for illegal activities, speed contests, off-road driving, or transporting hazardous materials. Renter agrees to adhere to all municipal and national highway traffic laws.</p>';
                    @endphp

                    <textarea
                        name="agreement_description"
                        id="vendor_agreement_description"
                        rows="14"
                        placeholder="Write your detailed agreement terms and policy details..."
                        style="width: 100%; box-sizing: border-box;"
                    >{{ old('agreement_description', $page->agreement_description ?? $defaultAgreement) }}</textarea>

                    @error('agreement_description')
                        <p style="color: #fb7185; font-size: 0.82rem; margin: 6px 0 0 2px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 12px; padding-top: 8px;">
                <button type="submit" id="vendorSubmitBtn" class="btn btn-primary rounded-pill px-4" style="font-weight: 800 !important; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important; color: #051013 !important; border: none !important;">
                    <svg viewBox="0 0 24 24" style="width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:2.5;">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    {{ $page ? 'Update Terms & Agreement' : 'Save Terms & Agreement' }}
                </button>

                <span id="last-updated-span" style="color: var(--muted, #94a3b8); font-size: 0.82rem;">
                    @if($page && $page->updated_at)
                        Last updated: {{ $page->updated_at->format('d M Y, h:i A') }}
                    @endif
                </span>
            </div>

        </form>
    </div>

</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        if (typeof CKEDITOR !== 'undefined') {
            try {
                const isLightMode = document.body.classList.contains('light-mode') || document.documentElement.classList.contains('light-mode');
                const editorOptions = {
                    height: 380,
                    versionCheck: false,
                    uiColor: isLightMode ? '#f1f5f9' : '#2a3248',
                    contentsCss: isLightMode 
                        ? 'body { background-color: #ffffff; color: #0f172a; font-family: Inter, sans-serif; } a { color: #0284c7; }' 
                        : 'body { background-color: #050711; color: #f8fafc; font-family: Inter, sans-serif; } a { color: #52ead2; }'
                };

                const editor1 = CKEDITOR.replace('vendor_tc_description', editorOptions);
                const editor2 = CKEDITOR.replace('vendor_agreement_description', editorOptions);

                const updateEditorTheme = () => {
                    [editor1, editor2].forEach(ed => {
                        if (ed && ed.document) {
                            const body = ed.document.getBody();
                            if (body) {
                                const isLight = document.body.classList.contains('light-mode') || document.documentElement.classList.contains('light-mode');
                                if (isLight) {
                                    body.setStyle('background-color', '#ffffff');
                                    body.setStyle('color', '#0f172a');
                                } else {
                                    body.setStyle('background-color', '#050711');
                                    body.setStyle('color', '#f8fafc');
                                }
                            }
                        }
                    });
                };

                editor1.on('instanceReady', updateEditorTheme);
                editor2.on('instanceReady', updateEditorTheme);
            } catch (err) {
                console.error('CKEditor init error:', err);
            }
        }

        // Handle AJAX form submit
        $('#vendor-tc-form').on('submit', function (e) {
            e.preventDefault();

            if (typeof CKEDITOR !== 'undefined') {
                if (CKEDITOR.instances.vendor_tc_description) {
                    CKEDITOR.instances.vendor_tc_description.updateElement();
                }
                if (CKEDITOR.instances.vendor_agreement_description) {
                    CKEDITOR.instances.vendor_agreement_description.updateElement();
                }
            }

            var btn = $('#vendorSubmitBtn');
            btn.prop('disabled', true).css('opacity', '0.7');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (response) {
                    btn.prop('disabled', false).css('opacity', '1');
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: response.message || 'Terms & Conditions & Agreement saved successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        if (response.last_updated) {
                            $('#last-updated-span').text('Last updated: ' + response.last_updated);
                        }
                    } else {
                        Swal.fire('Error', response.message || 'Failed to save terms.', 'error');
                    }
                },
                error: function (xhr) {
                    btn.prop('disabled', false).css('opacity', '1');
                    var msg = 'Failed to save Terms & Conditions & Agreement.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Validation Error', msg, 'error');
                }
            });
        });
    });
</script>
@endsection
