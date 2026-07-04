@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Create Pricing Package</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.packages.store') }}">
                @csrf

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Name -->
                    <div>
                        <label for="name" class="form-label-custom">Package Name</label>
                        <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required placeholder="e.g., Launch, Growth, Enterprise" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Eyebrow -->
                    <div>
                        <label for="eyebrow" class="form-label-custom">Eyebrow / Badge Text</label>
                        <input type="text" class="form-control form-input-custom @error('eyebrow') is-invalid @enderror" id="eyebrow" name="eyebrow"
                            value="{{ old('eyebrow') }}" placeholder="e.g., Starter, Most selected, Scale" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('eyebrow')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Price -->
                    <div>
                        <label for="price" class="form-label-custom">Price Text</label>
                        <input type="text" class="form-control form-input-custom @error('price') is-invalid @enderror" id="price" name="price"
                            value="{{ old('price') }}" required placeholder="e.g., $79, $189, Custom" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Billing Period -->
                    <div>
                        <label for="billing_period" class="form-label-custom">Billing Period</label>
                        <input type="text" class="form-control form-input-custom @error('billing_period') is-invalid @enderror" id="billing_period" name="billing_period"
                            value="{{ old('billing_period', '/ month') }}" placeholder="e.g., / month, / year, or leave empty" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('billing_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label-custom">Description</label>
                    <textarea class="form-control form-input-custom @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3" placeholder="Plan description / details" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Plan Limitations (Used as Features) -->
                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Number of Users -->
                    <div>
                        <label for="no_of_users" class="form-label-custom">Number of Users</label>
                        <input type="number" class="form-control form-input-custom @error('no_of_users') is-invalid @enderror" id="no_of_users" name="no_of_users"
                            value="{{ old('no_of_users') }}" min="0" placeholder="Empty for unlimited" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('no_of_users')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Number of Vehicles -->
                    <div>
                        <label for="no_of_vehicles" class="form-label-custom">Number of Vehicles</label>
                        <input type="number" class="form-control form-input-custom @error('no_of_vehicles') is-invalid @enderror" id="no_of_vehicles" name="no_of_vehicles"
                            value="{{ old('no_of_vehicles') }}" min="0" placeholder="Empty for unlimited" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('no_of_vehicles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Number of Groups -->
                    <div>
                        <label for="no_of_groups" class="form-label-custom">Number of Groups</label>
                        <input type="number" class="form-control form-input-custom @error('no_of_groups') is-invalid @enderror" id="no_of_groups" name="no_of_groups"
                            value="{{ old('no_of_groups') }}" min="0" placeholder="Empty for unlimited" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('no_of_groups')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Number of Coupons -->
                    <div>
                        <label for="no_of_coupons" class="form-label-custom">Number of Coupons</label>
                        <input type="number" class="form-control form-input-custom @error('no_of_coupons') is-invalid @enderror" id="no_of_coupons" name="no_of_coupons"
                            value="{{ old('no_of_coupons') }}" min="0" placeholder="Empty for unlimited" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('no_of_coupons')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Button Text -->
                    <div>
                        <label for="button_text" class="form-label-custom">Button Text</label>
                        <input type="text" class="form-control form-input-custom @error('button_text') is-invalid @enderror" id="button_text" name="button_text"
                            value="{{ old('button_text', 'Book Demo') }}" required placeholder="e.g., Start Launch, Talk to Sales" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('button_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="form-label-custom">Display Order</label>
                        <input type="number" class="form-control form-input-custom @error('order') is-invalid @enderror" id="order" name="order"
                            value="{{ old('order', '0') }}" required min="0" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Featured Toggle -->
                <div class="mb-4">
                    <label class="form-label-custom d-block">Status</label>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                        <label for="is_featured" style="font-size: 0.95rem; color: #111827; font-weight: 600; cursor: pointer; user-select: none; margin: 0;">Mark this plan as "Most Selected" (Featured)</label>
                    </div>
                    @error('is_featured')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer;">Create Package</button>
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
