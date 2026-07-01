@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 style="font-size: 1.4rem; color: #111827; margin: 0;">Edit Pricing Package</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.packages.update', $package->id) }}">
                @csrf
                @method('PUT')

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Name -->
                    <div>
                        <label for="name" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Package Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $package->name) }}" required placeholder="e.g., Launch, Growth, Enterprise" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Eyebrow -->
                    <div>
                        <label for="eyebrow" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Eyebrow / Badge Text</label>
                        <input type="text" class="form-control @error('eyebrow') is-invalid @enderror" id="eyebrow" name="eyebrow"
                            value="{{ old('eyebrow', $package->eyebrow) }}" placeholder="e.g., Starter, Most selected, Scale" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('eyebrow')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Price -->
                    <div>
                        <label for="price" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Price Text</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                            value="{{ old('price', $package->price) }}" required placeholder="e.g., $79, $189, Custom" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Billing Period -->
                    <div>
                        <label for="billing_period" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Billing Period</label>
                        <input type="text" class="form-control @error('billing_period') is-invalid @enderror" id="billing_period" name="billing_period"
                            value="{{ old('billing_period', $package->billing_period) }}" placeholder="e.g., / month, / year, or leave empty" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('billing_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3" placeholder="Plan description / details" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;">{{ old('description', $package->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Features (one per line) -->
                <div class="mb-4">
                    <label for="features" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Plan Features (One per line)</label>
                    <textarea class="form-control @error('features') is-invalid @enderror" id="features" name="features"
                        rows="6" required placeholder="Up to 25 vehicles&#10;Reservation calendar&#10;Customer records" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; line-height: 1.5;">{{ old('features', $featuresText) }}</textarea>
                    @error('features')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Button Text -->
                    <div>
                        <label for="button_text" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Button Text</label>
                        <input type="text" class="form-control @error('button_text') is-invalid @enderror" id="button_text" name="button_text"
                            value="{{ old('button_text', $package->button_text) }}" required placeholder="e.g., Start Launch, Talk to Sales" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('button_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Display Order</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order"
                            value="{{ old('order', $package->order) }}" required min="0" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Featured Toggle -->
                <div class="mb-4" style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $package->is_featured) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
                    <label for="is_featured" style="font-size: 0.95rem; color: #111827; font-weight: 600; cursor: pointer; user-select: none;">Mark this plan as "Most Selected" (Featured)</label>
                    @error('is_featured')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer;">Update Package</button>
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-link text-muted" style="text-decoration: none; font-weight: 800; font-size: 0.9rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
