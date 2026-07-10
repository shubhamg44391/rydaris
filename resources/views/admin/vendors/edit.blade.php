@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Edit Vendor Profile</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.vendors.update', $vendor->id) }}">
                @csrf
                @method('PUT')

                <!-- First Name -->
                <div class="mb-4">
                    <label for="first_name" class="form-label-custom">First Name</label>
                    <input type="text" class="form-control form-input-custom @error('first_name') is-invalid @enderror" id="first_name" name="first_name"
                        value="{{ old('first_name', $vendor->first_name) }}" required placeholder="Enter first name" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <input type="email" class="form-control form-input-custom @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email', $vendor->email) }}" required placeholder="name@company.com" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contact Details -->
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

                <!-- Status -->
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

                <!-- Actions -->
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
        document.addEventListener('DOMContentLoaded', function () {
            initializeIntlTelInput('reg_phone', 'hidden_country_code', 'hidden_contact_number');
        });
    </script>
@endsection
