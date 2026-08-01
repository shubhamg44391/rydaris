@extends('user.layouts.app')

@section('main-content')
<div class="admin-panel" style="padding: 20px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-weight: 700; color: #f8fafc; margin-bottom: 5px;">Add Support Ticket</h2>
            <p class="text-muted" style="margin: 0;">Create a support request for a vendor.</p>
        </div>
        <a href="{{ route('user.support-tickets.index') }}" class="btn btn-outline" style="border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to List
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; padding: 15px; border-radius: 8px; margin-bottom: 24px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <form id="ticketCreateForm" action="{{ route('user.support-tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <style>
                .glass-input {
                    background: rgba(11, 16, 32, 0.8) !important;
                    border: 1px solid rgba(255, 255, 255, 0.1) !important;
                    color: #f8fafc !important;
                    border-radius: 6px;
                    padding: 12px;
                    width: 100%;
                }
                .glass-input:focus {
                    border-color: #52ead2 !important;
                    box-shadow: 0 0 0 3px rgba(82, 234, 210, 0.15) !important;
                }
                .glass-label {
                    color: #94a3b8;
                    font-size: 0.85rem;
                    font-weight: 600;
                    margin-bottom: 8px;
                    display: block;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                .form-group {
                    margin-bottom: 24px;
                }
                .radio-group {
                    display: flex;
                    gap: 20px;
                    align-items: center;
                    margin-top: 10px;
                }
                .radio-label {
                    color: #cbd5e1;
                    font-weight: 500;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    cursor: pointer;
                }
            </style>

            <div class="row">
                @if(auth()->user()->vendor_id)
                    <input type="hidden" name="vendor_id" value="{{ auth()->user()->vendor_id }}">
                    
                    <div class="col-md-12 form-group">
                        <label class="glass-label">Department / Category <span style="color: #ef4444;">*</span></label>
                        <select name="category" id="category" class="glass-input" required>
                            <option value="" disabled selected>Select Department</option>
                            <option value="Business" {{ old('category') == 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="Technical" {{ old('category') == 'Technical' ? 'selected' : '' }}>Technical</option>
                            <option value="Booking" {{ old('category') == 'Booking' ? 'selected' : '' }}>Booking</option>
                            <option value="Payment" {{ old('category') == 'Payment' ? 'selected' : '' }}>Payment</option>
                            <option value="General Support" {{ old('category') == 'General Support' ? 'selected' : '' }}>General Support</option>
                        </select>
                    </div>
                @else
                    
                    <div class="col-md-6 form-group">
                        <label class="glass-label">Select Vendor <span style="color: #ef4444;">*</span></label>
                        <select name="vendor_id" id="vendor_id" class="glass-input" required>
                            <option value="" disabled selected>Select a vendor to message</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->company_name ?: $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div class="col-md-6 form-group">
                        <label class="glass-label">Department / Category <span style="color: #ef4444;">*</span></label>
                        <select name="category" id="category" class="glass-input" required>
                            <option value="" disabled selected>Select Department</option>
                            <option value="Business" {{ old('category') == 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="Technical" {{ old('category') == 'Technical' ? 'selected' : '' }}>Technical</option>
                            <option value="Booking" {{ old('category') == 'Booking' ? 'selected' : '' }}>Booking</option>
                            <option value="Payment" {{ old('category') == 'Payment' ? 'selected' : '' }}>Payment</option>
                            <option value="General Support" {{ old('category') == 'General Support' ? 'selected' : '' }}>General Support</option>
                        </select>
                    </div>
                @endif
            </div>

            
            <div class="form-group">
                <label class="glass-label">Subject <span style="color: #ef4444;">*</span></label>
                <input type="text" name="subject" id="subject" class="glass-input" placeholder="Enter ticket subject" value="{{ old('subject') }}" required>
            </div>

            
            <div class="form-group">
                <label class="glass-label">Message <span style="color: #ef4444;">*</span></label>
                <textarea name="message" id="message" class="glass-input" rows="6" placeholder="Describe your issue in detail" required>{{ old('message') }}</textarea>
            </div>

            <div class="row">
                
                <div class="col-md-6 form-group">
                    <label class="glass-label">Priority <span style="color: #ef4444;">*</span></label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="priority" value="low" {{ old('priority') == 'low' ? 'checked' : '' }} style="accent-color: #52ead2;">
                            Low
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="priority" value="medium" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }} style="accent-color: #52ead2;">
                            Medium
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="priority" value="high" {{ old('priority') == 'high' ? 'checked' : '' }} style="accent-color: #52ead2;">
                            High
                        </label>
                    </div>
                </div>

                
                <div class="col-md-6 form-group">
                    <label class="glass-label">Attachment (if any)</label>
                    <input type="file" name="attachment" id="attachment" class="glass-input" style="padding: 8px;">
                    <span style="font-size: 0.75rem; color: #64748b; margin-top: 4px; display: block;">Allowed types: jpg, jpeg, png, pdf, doc, docx (Max 5MB)</span>
                </div>
            </div>

            
            <div style="margin-top: 10px;">
                <button type="submit" id="submitBtn" class="btn btn-teal" style="font-weight: 600; padding: 12px 30px; border-radius: 6px; display: inline-flex; align-items: center; gap: 8px;">
                    <span>Submit Ticket</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#ticketCreateForm').on('submit', function (e) {
            e.preventDefault();

            let isValid = true;
            let firstErrorField = null;

            // Reset error styles
            $('.glass-input').css('border-color', 'rgba(255, 255, 255, 0.1)');
            $('.input-error-msg').remove();

            function markError(element, message) {
                element.css('border-color', '#ef4444');
                element.after(`<div class="input-error-msg" style="color: #ef4444; font-size: 0.78rem; font-weight: 600; margin-top: 4px;">${message}</div>`);
                if (!firstErrorField) firstErrorField = element;
                isValid = false;
            }

            const vendorEl = $('#vendor_id');
            if (vendorEl.length && (!vendorEl.val() || vendorEl.val() === '')) {
                markError(vendorEl, 'Please select a vendor.');
            }

            const categoryEl = $('#category');
            if (!categoryEl.val() || categoryEl.val() === '') {
                markError(categoryEl, 'Please select a department/category.');
            }

            const subjectEl = $('#subject');
            if (!subjectEl.val() || subjectEl.val().trim() === '') {
                markError(subjectEl, 'Subject is required.');
            }

            const messageEl = $('#message');
            if (!messageEl.val() || messageEl.val().trim() === '') {
                markError(messageEl, 'Message is required.');
            }

            if (!isValid) {
                if (firstErrorField) firstErrorField.focus();
                return;
            }

            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Submitting...');

            const formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Ticket Created!',
                            text: res.message || 'Support ticket created successfully.',
                            background: 'rgba(11, 16, 32, 0.95)',
                            confirmButtonColor: '#52ead2',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = res.redirect_url || "{{ route('user.support-tickets.index') }}";
                        });
                    }
                },
                error: function (xhr) {
                    submitBtn.prop('disabled', false).html('<span>Submit Ticket</span>');

                    let errMsg = 'An error occurred while submitting ticket.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, msgs) {
                            const field = $('[name="' + key + '"]');
                            if (field.length) {
                                markError(field, msgs[0]);
                            }
                        });
                        errMsg = 'Please check the highlighted error fields.';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errMsg,
                        background: 'rgba(11, 16, 32, 0.95)',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });
    });
</script>
@endsection
