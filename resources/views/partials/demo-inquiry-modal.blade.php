<div id="demoInquiryModal" class="demo-inquiry-modal" aria-hidden="true">
    <div class="demo-inquiry-modal-backdrop" onclick="closeDemoInquiryModal()"></div>
    <div class="demo-inquiry-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="demoInquiryModalTitle">
        <div class="demo-inquiry-modal-content">
            <div class="demo-inquiry-modal-header">
                <h3 id="demoInquiryModalTitle">Request Site Demo</h3>
                <button type="button" class="demo-inquiry-close-btn" onclick="closeDemoInquiryModal()" aria-label="Close">&times;</button>
            </div>

            <form method="POST" action="{{ route('demo-inquiry.submit') }}" id="demoInquiryForm" class="demo-inquiry-form">
                @csrf

                <div class="demo-form-row demo-form-row--names">
                    <div class="demo-form-group">
                        <label>First Name <span class="demo-required">*</span></label>
                        <input type="text" name="first_name" required placeholder="First name" class="demo-modal-input" value="{{ old('first_name') }}">
                    </div>
                    <div class="demo-form-group">
                        <label>Middle Name <span class="demo-required">*</span></label>
                        <input type="text" name="middle_name" required placeholder="Middle name" class="demo-modal-input" value="{{ old('middle_name') }}">
                    </div>
                    <div class="demo-form-group">
                        <label>Last Name <span class="demo-required">*</span></label>
                        <input type="text" name="last_name" required placeholder="Last name" class="demo-modal-input" value="{{ old('last_name') }}">
                    </div>
                </div>

                <div class="demo-form-group demo-form-group--full">
                    <label>Company Name <span class="demo-required">*</span></label>
                    <input type="text" name="company_name" required placeholder="Your company name" class="demo-modal-input" value="{{ old('company_name') }}">
                </div>

                <div class="demo-form-group demo-form-group--full">
                    <label>Company Email <span class="demo-required">*</span></label>
                    <input type="email" name="email" required placeholder="name@company.com" class="demo-modal-input" value="{{ old('email') }}">
                </div>

                <div class="demo-form-group demo-form-group--full">
                    <label>Contact Details <span class="demo-required">*</span></label>
                    <input type="tel" id="demo_inquiry_phone" class="demo-modal-input" placeholder="Phone number" value="{{ old('country_code') }}{{ old('contact_details') }}" required>
                    <input type="hidden" name="country_code" id="demo_hidden_country_code" value="{{ old('country_code') }}">
                    <input type="hidden" name="contact_details" id="demo_hidden_contact_details" value="{{ old('contact_details') }}">
                </div>

                <div class="demo-form-group demo-form-group--full">
                    <label>Description & Requirements <span class="demo-required">*</span></label>
                    <textarea name="description" required rows="4" placeholder="Tell us about your fleet size and specific needs..." class="demo-modal-input">{{ old('description') }}</textarea>
                </div>

                <div class="demo-form-actions">
                    <button type="submit" class="btn primary">Check Demo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .demo-inquiry-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10000;
        padding: 16px;
        box-sizing: border-box;
    }

    .demo-inquiry-modal.is-open {
        display: block;
    }

    .demo-inquiry-modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(5, 7, 17, 0.85);
        backdrop-filter: blur(8px);
    }

    .demo-inquiry-modal-dialog {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .demo-inquiry-modal-content {
        pointer-events: auto;
        width: 100%;
        max-width: 850px;
        max-height: calc(100vh - 32px);
        overflow-y: auto;
        background: rgba(11, 16, 32, 0.98);
        border: 1px solid rgba(82, 234, 210, 0.25);
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.7);
        margin: 0 auto;
        box-sizing: border-box;
        -webkit-overflow-scrolling: touch;
    }

    .demo-inquiry-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 22px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 14px;
    }

    .demo-inquiry-modal-header h3 {
        margin: 0;
        color: #f8fafc;
        font-size: 1.25rem;
        line-height: 1.3;
    }

    .demo-inquiry-close-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 32px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
        padding: 0;
        flex-shrink: 0;
    }

    .demo-inquiry-close-btn:hover {
        color: #f8fafc;
    }

    .demo-inquiry-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .demo-form-row {
        display: grid;
        gap: 16px;
    }

    .demo-form-row--names {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .demo-form-row--two {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .demo-form-group label {
        display: block;
        margin-bottom: 8px;
        color: #a8b3c5;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .demo-required {
        color: #ff4d4d;
    }

    .demo-modal-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 14px 16px;
        border-radius: 8px;
        color: #fff;
        font-family: inherit;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .demo-modal-input:focus {
        border-color: var(--brand, #52ead2);
        outline: none;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 2px rgba(82, 234, 210, 0.25);
    }

    .demo-form-actions {
        display: flex;
        justify-content: flex-end;
        padding-top: 4px;
    }

    .demo-form-actions .btn {
        min-width: 160px;
    }

    body.demo-modal-open {
        overflow: hidden;
    }

    @media (max-width: 900px) {
        .demo-form-row--names {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .demo-inquiry-modal {
            padding: 10px;
        }

        .demo-inquiry-modal-content {
            padding: 18px 16px;
            max-height: calc(100vh - 20px);
            border-radius: 14px;
        }

        .demo-inquiry-modal-header h3 {
            font-size: 1.1rem;
        }

        .demo-form-row--names,
        .demo-form-row--two {
            grid-template-columns: 1fr;
        }

        .demo-form-actions {
            justify-content: stretch;
        }

        .demo-form-actions .btn {
            width: 100%;
            min-width: 0;
        }
    }
</style>

<script>
    function openDemoInquiryModal() {
        const modal = document.getElementById('demoInquiryModal');
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('demo-modal-open');
    }

    function closeDemoInquiryModal() {
        const modal = document.getElementById('demoInquiryModal');
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('demo-modal-open');
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDemoInquiryModal();
        }
    });
</script>
