@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2>Payment Gateway Settings</h2>
        </div>
        <div class="text-muted" style="font-size: 0.9rem;">
            Home / Payment Gateway Settings
        </div>
    </div>

    <div class="admin-table-wrap p-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 12px;">
        <h5 class="mb-4" style="color: var(--brand); border-bottom: 1px solid rgba(82, 234, 210, 0.1); padding-bottom: 15px;">Manage Payment Options</h5>
        
        <form action="{{ route('vendor.payment_settings.update') }}" method="POST" id="paymentSettingsForm">
            @csrf
            
            <div class="row align-items-center g-4">
                
                <div class="col-md-3">
                    <div class="d-flex flex-column gap-2">
                        <label class="form-label-custom" style="font-weight: 600;">Pay on Arrival</label>
                        <label class="switch">
                            <input type="checkbox" name="pay_on_arrival" class="payment-toggle" value="1" {{ $settings->pay_on_arrival ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                
                <div class="col-md-3">
                    <div class="d-flex flex-column gap-2">
                        <label class="form-label-custom" style="font-weight: 600;">Pay <span id="depositPercentDisplay">{{ $settings->deposit_percentage }}</span>% Deposit</label>
                        <div class="d-flex align-items-center gap-3">
                            <label class="switch">
                                <input type="checkbox" name="pay_deposit" class="payment-toggle" value="1" {{ $settings->pay_deposit ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2" style="display: none;">
                    <div class="d-flex flex-column gap-2">
                        <label class="form-label-custom">Deposit %</label>
                        <input type="number" step="0.01" min="0" max="100" name="deposit_percentage" id="depositInput" class="form-control-custom" value="{{ $settings->deposit_percentage }}" oninput="document.getElementById('depositPercentDisplay').innerText = this.value || 0;">
                    </div>
                </div>

                
                <div class="col-md-3">
                    <div class="d-flex flex-column gap-2">
                        <label class="form-label-custom" style="font-weight: 600;">Pay Full Amount</label>
                        <label class="switch">
                            <input type="checkbox" name="pay_full" class="payment-toggle" value="1" {{ $settings->pay_full ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                
                <div class="col-md-3">
                    <div class="d-flex flex-column gap-2">
                        <label class="form-label-custom" style="font-weight: 600;">Full Payment Discount (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="full_payment_discount" class="form-control-custom" value="{{ $settings->full_payment_discount }}" placeholder="5.00" style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255, 255, 255, 0.1); margin: 30px 0;">

            <div class="mb-4">
                <h5 class="text-white mb-1" style="font-weight: 700;">Razorpay Settings</h5>
                <p class="text-muted small">Enter your Razorpay API keys to process online payments.</p>
            </div>

            <div class="row align-items-center mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label-custom" style="font-weight: 600;">Razorpay Key ID</label>
                    <input type="text" name="razorpay_key" class="form-control-custom w-100" value="{{ $settings->razorpay_key }}" placeholder="rzp_test_..." style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom" style="font-weight: 600;">Razorpay Key Secret</label>
                    <input type="password" name="razorpay_secret" class="form-control-custom w-100" value="{{ $settings->razorpay_secret }}" placeholder="Enter Razorpay Secret..." style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                </div>
            </div>

            <div class="mt-5 text-end border-top pt-4" style="border-color: rgba(82, 234, 210, 0.1) !important;">
                <button type="submit" class="btn btn-primary px-4 py-2">Save Settings</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Custom Toggle Switch CSS */
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #334155;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 16px;
      width: 16px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: var(--brand);
      box-shadow: 0 0 10px rgba(82, 234, 210, 0.4);
    }
    
    input:disabled + .slider {
      opacity: 0.5;
      cursor: not-allowed;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px var(--brand);
    }

    input:checked + .slider:before {
      transform: translateX(26px);
    }

    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.payment-toggle');
        
        function updateToggleStates() {
            let activeCount = 0;
            toggles.forEach(t => {
                if(t.checked) activeCount++;
            });

            toggles.forEach(t => {
                // If only one is active and this is the active one, disable it to prevent unchecking
                if (activeCount === 1 && t.checked) {
                    t.disabled = true;
                } else {
                    t.disabled = false;
                }
            });
        }

        const payFullToggle = document.querySelector('input[name="pay_full"]');
        const discountInput = document.querySelector('input[name="full_payment_discount"]');

        function updateDiscountRequired() {
            if (payFullToggle.checked) {
                discountInput.setAttribute('required', 'required');
            } else {
                discountInput.removeAttribute('required');
            }
        }

        // Run on change for toggles
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function(e) {
                updateToggleStates();
                if(e.target === payFullToggle) {
                    updateDiscountRequired();
                }
            });
        });

        // Run on input for discount
        discountInput.addEventListener('input', function() {
            if (parseFloat(this.value) > 0 && !payFullToggle.checked) {
                payFullToggle.checked = true;
                updateToggleStates();
                updateDiscountRequired();
            }
        });

        // Run on load
        updateToggleStates();
        updateDiscountRequired();

        // Re-enable before submit so values are sent
        document.getElementById('paymentSettingsForm').addEventListener('submit', function() {
            toggles.forEach(t => { t.disabled = false; });
        });
    });
</script>
@endsection
