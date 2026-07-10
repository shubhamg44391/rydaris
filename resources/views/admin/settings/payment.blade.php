@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Payment Gateway Settings</h2>
                <p class="panel-muted" style="margin: 0; margin-top: 4px;">Configure the Razorpay API credentials and activation state for site-wide payments.</p>
            </div>
        </div>
        
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.settings.payment.update') }}" id="settingsForm">
                @csrf

                <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(82, 234, 210, 0.1); border-radius: var(--radius); padding: 24px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px;">
                        <h4 style="margin: 0; color: #f8fafc; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand, #52ead2);">
                                <rect x="2" y="5" width="20" height="14" rx="2" ry="2"/>
                                <line x1="2" y1="10" x2="22" y2="10"/>
                            </svg>
                            Razorpay Credentials
                        </h4>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <label class="form-label-custom" style="margin: 0; cursor: pointer; color: #f8fafc; font-weight: 500;" for="razorpay_active">Active Status</label>
                            <input type="checkbox" name="razorpay_active" id="razorpay_active" value="1" {{ $settings->razorpay_active ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <!-- Razorpay Key ID -->
                        <div>
                            <label for="razorpay_key_id" class="form-label-custom">Razorpay Key ID</label>
                            <input type="text" 
                                   class="form-control form-input-custom @error('razorpay_key_id') is-invalid @enderror" 
                                   id="razorpay_key_id" 
                                   name="razorpay_key_id"
                                   value="{{ old('razorpay_key_id', $settings->razorpay_key_id) }}" 
                                   placeholder="rzp_test_..." 
                                   style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                            @error('razorpay_key_id')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Razorpay Key Secret -->
                        <div>
                            <label for="razorpay_key_secret" class="form-label-custom">Razorpay Key Secret</label>
                            <div style="position: relative;">
                                <input type="password" 
                                       class="form-control form-input-custom @error('razorpay_key_secret') is-invalid @enderror" 
                                       id="razorpay_key_secret" 
                                       name="razorpay_key_secret"
                                       value="{{ old('razorpay_key_secret', $settings->razorpay_key_secret) }}" 
                                       placeholder="••••••••••••••••" 
                                       style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; padding-right: 45px; font-size: 0.95rem; width: 100%;" />
                                <button type="button" 
                                        onclick="toggleSecretVisibility()"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #aab7cb; display: flex; align-items: center; justify-content: center; padding: 0;">
                                    <svg id="eyeIcon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            @error('razorpay_key_secret')
                                <div class="invalid-feedback" style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Tax Percentage Section --}}
                <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(82, 234, 210, 0.1); border-radius: var(--radius); padding: 24px; margin-bottom: 24px;">
                    <h4 style="margin: 0 0 16px; color: #f8fafc; font-weight: 600; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 14px;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand, #52ead2);">
                            <line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>
                        </svg>
                        Tax / GST Rate
                    </h4>
                    <div style="max-width: 300px;">
                        <label for="tax_percentage" class="form-label-custom">Tax Percentage (%)</label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="number"
                                   id="tax_percentage"
                                   name="tax_percentage"
                                   min="0" max="100" step="0.01"
                                   value="{{ old('tax_percentage', $settings->tax_percentage ?? 18) }}"
                                   placeholder="18"
                                   style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px 40px 12px 12px; font-size: 0.95rem; width: 100%; background: rgba(255,255,255,0.05); color: #fff;" />
                            <span style="position: absolute; right: 14px; color: #a0aec0; font-weight: 600; font-size: 1rem;">%</span>
                        </div>
                        <p style="margin: 8px 0 0; font-size: 0.8rem; color: #7a8a9a;">This tax rate will be applied on all subscription plan purchases (e.g. 18 = 18% GST).</p>
                        @error('tax_percentage')<div style="color: #f87171; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="admin-action primary" style="border: none; padding: 12px 28px; cursor: pointer; font-size: 0.95rem; font-weight: 600; display: inline-flex; align-items: center; justify-content: center;">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSecretVisibility() {
            const secretInput = document.getElementById('razorpay_key_secret');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (secretInput.type === 'password') {
                secretInput.type = 'text';
                eyeIcon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>`;
            } else {
                secretInput.type = 'password';
                eyeIcon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
            }
        }
    </script>
@endsection
