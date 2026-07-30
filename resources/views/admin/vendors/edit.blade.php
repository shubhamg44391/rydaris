@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Edit Vendor Profile</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form id="vendorEditForm" method="POST" action="{{ route('admin.vendors.update', $vendor->id) }}" novalidate>
                @csrf
                @method('PUT')

                
                <div class="row" style="display: flex; gap: 20px; margin-bottom: 24px;">
                    <div style="flex: 1;">
                        <label for="first_name" class="form-label-custom">First Name</label>
                        <input type="text" class="form-control form-input-custom @error('first_name') is-invalid @enderror" id="first_name" name="first_name"
                            value="{{ old('first_name', $vendor->first_name) }}" required placeholder="Enter first name" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="flex: 1;">
                        <label for="middle_name" class="form-label-custom">Middle Name</label>
                        <input type="text" class="form-control form-input-custom @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name"
                            value="{{ old('middle_name', $vendor->middle_name) }}" placeholder="Enter middle name" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                        @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="flex: 1;">
                        <label for="last_name" class="form-label-custom">Last Name</label>
                        <input type="text" class="form-control form-input-custom @error('last_name') is-invalid @enderror" id="last_name" name="last_name"
                            value="{{ old('last_name', $vendor->last_name) }}" required placeholder="Enter last name" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                
                <div class="mb-4">
                    <label for="username" class="form-label-custom">Username</label>
                    <input type="text" class="form-control form-input-custom @error('username') is-invalid @enderror" id="username" name="username"
                        value="{{ old('username', $vendor->username) }}" required placeholder="Enter username" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <input type="email" class="form-control form-input-custom @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email', $vendor->email) }}" required placeholder="name@company.com" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label class="form-label-custom">Contact Details</label>
                    @include('partials.phone-input')
                    <input type="tel" id="reg_phone" class="form-control form-input-custom" placeholder="Phone number" value="{{ old('country_code', $vendor->country_code) }}{{ old('contact_number', $vendor->contact_number) }}" required style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code', $vendor->country_code) }}">
                    <input type="hidden" name="contact_number" id="hidden_contact_number" value="{{ old('contact_number', $vendor->contact_number) }}">
                    @error('country_code')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                    @error('contact_number')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <h3 style="font-size: 1.15rem; font-weight: 600; color: var(--brand); margin-top: 32px; margin-bottom: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 8px;">Address Information</h3>

                <div class="mb-4">
                    <label for="street_address" class="form-label-custom">Street Address</label>
                    <input type="text" class="form-control form-input-custom @error('street_address') is-invalid @enderror" id="street_address" name="street_address"
                        value="{{ old('street_address', $vendor->street_address) }}" required placeholder="Enter street address" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    @error('street_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="landmark" class="form-label-custom">Landmark</label>
                    <input type="text" class="form-control form-input-custom @error('landmark') is-invalid @enderror" id="landmark" name="landmark"
                        value="{{ old('landmark', $vendor->landmark) }}" placeholder="Enter landmark (optional)" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    @error('landmark')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 20px; margin-bottom: 24px;">
                    <div style="flex: 1;">
                        <label for="city" class="form-label-custom">City</label>
                        <input type="text" class="form-control form-input-custom @error('city') is-invalid @enderror" id="city" name="city"
                            value="{{ old('city', $vendor->city) }}" required placeholder="City" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="flex: 1;">
                        <label for="pincode" class="form-label-custom">Pincode</label>
                        <input type="text" class="form-control form-input-custom @error('pincode') is-invalid @enderror" id="pincode" name="pincode"
                            value="{{ old('pincode', $vendor->pincode) }}" required placeholder="Pincode" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                        @error('pincode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="country" class="form-label-custom">Country</label>
                    <input type="text" class="form-control form-input-custom @error('country') is-invalid @enderror" id="country" name="country"
                        value="{{ old('country', $vendor->country) }}" required placeholder="Country" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label for="status" class="form-label-custom">Vendor Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" style="border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background-color: var(--bg-2); color: var(--text); border: 1px solid var(--line);" required>
                        <option value="active" {{ old('status', $vendor->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $vendor->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important; border: none !important; color: #051013 !important; cursor: pointer; box-shadow: 0 4px 12px rgba(82, 234, 210, 0.15) !important;">Save Changes</button>
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            initializeIntlTelInput('reg_phone', 'hidden_country_code', 'hidden_contact_number');

            var requiredFields = [
                { id: 'first_name', name: 'First Name' },
                { id: 'last_name', name: 'Last Name' },
                { id: 'username', name: 'Username' },
                { id: 'email', name: 'Email Address' },
                { id: 'street_address', name: 'Street Address' },
                { id: 'city', name: 'City' },
                { id: 'pincode', name: 'Pincode' },
                { id: 'country', name: 'Country' }
            ];

            // Real-time validation on typing
            $.each(requiredFields, function (i, field) {
                $('#' + field.id).on('input change', function () {
                    var val = $.trim($(this).val());
                    var $parent = $(this).parent();
                    $parent.find('.ajax-error').remove();
                    if (val) {
                        $(this).removeClass('is-invalid');
                    } else {
                        $(this).addClass('is-invalid');
                        $parent.append('<div class="invalid-feedback d-block ajax-error" style="color: #fb7185; font-size: 0.82rem; margin-top: 4px; font-weight: 600;">' + field.name + ' is required.</div>');
                    }
                });
            });

            $('#reg_phone').on('input change', function () {
                var val = $.trim($(this).val());
                var $parent = $(this).parent();
                $parent.find('.ajax-error').remove();
                if (val) {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                    $parent.append('<div class="invalid-feedback d-block ajax-error" style="color: #fb7185; font-size: 0.82rem; margin-top: 4px; font-weight: 600;">Contact Number is required.</div>');
                }
            });

            $('#vendorEditForm').on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                var $submitBtn = $form.find('button[type="submit"]');
                var origText = $submitBtn.text();

                // Clear previous errors
                $('.invalid-feedback.ajax-error').remove();
                $('.is-invalid').removeClass('is-invalid');

                var hasError = false;
                var $firstInvalid = null;

                // Client-side validation checks
                $.each(requiredFields, function (i, field) {
                    var $input = $('#' + field.id);
                    var val = $.trim($input.val());
                    if (!val) {
                        $input.addClass('is-invalid');
                        $input.parent().append('<div class="invalid-feedback d-block ajax-error" style="color: #fb7185; font-size: 0.82rem; margin-top: 4px; font-weight: 600;">' + field.name + ' is required.</div>');
                        hasError = true;
                        if (!$firstInvalid) $firstInvalid = $input;
                    }
                });

                var phoneVal = $.trim($('#reg_phone').val());
                if (!phoneVal) {
                    $('#reg_phone').addClass('is-invalid');
                    $('#reg_phone').parent().append('<div class="invalid-feedback d-block ajax-error" style="color: #fb7185; font-size: 0.82rem; margin-top: 4px; font-weight: 600;">Contact Number is required.</div>');
                    hasError = true;
                    if (!$firstInvalid) $firstInvalid = $('#reg_phone');
                }

                if (hasError) {
                    if ($firstInvalid) {
                        $('html, body').animate({ scrollTop: $firstInvalid.offset().top - 100 }, 300);
                        $firstInvalid.focus();
                    }
                    return;
                }

                $submitBtn.prop('disabled', true).text('Saving...');

                var formData = new FormData(this);

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message || 'Vendor updated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function () {
                                window.location.href = data.redirect || "{{ route('admin.vendors.index') }}";
                            });
                        }
                    },
                    error: function (xhr) {
                        $submitBtn.prop('disabled', false).text(origText);

                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function (field, msgs) {
                                var $input = $('#' + field);
                                if (!$input.length) $input = $('[name="' + field + '"]');
                                if ($input.length) {
                                    $input.addClass('is-invalid');
                                    $input.parent().append('<div class="invalid-feedback d-block ajax-error" style="color: #fb7185; font-size: 0.82rem; margin-top: 4px; font-weight: 600;">' + msgs[0] + '</div>');
                                }
                            });
                            var firstErr = Object.values(errors)[0][0];
                            Swal.fire('Validation Error', firstErr, 'warning');
                        } else {
                            var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'An error occurred while updating the vendor profile.';
                            Swal.fire('Error!', msg, 'error');
                        }
                    }
                });
            });
        });
    </script>
@endsection
