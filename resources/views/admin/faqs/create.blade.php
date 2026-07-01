@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 style="font-size: 1.4rem; color: #111827; margin: 0;">Create FAQ</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.faqs.store') }}">
                @csrf

                <!-- Category -->
                <div class="mb-4">
                    <label for="category" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Category</label>
                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background-color: #ffffff;">
                        <option value="" disabled {{ !$category ? 'selected' : '' }}>Select Category</option>
                        <option value="product_basics" {{ old('category', $category) === 'product_basics' ? 'selected' : '' }}>Product Basics</option>
                        <option value="onboarding" {{ old('category', $category) === 'onboarding' ? 'selected' : '' }}>Onboarding</option>
                        <option value="reporting" {{ old('category', $category) === 'reporting' ? 'selected' : '' }}>Reporting (Billing, security, and reporting)</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title (Question) -->
                <div class="mb-4">
                    <label for="title" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Question / Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title') }}" required placeholder="e.g., Can Rydaris handle multiple rental branches?" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description (Answer) -->
                <div class="mb-4">
                    <label for="description" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Answer / Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="6" required placeholder="Enter the FAQ answer here..." style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer;">Create FAQ</button>
                    <a href="{{ route('admin.faqs.index', ['category' => $category]) }}" class="btn btn-link text-muted" style="text-decoration: none; font-weight: 800; font-size: 0.9rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
