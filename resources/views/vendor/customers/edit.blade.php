@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="margin-bottom: 25px;">
            <div>
                <h2 class="panel-title" style="margin: 0;">Edit Customer Details</h2>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px; margin-bottom: 0;">Update the customer details. Leave the password field blank if you do not wish to change it.</p>
            </div>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.customers.update', $customer->id) }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="form-label-custom">First Name</label>
                        <input type="text" class="form-control form-input-custom @error('first_name') is-invalid @enderror" id="first_name" name="first_name"
                            value="{{ old('first_name', $customer->first_name) }}" required placeholder="Enter first name" />
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="name" class="form-label-custom">Last Name</label>
                        <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $customer->name) }}" required placeholder="Enter last name" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <input type="email" class="form-control form-input-custom @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email', $customer->email) }}" required placeholder="customer@example.com" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contact Details -->
                <div class="mb-4">
                    <label class="form-label-custom">Contact Details <span style="color: #ff4d4d;">*</span></label>
                    @include('partials.phone-input')
                    <input type="tel" id="reg_phone" class="form-control form-input-custom" placeholder="Phone number" value="{{ old('country_code', $customer->country_code) }}{{ old('contact_number', $customer->contact_number) }}" required style="width: 100%;">
                    <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code', $customer->country_code) }}">
                    <input type="hidden" name="contact_number" id="hidden_contact_number" value="{{ old('contact_number', $customer->contact_number) }}">
                    @error('country_code')
                        <div class="text-danger mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
                    @enderror
                    @error('contact_number')
                        <div class="text-danger mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <!-- Password -->
                    <div>
                        <label for="password" class="form-label-custom">Password (Leave blank to keep current)</label>
                        <input type="password" class="form-control form-input-custom @error('password') is-invalid @enderror" id="password" name="password"
                            placeholder="Enter new password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="form-label-custom">Confirm Password</label>
                        <input type="password" class="form-control form-input-custom" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirm new password" />
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 action-btn" style="background: linear-gradient(135deg, var(--brand, #52ead2), #ffffff) !important; color: #051013 !important; font-weight: 800; border: none; padding: 10px 24px; border-radius: 20px; cursor: pointer; transition: all 0.2s;">
                        Update Customer
                    </button>
                    <a href="{{ route('vendor.customers.index') }}" class="btn btn-link text-muted cancel-link" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem;">Cancel</a>
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
