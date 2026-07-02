@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Edit FAQ</h2>
            </div>
        </div>
        <div class="panel-body" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.faqs.update', $faq->id) }}">
                @csrf
                @method('PUT')

                <!-- Category -->
                <div class="mb-4">
                    <label for="category" class="form-label-custom">Category</label>
                    <select name="category" id="category" class="form-select form-input-custom @error('category') is-invalid @enderror" required style=" border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background-color: #ffffff;">
                        <option value="" disabled>Select Category</option>
                        <option value="product_basics" {{ old('category', $faq->category) === 'product_basics' ? 'selected' : '' }}>Product Basics</option>
                        <option value="onboarding" {{ old('category', $faq->category) === 'onboarding' ? 'selected' : '' }}>Onboarding</option>
                        <option value="reporting" {{ old('category', $faq->category) === 'reporting' ? 'selected' : '' }}>Reporting (Billing, security, and reporting)</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title (Question) -->
                <div class="mb-4">
                    <label for="title" class="form-label-custom">Question / Title</label>
                    <input type="text" class="form-control form-input-custom @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title', $faq->title) }}" required placeholder="e.g., Can Rydaris handle multiple rental branches?" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;" />
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description (Answer) -->
                <div class="mb-4">
                    <label for="description" class="form-label-custom">Answer / Description</label>
                    <textarea class="form-control form-input-custom @error('description') is-invalid @enderror" id="description" name="description"
                        rows="6" required placeholder="Enter the FAQ answer here..." style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%;">{{ old('description', $faq->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer;">Update FAQ</button>
                    <a href="{{ route('admin.faqs.index', ['category' => $faq->category]) }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
