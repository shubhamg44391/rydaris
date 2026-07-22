<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/css/intlTelInput.css"/>
<style>
    /* intl-tel-input dark theme overrides */
    .iti { width: 100%; display: block; }
    .iti__dropdown-content { background: #111620 !important; border: 1px solid rgba(255,255,255,0.12) !important; color: #fff !important; border-radius: 8px !important; z-index: 9999 !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important; }
    .iti__country-list { background: #111620 !important; border: none !important; color: #fff !important; z-index: 9999 !important; margin: 0 !important; }
    .iti__country-list .iti__country:hover, .iti__country-list .iti__country.iti__highlight { background: rgba(82, 234, 210, 0.15) !important; }
    .iti__selected-flag { background: transparent !important; padding: 0 12px !important; border-right: 1px solid rgba(255, 255, 255, 0.12) !important; display: flex !important; flex-direction: row !important; align-items: center !important; flex-wrap: nowrap !important; gap: 6px !important; }
    .iti__flag { order: 1 !important; }
    .iti__selected-dial-code { color: #fff !important; margin-left: 6px !important; display: inline-block !important; white-space: nowrap !important; order: 2 !important; }
    .iti__arrow { border-top-color: #fff !important; order: 3 !important; }
    .iti__arrow--up { border-bottom-color: #fff !important; }
    
    /* Search Box Wrapper and Container Dark Styling */
    .iti__search-input-container { background: #111620 !important; border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important; padding: 10px !important; }
    .iti__search-input { background: #0b1020 !important; border: 1px solid rgba(255,255,255,0.15) !important; color: #fff !important; margin: 0 !important; padding: 8px 12px !important; border-radius: 6px !important; width: 100% !important; display: block !important; box-sizing: border-box !important; }
    .iti__search-input:focus { outline: none !important; border-color: var(--brand, #52ead2) !important; background: #111620 !important; }
    .iti__search-input::placeholder { color: #64748b !important; }
    
    /* Hide country name - show only flag and country dial code */
    .iti__country-name { display: none !important; }
    .iti__dial-code { margin-left: 8px !important; font-weight: 600 !important; color: #fff !important; }
    .iti__country { display: flex !important; align-items: center !important; padding: 8px 12px !important; gap: 4px !important; }
    #custom_pkg_phone, #reg_phone, #demo_inquiry_phone { padding-left: 115px !important; }

    /* Dark Scrollbar overrides */
    .iti__country-list::-webkit-scrollbar {
        width: 8px !important;
    }
    .iti__country-list::-webkit-scrollbar-track {
        background: #111620 !important;
        border-radius: 0 8px 8px 0 !important;
    }
    .iti__country-list::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15) !important;
        border-radius: 4px !important;
    }
    .iti__country-list::-webkit-scrollbar-thumb:hover {
        background: var(--brand, #52ead2) !important;
    }

    /* ===== Light Mode Overrides for intl-tel-input ===== */
    body.light-mode .iti__dropdown-content {
        background: #ffffff !important;
        border: 1px solid rgba(15, 23, 42, 0.12) !important;
        color: #0f172a !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
    body.light-mode .iti__country-list {
        background: #ffffff !important;
        color: #0f172a !important;
    }
    body.light-mode .iti__country-list .iti__country:hover,
    body.light-mode .iti__country-list .iti__country.iti__highlight {
        background: rgba(15, 118, 110, 0.08) !important;
    }
    body.light-mode .iti__selected-flag {
        border-right: 1px solid rgba(15, 23, 42, 0.12) !important;
    }
    body.light-mode .iti__selected-dial-code {
        color: #0f172a !important;
    }
    body.light-mode .iti__arrow {
        border-top-color: #475569 !important;
    }
    body.light-mode .iti__arrow--up {
        border-bottom-color: #475569 !important;
    }
    body.light-mode .iti__search-input-container {
        background: #f8fafc !important;
        border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
    }
    body.light-mode .iti__search-input {
        background: #ffffff !important;
        border: 1px solid rgba(15, 23, 42, 0.15) !important;
        color: #0f172a !important;
    }
    body.light-mode .iti__search-input:focus {
        border-color: #0f766e !important;
        background: #ffffff !important;
    }
    body.light-mode .iti__search-input::placeholder {
        color: #94a3b8 !important;
    }
    body.light-mode .iti__dial-code {
        color: #0f172a !important;
    }
    body.light-mode .iti__divider {
        border-bottom-color: rgba(15, 23, 42, 0.08) !important;
    }
    /* Light scrollbar for dropdown */
    body.light-mode .iti__country-list::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }
    body.light-mode .iti__country-list::-webkit-scrollbar-thumb {
        background: rgba(15, 23, 42, 0.15) !important;
    }
    body.light-mode .iti__country-list::-webkit-scrollbar-thumb:hover {
        background: #0f766e !important;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/js/intlTelInput.min.js"></script>
<script>
    function initializeIntlTelInput(inputId, hiddenCountryCodeId, hiddenContactNumberId) {
        const phoneInputField = document.getElementById(inputId);
        const hiddenCountryCodeField = document.getElementById(hiddenCountryCodeId);
        const hiddenContactNumberField = document.getElementById(hiddenContactNumberId);

        if (phoneInputField) {
            const storedPhone = phoneInputField.value || '';
            const options = {
                preferredCountries: ["ae", "sa", "in", "us", "gb", "au"],
                initialCountry: "ae",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/js/utils.js",
                showSelectedDialCode: true,
                formatOnDisplay: true,
                countrySearch: true
            };

            phoneInputField.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            const iti = window.intlTelInput(phoneInputField, options);

            if (!storedPhone.startsWith('+')) {
                fetch('https://ipapi.co/json/')
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.country_code) {
                            iti.setCountry(data.country_code.toLowerCase());
                        }
                    })
                    .catch(() => {
                        fetch('https://ip-api.com/json')
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.countryCode) {
                                    iti.setCountry(data.countryCode.toLowerCase());
                                }
                            })
                            .catch(() => {});
                    });
            }

            const form = phoneInputField.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const countryData = iti.getSelectedCountryData();
                    const fullNumber = iti.getNumber();
                    const dialCode = '+' + countryData.dialCode;
                    
                    let nationalNumber = fullNumber.replace(dialCode, '').trim();
                    if (!nationalNumber && phoneInputField.value) {
                        nationalNumber = phoneInputField.value;
                    }

                    if (hiddenCountryCodeField) {
                        hiddenCountryCodeField.value = dialCode;
                    }
                    if (hiddenContactNumberField) {
                        hiddenContactNumberField.value = nationalNumber;
                    }
                });
            }
        }
    }
</script>
