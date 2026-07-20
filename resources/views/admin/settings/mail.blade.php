@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Mail / SMTP Settings</h2>
                <p class="panel-muted" style="margin: 0; margin-top: 4px;">Configure the system SMTP settings for outgoing emails (plan activations, registrations, system notifications, etc.).</p>
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
                            <label for="smtp_host" class="form-label-custom">SMTP Host</label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('smtp_host') is-invalid @enderror" 
                                   id="smtp_host" 
                                   name="smtp_host"
                                   value="{{ old('smtp_host', $settings->smtp_host) }}" 
                                   placeholder="smtp.mailtrap.io" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            @error('smtp_host')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="smtp_port" class="form-label-custom">SMTP Port</label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('smtp_port') is-invalid @enderror" 
                                   id="smtp_port" 
                                   name="smtp_port"
                                   value="{{ old('smtp_port', $settings->smtp_port) }}" 
                                   placeholder="587" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            @error('smtp_port')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="smtp_encryption" class="form-label-custom">Encryption</label>
                            <select class="form-control form-input-custom @error('smtp_encryption') is-invalid @enderror" 
                                    id="smtp_encryption" 
                                    name="smtp_encryption"
                                    style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: #050711; color: #fff; height: 47px;">
                                <option value="none" {{ old('smtp_encryption', $settings->smtp_encryption) == null ? 'selected' : '' }}>None</option>
                                <option value="tls" {{ old('smtp_encryption', $settings->smtp_encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ old('smtp_encryption', $settings->smtp_encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                            @error('smtp_encryption')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        
                        <div>
                            <label for="smtp_username" class="form-label-custom">SMTP Username</label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('smtp_username') is-invalid @enderror" 
                                   id="smtp_username" 
                                   name="smtp_username"
                                   value="{{ old('smtp_username', $settings->smtp_username) }}" 
                                   placeholder="username@example.com" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            @error('smtp_username')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="smtp_password" class="form-label-custom">SMTP Password</label>
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
                            <label for="from_email" class="form-label-custom">Sender Email (From Email)</label>
                            <input type="email" 
                                   class="form-control form-input-custom @error('from_email') is-invalid @enderror" 
                                   id="from_email" 
                                   name="from_email"
                                   value="{{ old('from_email', $settings->from_email) }}" 
                                   placeholder="noreply@rydaris.com" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            @error('from_email')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="from_name" class="form-label-custom">Sender Name (From Name)</label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('from_name') is-invalid @enderror" 
                                   id="from_name" 
                                   name="from_name"
                                   value="{{ old('from_name', $settings->from_name) }}" 
                                   placeholder="Rydaris Support" 
                                   style="border: 1px solid rgba(255, 255, 255, 0.15); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            @error('from_name')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                
                <div style="display: flex; gap: 12px; margin-bottom: 30px;">
                    <button type="submit" class="admin-action primary" style="border: none; padding: 12px 28px; cursor: pointer; font-size: 0.95rem; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; border-radius: var(--radius);">
                        Save Configuration
                    </button>
                </div>
            </form>

            
        </div>
    </div>

    <script>
        function toggleSmtpPasswordVisibility() {
            const passwordInput = document.getElementById('smtp_password');
            const eyeIcon = document.getElementById('smtpEyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
            }
        }
    </script>
@endsection
