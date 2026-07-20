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

                
                <div class="mb-4">
                    <label for="category" class="form-label-custom">Category</label>
                    <select name="category" id="category" class="form-select form-input-custom @error('category') is-invalid @enderror" required style="border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background-color: var(--bg-2); color: var(--text); border: 1px solid var(--line);">
                        <option value="" disabled>Select Category</option>
                        <option value="product_basics" {{ old('category', $faq->category) === 'product_basics' ? 'selected' : '' }}>Product Basics</option>
                        <option value="onboarding" {{ old('category', $faq->category) === 'onboarding' ? 'selected' : '' }}>Onboarding</option>
                        <option value="reporting" {{ old('category', $faq->category) === 'reporting' ? 'selected' : '' }}>Reporting (Billing, security, and reporting)</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label for="title" class="form-label-custom">Question / Title</label>
                    <input type="text" class="form-control form-input-custom @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title', $faq->title) }}" required placeholder="e.g., Can Rydaris handle multiple rental branches?" style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);" />
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label for="description" class="form-label-custom">Answer / Description</label>
                    <textarea class="form-control form-input-custom @error('description') is-invalid @enderror" id="description" name="description"
                        rows="6" required placeholder="Enter the FAQ answer here..." style="border: 1px solid var(--line); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; background: var(--bg-2); color: var(--text);">{{ old('description', $faq->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important; border: none !important; color: #051013 !important; cursor: pointer; box-shadow: 0 4px 12px rgba(82, 234, 210, 0.15) !important;">Update FAQ</button>
                    <a href="{{ route('admin.faqs.index', ['category' => $faq->category]) }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
