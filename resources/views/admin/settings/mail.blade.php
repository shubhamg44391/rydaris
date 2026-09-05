@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Mail / SMTP Settings</h2>
            </div>
        </div>
        
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.settings.mail.update') }}" id="mailSettingsForm">
                @csrf

                
                <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(82, 234, 210, 0.1); border-radius: var(--radius); padding: 24px; margin-bottom: 24px;">
                    <h4 style="margin: 0 0 20px; color: #f8fafc; font-weight: 600; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand, #52ead2);">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        SMTP Connection Details
                    </h4>

                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        
                        <div>
                            <label for="smtp_host" class="form-label-custom">SMTP Host <span style="color:#f87171;">*</span></label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('smtp_host') is-invalid @enderror" 
                                   id="smtp_host" 
                                   name="smtp_host"
                                   value="{{ old('smtp_host', $settings->smtp_host) }}" 
                                   placeholder="smtp.mailtrap.io" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            <span class="field-error" id="err_smtp_host" style="display:none; color:#f87171; font-size:0.82rem; margin-top:4px; display:none; font-weight:600;"></span>
                            @error('smtp_host')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="smtp_port" class="form-label-custom">SMTP Port <span style="color:#f87171;">*</span></label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('smtp_port') is-invalid @enderror" 
                                   id="smtp_port" 
                                   name="smtp_port"
                                   value="{{ old('smtp_port', $settings->smtp_port) }}" 
                                   placeholder="587" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            <span class="field-error" id="err_smtp_port" style="display:none; color:#f87171; font-size:0.82rem; margin-top:4px; font-weight:600;"></span>
                            @error('smtp_port')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="smtp_encryption" class="form-label-custom">Encryption</label>
                            <select class="form-control form-input-custom @error('smtp_encryption') is-invalid @enderror" 
                                    id="smtp_encryption" 
                                    name="smtp_encryption"
                                    style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff; height: 47px; cursor: pointer;">
                                <option value="none" style="background: #0b1020; color: #f8fafc;" {{ old('smtp_encryption', $settings->smtp_encryption) == null ? 'selected' : '' }}>None</option>
                                <option value="tls" style="background: #0b1020; color: #f8fafc;" {{ old('smtp_encryption', $settings->smtp_encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" style="background: #0b1020; color: #f8fafc;" {{ old('smtp_encryption', $settings->smtp_encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                            @error('smtp_encryption')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        
                        <div>
                            <label for="smtp_username" class="form-label-custom">SMTP Username <span style="color:#f87171;">*</span></label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('smtp_username') is-invalid @enderror" 
                                   id="smtp_username" 
                                   name="smtp_username"
                                   value="{{ old('smtp_username', $settings->smtp_username) }}" 
                                   placeholder="username@example.com" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            <span class="field-error" id="err_smtp_username" style="display:none; color:#f87171; font-size:0.82rem; margin-top:4px; font-weight:600;"></span>
                            @error('smtp_username')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="smtp_password" class="form-label-custom">SMTP Password <span style="color:#f87171;">*</span></label>
                            <div style="position: relative;">
                                <input type="password" 
                                       class="form-control form-input-custom @error('smtp_password') is-invalid @enderror" 
                                       id="smtp_password" 
                                       name="smtp_password"
                                       value="{{ old('smtp_password', $settings->smtp_password) }}" 
                                       placeholder="••••••••••••••••" 
                                       style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; padding-right: 45px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                                <button type="button" 
                                        onclick="toggleSmtpPasswordVisibility()"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #aab7cb; display: flex; align-items: center; justify-content: center; padding: 0;">
                                    <svg id="smtpEyeIcon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            <span class="field-error" id="err_smtp_password" style="display:none; color:#f87171; font-size:0.82rem; margin-top:4px; font-weight:600;"></span>
                            @error('smtp_password')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                
                <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(82, 234, 210, 0.1); border-radius: var(--radius); padding: 24px; margin-bottom: 24px;">
                    <h4 style="margin: 0 0 20px; color: #f8fafc; font-weight: 600; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand, #52ead2);">
                            <circle cx="12" cy="12" r="4"/>
                            <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"/>
                        </svg>
                        Sender Information
                    </h4>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        
                        <div>
                            <label for="from_email" class="form-label-custom">Sender Email (From Email) <span style="color:#f87171;">*</span></label>
                            <input type="email" 
                                   class="form-control form-input-custom @error('from_email') is-invalid @enderror" 
                                   id="from_email" 
                                   name="from_email"
                                   value="{{ old('from_email', $settings->from_email) }}" 
                                   placeholder="noreply@rydaris.com" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            <span class="field-error" id="err_from_email" style="display:none; color:#f87171; font-size:0.82rem; margin-top:4px; font-weight:600;"></span>
                            @error('from_email')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="from_name" class="form-label-custom">Sender Name (From Name) <span style="color:#f87171;">*</span></label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('from_name') is-invalid @enderror" 
                                   id="from_name" 
                                   name="from_name"
                                   value="{{ old('from_name', $settings->from_name) }}" 
                                   placeholder="Rydaris Support" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            <span class="field-error" id="err_from_name" style="display:none; color:#f87171; font-size:0.82rem; margin-top:4px; font-weight:600;"></span>
                            @error('from_name')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                
                <div style="display: flex; gap: 12px; margin-bottom: 30px;">
                    @if(auth()->user()->hasAdminPermission('settings', 'edit'))
                    <button type="submit" class="admin-action primary" style="border: none; padding: 12px 28px; cursor: pointer; font-size: 0.95rem; font-weight: 800 !important; display: inline-flex; align-items: center; justify-content: center; border-radius: var(--radius);">
                        Save Configuration
                    </button>
                    @endif
                </div>
            </form>

            
        </div>
    </div>

    <script>
        function toggleSmtpPasswordVisibility() {
            var $input = $('#smtp_password');
            var $icon = $('#smtpEyeIcon');
            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text');
                $icon.html('<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>');
            } else {
                $input.attr('type', 'password');
                $icon.html('<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>');
            }
        }

        // Helper: show inline error under a field
        function showFieldError(fieldId, msg) {
            $('#' + fieldId)
                .css('border-color', '#f87171')
                .addClass('is-invalid');
            $('#err_' + fieldId)
                .text(msg)
                .css('display', 'block');
        }

        // Helper: clear inline error
        function clearFieldError(fieldId) {
            $('#' + fieldId)
                .css('border-color', '')
                .removeClass('is-invalid');
            $('#err_' + fieldId)
                .text('')
                .css('display', 'none');
        }

        // Helper: simple email regex check
        function isValidEmail(val) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
        }

        $(document).ready(function () {

            // Real-time: clear error on input
            $('#smtp_host, #smtp_port, #smtp_username, #smtp_password, #from_email, #from_name').on('input change', function () {
                clearFieldError(this.id);
            });

            $('#mailSettingsForm').on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var originalText = $btn.html();

                // ── Client-side Validation ──
                var hasError = false;
                // Clear all previous errors
                ['smtp_host','smtp_port','smtp_username','smtp_password','from_email','from_name'].forEach(function(id) {
                    clearFieldError(id);
                });

                if (!$.trim($('#smtp_host').val())) {
                    showFieldError('smtp_host', 'SMTP Host is required.');
                    hasError = true;
                }
                if (!$.trim($('#smtp_port').val())) {
                    showFieldError('smtp_port', 'SMTP Port is required.');
                    hasError = true;
                } else if (isNaN($('#smtp_port').val())) {
                    showFieldError('smtp_port', 'SMTP Port must be a number (e.g. 587).');
                    hasError = true;
                }
                if (!$.trim($('#smtp_username').val())) {
                    showFieldError('smtp_username', 'SMTP Username is required.');
                    hasError = true;
                }
                if (!$.trim($('#smtp_password').val())) {
                    showFieldError('smtp_password', 'SMTP Password is required.');
                    hasError = true;
                }
                if (!$.trim($('#from_email').val())) {
                    showFieldError('from_email', 'Sender email is required.');
                    hasError = true;
                } else if (!isValidEmail($.trim($('#from_email').val()))) {
                    showFieldError('from_email', 'Please enter a valid email address.');
                    hasError = true;
                }
                if (!$.trim($('#from_name').val())) {
                    showFieldError('from_name', 'Sender name is required.');
                    hasError = true;
                }

                if (hasError) {
                    // Scroll to first error
                    var $firstErr = $('.is-invalid').first();
                    if ($firstErr.length) {
                        $('html, body').animate({ scrollTop: $firstErr.offset().top - 100 }, 300);
                    }
                    return;
                }

                // ── AJAX Submit ──
                $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (data) {
                        $btn.prop('disabled', false).html(originalText);
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Saved!',
                                text: data.message || 'Mail settings updated successfully.',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to save settings.', 'error');
                        }
                    },
                    error: function (xhr) {
                        $btn.prop('disabled', false).html(originalText);
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, msgs) {
                                showFieldError(key, msgs[0]);
                            });
                            // Scroll to first server error
                            var $firstErr = $('.is-invalid').first();
                            if ($firstErr.length) {
                                $('html, body').animate({ scrollTop: $firstErr.offset().top - 100 }, 300);
                            }
                        } else {
                            Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                        }
                    }
                });
            });
        });
    </script>
@endsection
