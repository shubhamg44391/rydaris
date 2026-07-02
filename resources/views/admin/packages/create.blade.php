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

                <!-- Features (one per line) -->
                <div class="mb-4">
                    <label for="features" class="form-label-custom">Plan Features (One per line)</label>
                    <textarea class="form-control form-input-custom @error('features') is-invalid @enderror" id="features" name="features"
                        rows="6" required placeholder="Up to 25 vehicles&#10;Reservation calendar&#10;Customer records" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; line-height: 1.5;"></textarea>
                    @error('features')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                <div class="mb-4" style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                    <label for="is_featured" style="font-size: 0.95rem; color: #111827; font-weight: 600; cursor: pointer; user-select: none;">Mark this plan as "Most Selected" (Featured)</label>
                    @error('is_featured')
                        <div class="invalid-feedback">{{ $message }}</div>
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
