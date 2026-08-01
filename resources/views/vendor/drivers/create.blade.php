@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="panel-title">Add New Driver</h2>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px; margin-bottom: 0;">Create a new driver profile under your vendor account.</p>
            </div>
        </div>

        <div class="panel-body">
            <form id="driverCreateForm" method="POST" action="{{ route('vendor.drivers.store') }}" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="row">
                    <!-- Driver Name (Mandatory) -->
                    <div class="col-md-6 mb-4">
                        <label for="name" class="form-label-custom">Driver Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required placeholder="Enter driver full name" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mobile Number (Mandatory) -->
                    <div class="col-md-6 mb-4">
                        <label for="driver_phone_input" class="form-label-custom">Mobile Number <span style="color: #ef4444;">*</span></label>
                        @include('partials.phone-input')
                        <input type="tel" id="driver_phone_input" class="form-control form-input-custom @error('phone') is-invalid @enderror" placeholder="e.g. 9876543210" value="{{ old('phone') }}" required style="width: 100%;">
                        <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code', '+91') }}">
                        <input type="hidden" name="phone" id="hidden_phone" value="{{ old('phone') }}">
                        <script>
                            (function setupDriverPhone() {
                                if (typeof initializeIntlTelInput === 'function') {
                                    initializeIntlTelInput('driver_phone_input', 'hidden_country_code', 'hidden_phone');
                                } else {
                                    setTimeout(setupDriverPhone, 50);
                                }
                            })();
                        </script>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email (Optional) -->
                    <div class="col-md-6 mb-4">
                        <label for="email" class="form-label-custom">Email Address <span class="text-muted font-weight-normal">(Optional)</span></label>
                        <input type="email" class="form-control form-input-custom @error('email') is-invalid @enderror" id="email" name="email"
                            value="{{ old('email') }}" placeholder="driver@example.com" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label-custom">Status <span style="color: #ef4444;">*</span></label>
                        <select class="form-select form-input-custom @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- License Number (Optional) -->
                    <div class="col-md-6 mb-4">
                        <label for="license_number" class="form-label-custom">Driver License Number <span class="text-muted font-weight-normal">(Optional)</span></label>
                        <input type="text" class="form-control form-input-custom @error('license_number') is-invalid @enderror" id="license_number" name="license_number"
                            value="{{ old('license_number') }}" placeholder="e.g. DL-1420110012345" />
                        @error('license_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- License Expiry Date (Optional) -->
                    <div class="col-md-6 mb-4">
                        <label for="license_expiry" class="form-label-custom">License Expiry Date <span class="text-muted font-weight-normal">(Optional)</span></label>
                        <input type="date" class="form-control form-input-custom @error('license_expiry') is-invalid @enderror" id="license_expiry" name="license_expiry"
                            value="{{ old('license_expiry') }}" style="cursor: pointer;" onclick="try{ if(typeof this.showPicker === 'function'){ this.showPicker(); } }catch(e){}" />
                        @error('license_expiry')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Driver License Document / Image (Optional) -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label-custom">Driver License Image / Document <span class="text-muted font-weight-normal">(Optional)</span></label>

                        <div id="license-upload-box" style="border: 2px dashed var(--line, #cbd5e1); border-radius: var(--radius, 10px); padding: 24px; text-align: center; background: var(--bg-2, #f8fafc); cursor: pointer; transition: border-color 0.2s;" onclick="document.getElementById('license_image').click();">
                            <input type="file" id="license_image" name="license_image" accept="image/*,application/pdf" class="d-none" style="display: none;" onchange="handleLicensePreview(this)" />

                            <div id="license-upload-prompt">
                                <svg viewBox="0 0 24 24" style="width: 40px; height: 40px; fill: none; stroke: var(--brand, #52ead2); stroke-width: 2; margin-bottom: 8px;">
                                    <rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect>
                                    <circle cx="9" cy="10" r="2"></circle>
                                    <line x1="15" y1="8" x2="19" y2="8"></line>
                                    <line x1="15" y1="12" x2="19" y2="12"></line>
                                    <line x1="7" y1="16" x2="17" y2="16"></line>
                                </svg>
                                <p style="margin: 0 0 4px 0; font-weight: 700; color: var(--text, #1e293b); font-size: 0.95rem;">Click to upload driver license photo or PDF</p>
                                <p style="margin: 0; color: #94a3b8; font-size: 0.8rem;">PNG, JPG, WEBP, or PDF (Max: 5MB)</p>
                            </div>

                            <div id="license-preview-container" style="display: none; align-items: center; justify-content: center; flex-direction: column; gap: 8px;">
                                <img id="license-preview-img" src="" alt="License Preview" style="max-height: 140px; border-radius: 8px; object-fit: contain;" />
                                <span id="license-file-name" style="font-weight: 600; font-size: 0.85rem; color: var(--text, #f8fafc);"></span>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation(); removeLicensePreview();" style="border-radius: 6px; padding: 4px 12px; font-weight: 700;">Remove</button>
                            </div>
                        </div>
                        @error('license_image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address (Mandatory) -->
                    <div class="col-md-12 mb-4">
                        <label for="address" class="form-label-custom">Full Address <span style="color: #ef4444;">*</span></label>
                        <textarea class="form-control form-input-custom @error('address') is-invalid @enderror" id="address" name="address" rows="3" required placeholder="Enter driver full residential address...">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Notes (Optional) -->
                    <div class="col-md-12 mb-4">
                        <label for="notes" class="form-label-custom">Notes / Internal Comments <span class="text-muted font-weight-normal">(Optional)</span></label>
                        <textarea class="form-control form-input-custom @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2" placeholder="Any additional notes about driver experience, background check...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Driver Photo (Optional) -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label-custom">Driver Photo <span class="text-muted font-weight-normal">(Optional)</span></label>

                        <div id="upload-box" style="border: 2px dashed var(--line, #cbd5e1); border-radius: var(--radius, 10px); padding: 24px; text-align: center; background: var(--bg-2, #f8fafc); cursor: pointer; transition: border-color 0.2s;" onclick="document.getElementById('photo').click();">
                            <input type="file" id="photo" name="photo" accept="image/*" class="d-none" style="display: none;" onchange="handlePhotoPreview(this)" />

                            <!-- Upload Prompt Placeholder -->
                            <div id="upload-prompt">
                                <svg viewBox="0 0 24 24" style="width: 40px; height: 40px; fill: none; stroke: var(--brand, #52ead2); stroke-width: 2; margin-bottom: 8px;">
                                    <circle cx="12" cy="7" r="4"></circle>
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                </svg>
                                <p style="margin: 0 0 4px 0; font-weight: 700; color: var(--text, #1e293b); font-size: 0.95rem;">Click to upload driver photo</p>
                                <span style="color: var(--muted, #64748b); font-size: 0.82rem;">Supported formats: PNG, JPG, JPEG, WEBP (Max 5MB)</span>
                            </div>

                            <!-- Image Preview Box -->
                            <div id="preview-box" style="display: none; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                <img id="preview-img" src="#" alt="Driver Photo Preview" style="max-height: 160px; width: 160px; height: 160px; border-radius: 50%; border: 2px solid var(--brand, #52ead2); object-fit: cover; margin: 0 auto 12px auto; display: block;" />
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation(); removePhoto();" style="border-radius: 20px; font-size: 0.8rem; padding: 6px 16px; display: inline-flex; align-items: center; gap: 4px;">
                                    Remove Photo
                                </button>
                            </div>
                        </div>
                        @error('photo')
                            <div class="invalid-feedback d-block" style="margin-top: 6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex align-items-center gap-3 mt-3" style="display: flex; gap: 16px; align-items: center;">
                    <button type="submit" id="submitBtn" class="btn btn-primary rounded-pill px-4 action-btn" style="background: linear-gradient(135deg, var(--brand, #52ead2), #ffffff) !important; color: #051013 !important; font-weight: 800; border: none; padding: 10px 24px; border-radius: 20px; cursor: pointer; transition: all 0.2s;">
                        Save Driver
                    </button>
                    <a href="{{ route('vendor.drivers.index') }}" class="btn btn-link text-muted cancel-link" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
    /* Calendar Icon inside Date Input */
    input[type="date"],
    input.flatpickr-input {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2352ead2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        background-size: 18px 18px !important;
        padding-right: 40px !important;
        cursor: pointer !important;
    }

    body.light-mode input[type="date"],
    body.light-mode input.flatpickr-input {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%230f766e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        background-size: 18px 18px !important;
        color: #0f172a !important;
        -webkit-text-fill-color: #0f172a !important;
    }

    /* Flatpickr Calendar Styling Fixes */
    .flatpickr-calendar {
        background: #111620 !important;
        border: 1px solid rgba(82, 234, 210, 0.3) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6) !important;
        border-radius: 12px !important;
        z-index: 999999 !important;
        padding: 6px !important;
    }
    .flatpickr-months {
        align-items: center !important;
        padding: 6px 0 !important;
    }
    .flatpickr-months .flatpickr-month {
        background: #111620 !important;
        color: #f8fafc !important;
        height: 42px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .flatpickr-current-month {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        height: auto !important;
        font-size: 1.05rem !important;
        line-height: 1.4 !important;
        position: static !important;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        color: #f8fafc !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        background: transparent !important;
        padding: 2px 6px !important;
        height: auto !important;
        line-height: 1.4 !important;
        display: inline-block !important;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months option {
        background: #111620 !important;
        color: #f8fafc !important;
    }
    .flatpickr-current-month .numInputWrapper input.cur-year {
        color: #f8fafc !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        line-height: 1.4 !important;
    }
    .flatpickr-day {
        color: #e2e8f0 !important;
        border-radius: 6px !important;
    }
    span.flatpickr-weekday {
        color: #cbd5e1 !important;
        font-weight: 700 !important;
    }
    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange {
        background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
        color: #051013 !important;
        font-weight: 800 !important;
        border-color: transparent !important;
    }
    .flatpickr-day:hover {
        background: rgba(82, 234, 210, 0.2) !important;
    }
    .flatpickr-months .flatpickr-prev-month svg,
    .flatpickr-months .flatpickr-next-month svg {
        fill: #52ead2 !important;
    }

    /* Light Mode Flatpickr Overrides */
    body.light-mode .flatpickr-calendar {
        background: #ffffff !important;
        border: 1px solid rgba(15, 23, 42, 0.15) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }
    body.light-mode .flatpickr-months .flatpickr-month {
        background: #ffffff !important;
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-current-month .flatpickr-monthDropdown-months,
    body.light-mode .flatpickr-current-month .numInputWrapper input.cur-year {
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-current-month .flatpickr-monthDropdown-months option {
        background: #ffffff !important;
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-weekdays,
    body.light-mode .flatpickr-weekdaycontainer,
    body.light-mode span.flatpickr-weekday {
        background: #f1f5f9 !important;
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-day {
        color: #0f172a !important;
        font-weight: 600 !important;
    }
    body.light-mode .flatpickr-day.prevMonthDay,
    body.light-mode .flatpickr-day.nextMonthDay {
        color: #94a3b8 !important;
    }
    body.light-mode .flatpickr-day.today {
        border-color: #0f766e !important;
    }
    body.light-mode .flatpickr-day.selected {
        background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
        color: #051013 !important;
    }
    body.light-mode .flatpickr-day:hover {
        background: rgba(15, 23, 42, 0.08) !important;
    }
    body.light-mode .flatpickr-months .flatpickr-prev-month svg,
    body.light-mode .flatpickr-months .flatpickr-next-month svg {
        fill: #0f766e !important;
    }
</style>
<script>
    function handlePhotoPreview(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('upload-prompt').style.display = 'none';
                document.getElementById('preview-box').style.display = 'flex';
            }
            reader.readAsDataURL(file);
        }
    }

    function removePhoto() {
        const input = document.getElementById('photo');
        input.value = '';
        document.getElementById('preview-img').src = '#';
        document.getElementById('preview-box').style.display = 'none';
        document.getElementById('upload-prompt').style.display = 'block';
    }

    $(document).ready(function () {
        if (typeof flatpickr !== 'undefined') {
            flatpickr("input[type='date']", {
                dateFormat: "Y-m-d",
                allowInput: true,
                disableMobile: "true"
            });
        }

        $('#name, #phone, #address').on('input change', function () {
            if ($.trim($(this).val())) {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').hide();
            }
        });

        $('#driverCreateForm').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $submitBtn = $('#submitBtn');
            var originalText = $submitBtn.html();

            // Client side validation
            var nameVal = $.trim($('#name').val());
            var phoneVal = $.trim($('#phone').val());
            var addressVal = $.trim($('#address').val());
            var hasError = false;

            $('.is-invalid').removeClass('is-invalid');
            $('.ajax-error').remove();

            if (!nameVal) {
                $('#name').addClass('is-invalid');
                $('#name').parent().append('<div class="invalid-feedback d-block ajax-error" style="margin-top: 6px; color: #fb7185; font-weight: 600; font-size: 0.82rem;">Driver Name is mandatory.</div>');
                hasError = true;
            }

            if (!phoneVal) {
                $('#phone').addClass('is-invalid');
                $('#phone').parent().append('<div class="invalid-feedback d-block ajax-error" style="margin-top: 6px; color: #fb7185; font-weight: 600; font-size: 0.82rem;">Mobile Number is mandatory.</div>');
                hasError = true;
            }

            if (!addressVal) {
                $('#address').addClass('is-invalid');
                $('#address').parent().append('<div class="invalid-feedback d-block ajax-error" style="margin-top: 6px; color: #fb7185; font-weight: 600; font-size: 0.82rem;">Address is mandatory.</div>');
                hasError = true;
            }

            if (hasError) return;

            $submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving Driver...');

            var formData = new FormData(this);

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Driver added successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function () {
                            window.location.href = data.redirect || "{{ route('vendor.drivers.index') }}";
                        });
                    } else {
                        $submitBtn.prop('disabled', false).html(originalText);
                        Swal.fire('Error!', data.message || 'Failed to add driver.', 'error');
                    }
                },
                error: function (xhr) {
                    $submitBtn.prop('disabled', false).html(originalText);

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, msgs) {
                            var $input = $('#' + field);
                            if (!$input.length) $input = $('[name="' + field + '"]');
                            if ($input.length) {
                                $input.addClass('is-invalid');
                                $input.parent().append('<div class="invalid-feedback d-block ajax-error" style="margin-top: 6px; color: #fb7185; font-weight: 600; font-size: 0.82rem;">' + msgs[0] + '</div>');
                            }
                        });
                        var firstErr = Object.values(errors)[0][0];
                        Swal.fire('Validation Error', firstErr, 'warning');
                    } else {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'An error occurred while saving driver.';
                        Swal.fire('Error!', msg, 'error');
                    }
                }
            });
        });
    });

    function handleLicensePreview(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            $('#license-file-name').text(file.name);
            if (file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#license-preview-img').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#license-preview-img').hide();
            }
            $('#license-upload-prompt').hide();
            $('#license-preview-container').css('display', 'flex');
        }
    }

    function removeLicensePreview() {
        $('#license_image').val('');
        $('#license-preview-container').hide();
        $('#license-upload-prompt').show();
    }
</script>
@endsection
