@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Edit Vehicle Variant Details</h2>
            </div>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.Variants.update', $Variant->id) }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="form-label-custom">Variant Name</label>
                    <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $Variant->name) }}" required placeholder="Enter Variant name"  />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label-custom">Description</label>
                    <textarea class="form-control form-input-custom @error('description') is-invalid @enderror" id="description" name="description"
                        rows="5" placeholder="Enter Variant description" >{{ old('description', $Variant->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 action-btn">Save Changes</button>
                    <a href="{{ route('vendor.Variants.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        CKEDITOR.replace('description');
    });
</script>
@endsection
