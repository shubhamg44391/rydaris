<div id="consultationModal" class="consultation-modal" aria-hidden="true">
    <div class="consultation-modal-backdrop" onclick="closeConsultationModal()"></div>
    <div class="consultation-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="consultationModalTitle">
        <div class="consultation-modal-content">
            <button type="button" class="consultation-close-btn" onclick="closeConsultationModal()" aria-label="Close">&times;</button>
            
            <div class="consultation-modal-header">
                <div class="availability-badge">
                    <span class="dot"></span> USUALLY BOOKED WITHIN 2 WORKING DAYS
                </div>
                <h2 id="consultationModalTitle">Book your slot</h2>
                <p class="subtitle">Fields marked <span class="required">*</span> are required.</p>
            </div>

            <form method="POST" action="{{ route('contact.submit') }}" id="consultationForm" class="consultation-form">
                @csrf
                
                <div class="form-section">
                    <div class="section-divider">
                        <span>YOUR DETAILS</span>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full name <span class="required">*</span></label>
                            <input type="text" name="name" required placeholder="Your name" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="company" placeholder="Optional" class="form-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Work email <span class="required">*</span></label>
                            <input type="email" name="email" required placeholder="you@company.com" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>WhatsApp number <span class="required">*</span></label>
                            <input type="tel" name="phone" class="form-input" placeholder="00000 00000" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-divider">
                        <span>THE PROJECT</span>
                    </div>
                    
                    <div class="form-group full-width">
                        <label>What do you need? <span class="required">*</span></label>
                        <select name="need" required class="form-input select-input">
                            <option value="" disabled selected>Choose one</option>
                            <option value="car_rental_software">Car Rental Software</option>
                            <option value="fleet_management">Fleet Management</option>
                            <option value="custom_development">Custom Development</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label>Budget range</label>
                        <select name="message" class="form-input select-input">
                            <option value="prefer_not_to_say" selected>Prefer not to say</option>
                            <option value="under_1000">Under ₹10,000</option>
                            <option value="1000_5000">₹10,000 - ₹50,000</option>
                            <option value="5000_plus">₹50,000+</option>
                        </select>
                    </div>
                </div>

                <div class="contact-info-footer">
                    <div class="contact-left">
                        <span class="light-text">PHONE</span> <strong>+918882688646</strong>
                    </div>
                    <div class="contact-right">
                        <span class="light-text">MON-FRI • 9:00 AM TO 6:00 PM</span>
                    </div>
                </div>

                <div class="consultation-form-actions">
                    <input type="hidden" name="fleet_size" value="Not specified">
                    <button type="submit" class="btn-consultation">Request my consultation &rarr;</button>
                    <button type="button" class="btn-cancel" onclick="closeConsultationModal()">Not right now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Base Variables (Dark Mode by default) */
    :root {
        --modal-bg: rgba(11, 16, 32, 0.98);
        --modal-text: #f8fafc;
        --modal-text-muted: #94a3b8;
        --modal-border: rgba(82, 234, 210, 0.25);
        --modal-input-bg: rgba(255, 255, 255, 0.04);
        --modal-input-border: rgba(255, 255, 255, 0.12);
        --modal-input-focus: rgba(82, 234, 210, 0.25);
        --modal-cancel-bg: transparent;
        --modal-cancel-border: rgba(255, 255, 255, 0.12);
        --modal-cancel-text: #f8fafc;
        --modal-divider: rgba(255, 255, 255, 0.1);
        --modal-backdrop: rgba(5, 7, 17, 0.85);
        --modal-shadow: 0 24px 80px rgba(0, 0, 0, 0.7);
    }

    /* Light Mode Variables */
    .light-mode {
        --modal-bg: #ffffff;
        --modal-text: #1e293b;
        --modal-text-muted: #64748b;
        --modal-border: #e2e8f0;
        --modal-input-bg: #ffffff;
        --modal-input-border: #cbd5e1;
        --modal-input-focus: rgba(205, 50, 50, 0.2);
        --modal-cancel-bg: #ffffff;
        --modal-cancel-border: #cbd5e1;
        --modal-cancel-text: #334155;
        --modal-divider: #f1f5f9;
        --modal-backdrop: rgba(0, 0, 0, 0.4);
        --modal-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .consultation-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 100000;
        padding: 16px;
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .consultation-modal.is-open {
        display: block;
    }

    .consultation-modal-backdrop {
        position: absolute;
        inset: 0;
        background: var(--modal-backdrop);
        backdrop-filter: blur(4px);
        transition: background 0.3s;
    }

    .consultation-modal-dialog {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .consultation-modal-content {
        pointer-events: auto;
        width: 100%;
        max-width: 600px;
        max-height: calc(100vh - 32px);
        overflow-y: auto;
        background: var(--modal-bg);
        border: 1px solid var(--modal-border);
        border-radius: 12px;
        padding: 40px 48px;
        box-shadow: var(--modal-shadow);
        margin: 0 auto;
        box-sizing: border-box;
        position: relative;
        color: var(--modal-text);
        transition: background 0.3s, border-color 0.3s;
    }

    .consultation-close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: var(--modal-text-muted);
        font-size: 28px;
        cursor: pointer;
        line-height: 1;
        padding: 0;
        transition: color 0.2s;
    }

    .consultation-close-btn:hover {
        color: var(--modal-text);
    }

    .consultation-modal-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .availability-badge {
        font-size: 11px;
        font-weight: 600;
        color: var(--modal-text-muted);
        letter-spacing: 1px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .availability-badge .dot {
        width: 6px;
        height: 6px;
        background-color: var(--brand);
        border-radius: 50%;
        display: inline-block;
    }

    .consultation-modal-header h2 {
        margin: 0 0 10px 0;
        color: var(--modal-text);
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .subtitle {
        color: var(--modal-text-muted);
        font-size: 14px;
        margin: 0;
    }

    .required {
        color: var(--brand);
    }

    .section-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 25px 0 20px 0;
    }

    .section-divider::before,
    .section-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid var(--modal-divider);
    }

    .section-divider span {
        padding: 0 15px;
        color: var(--modal-text-muted);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .full-width {
        width: 100%;
        margin-bottom: 20px;
    }

    .form-group label {
        color: var(--modal-text);
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--modal-input-border);
        border-radius: 8px;
        font-size: 15px;
        color: var(--modal-text);
        background-color: var(--modal-input-bg);
        transition: border-color 0.2s, box-shadow 0.2s, background-color 0.3s;
        box-sizing: border-box;
    }
    
    .form-input::placeholder {
        color: var(--modal-text-muted);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--brand);
        box-shadow: 0 0 0 3px var(--modal-input-focus);
    }

    .select-input {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 40px;
    }
    
    .light-mode .select-input {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    }

    .contact-info-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        border-top: 1px solid var(--modal-divider);
        border-bottom: 1px solid var(--modal-divider);
        margin: 30px 0;
        font-size: 11px;
        letter-spacing: 1px;
    }

    .light-text {
        color: var(--modal-text-muted);
        font-weight: 600;
    }
    
    .contact-info-footer strong {
        color: var(--modal-text);
        font-weight: 700;
        margin-left: 5px;
    }

    .consultation-form-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-consultation {
        background: var(--btn-primary-bg, linear-gradient(135deg, #4de8d8 0%, #76a9ff 100%));
        color: var(--btn-primary-text, #000000);
        border: none;
        padding: 14px 24px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--btn-primary-shadow, 0 4px 15px rgba(77, 232, 216, 0.3));
    }

    .btn-consultation:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(77, 232, 216, 0.4);
    }

    .btn-cancel {
        background-color: var(--modal-cancel-bg);
        color: var(--modal-cancel-text);
        border: 1px solid var(--modal-cancel-border);
        padding: 14px 24px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .btn-cancel:hover {
        background-color: rgba(255, 255, 255, 0.05);
        border-color: var(--modal-text-muted);
    }
    
    .light-mode .btn-cancel:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
    }

    @media (max-width: 640px) {
        .consultation-modal-content {
            padding: 30px 24px;
        }

        .form-row {
            flex-direction: column;
            gap: 20px;
        }

        .contact-info-footer {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .consultation-form-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn-consultation, .btn-cancel {
            width: 100%;
        }
    }
</style>

<script>
    function openConsultationModal() {
        const modal = document.getElementById('consultationModal');
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeConsultationModal() {
        const modal = document.getElementById('consultationModal');
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeConsultationModal();
        }
    });

    // Auto-open modal after 10 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            if (!sessionStorage.getItem('consultationModalShown')) {
                openConsultationModal();
                sessionStorage.setItem('consultationModalShown', 'true');
            }
        }, 10000);

        // Add loader state on submit
        const consultationForm = document.getElementById('consultationForm');
        if (consultationForm) {
            consultationForm.addEventListener('submit', function () {
                const btn = this.querySelector('button[type="submit"]');
                if (!btn || btn.disabled) return;
                btn.disabled = true;
                btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; animation: spin 1s linear infinite; margin-right: 8px;"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg> Sending...';
            });
        }
    });
</script>

<style>
@keyframes spin {
    100% { transform: rotate(360deg); }
}
</style>
