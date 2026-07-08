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
        <form action="{{ route('user.support-tickets.store') }}" method="POST" enctype="multipart/form-data">
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
                <!-- Vendor -->
                <div class="col-md-6 form-group">
                    <label class="glass-label">Select Vendor *</label>
                    <select name="vendor_id" class="glass-input" required>
                        <option value="" disabled selected>Select a vendor to message</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->company_name ?: $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category / Department -->
                <div class="col-md-6 form-group">
                    <label class="glass-label">Department / Category *</label>
                    <select name="category" class="glass-input" required>
                        <option value="" disabled selected>Select Department</option>
                        <option value="Business" {{ old('category') == 'Business' ? 'selected' : '' }}>Business</option>
                        <option value="Technical" {{ old('category') == 'Technical' ? 'selected' : '' }}>Technical</option>
                        <option value="Booking" {{ old('category') == 'Booking' ? 'selected' : '' }}>Booking</option>
                        <option value="Payment" {{ old('category') == 'Payment' ? 'selected' : '' }}>Payment</option>
                        <option value="General Support" {{ old('category') == 'General Support' ? 'selected' : '' }}>General Support</option>
                    </select>
                </div>
            </div>

            <!-- Subject -->
            <div class="form-group">
                <label class="glass-label">Subject *</label>
                <input type="text" name="subject" class="glass-input" placeholder="Enter ticket subject" value="{{ old('subject') }}" required>
            </div>

            <!-- Message -->
            <div class="form-group">
                <label class="glass-label">Message *</label>
                <textarea name="message" class="glass-input" rows="6" placeholder="Describe your issue in detail" required>{{ old('message') }}</textarea>
            </div>

            <div class="row">
                <!-- Priority -->
                <div class="col-md-6 form-group">
                    <label class="glass-label">Priority *</label>
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

                <!-- Attachment -->
                <div class="col-md-6 form-group">
                    <label class="glass-label">Attachment (if any)</label>
                    <input type="file" name="attachment" class="glass-input" style="padding: 8px;">
                    <span style="font-size: 0.75rem; color: #64748b; margin-top: 4px; display: block;">Allowed types: jpg, jpeg, png, pdf, doc, docx (Max 5MB)</span>
                </div>
            </div>

            <!-- Submit -->
            <div style="margin-top: 10px;">
                <button type="submit" class="btn btn-teal" style="font-weight: 600; padding: 12px 30px; border-radius: 6px;">
                    Submit Ticket
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
