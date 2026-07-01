@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 style="font-size: 1.4rem; color: #111827; margin: 0;">Add New Vehicle</h2>
                <p class="panel-muted" style="margin: 4px 0 0; font-size: 0.9rem;">Enter the vehicle specifications, features, and settings.</p>
            </div>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.vehicles.store') }}" enctype="multipart/form-data" id="vehicleForm">
                @csrf

                <!-- Row 1 -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label for="name" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Vehicle Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                            value="{{ old('name') }}" required placeholder="Peugeot 107" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="model" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Model</label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" name="model" id="model"
                            value="{{ old('model') }}" required placeholder="Model" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="seats" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Seats</label>
                        <input type="number" class="form-control @error('seats') is-invalid @enderror" name="seats" id="seats"
                            value="{{ old('seats', 4) }}" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('seats')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="doors" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Doors</label>
                        <input type="number" class="form-control @error('doors') is-invalid @enderror" name="doors" id="doors"
                            value="{{ old('doors', 4) }}" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('doors')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label for="bags" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Bags</label>
                        <input type="number" class="form-control @error('bags') is-invalid @enderror" name="bags" id="bags"
                            value="{{ old('bags', 1) }}" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('bags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="group_id" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Vehicle Type(Group)</label>
                        <select class="form-select @error('group_id') is-invalid @enderror" name="group_id" id="group_id" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; min-height: 48px;">
                            <option value="">-- Select Group --</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="status" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Vehicle Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; min-height: 48px;">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="image" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Vehicle Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept="image/*" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label for="gear_system" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Gear system</label>
                        <select class="form-select @error('gear_system') is-invalid @enderror" name="gear_system" id="gear_system" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; min-height: 48px;">
                            <option value="manual" {{ old('gear_system') === 'manual' ? 'selected' : '' }}>manual</option>
                            <option value="automatic" {{ old('gear_system') === 'automatic' ? 'selected' : '' }}>automatic</option>
                        </select>
                        @error('gear_system')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="passengers" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Passengers</label>
                        <input type="number" class="form-control @error('passengers') is-invalid @enderror" name="passengers" id="passengers"
                            value="{{ old('passengers', 4) }}" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('passengers')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="wheel_drive" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Wheel drive</label>
                        <select class="form-select @error('wheel_drive') is-invalid @enderror" name="wheel_drive" id="wheel_drive" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; min-height: 48px;">
                            <option value="FWD" {{ old('wheel_drive') === 'FWD' ? 'selected' : '' }}>FWD</option>
                            <option value="RWD" {{ old('wheel_drive') === 'RWD' ? 'selected' : '' }}>RWD</option>
                            <option value="AWD" {{ old('wheel_drive') === 'AWD' ? 'selected' : '' }}>AWD</option>
                        </select>
                        @error('wheel_drive')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="code" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Vehicle Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code"
                            value="{{ old('code') }}" required placeholder="Vehicle Code" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label for="stock" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Stock</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock"
                            value="{{ old('stock', 1) }}" required style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 5: Dynamic Features -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Vehicle Features</label>
                        <div class="input-group">
                            <input type="text" id="feature_input" class="form-control" placeholder="Enter feature" style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;" />
                            <button class="btn btn-success px-3" type="button" id="add_feature_btn" style="border-radius: 0 var(--radius) var(--radius) 0;">+</button>
                        </div>
                        <div id="features_list" class="mt-2 d-flex flex-wrap gap-2" style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <!-- Tags will appear here -->
                        </div>
                    </div>
                </div>

                <!-- Row 6: Terms & Conditions -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="terms" style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;">Terms & Conditions</label>
                        <textarea name="terms" id="terms" class="form-control @error('terms') is-invalid @enderror" rows="10">{{ old('terms') }}</textarea>
                        @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem;">Create Vehicle</button>
                    <a href="{{ route('vendor.vehicles.index') }}" class="btn btn-link text-muted" style="text-decoration: none; font-weight: 800; font-size: 0.9rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize CKEditor
        CKEDITOR.replace('terms');

        // Dynamic Features List Builder
        const featureInput = document.getElementById('feature_input');
        const addFeatureBtn = document.getElementById('add_feature_btn');
        const featuresList = document.getElementById('features_list');
        const vehicleForm = document.getElementById('vehicleForm');

        // Maintain features in memory
        let features = [];

        function renderFeatures() {
            featuresList.innerHTML = '';
            features.forEach((feature, index) => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-label-primary d-inline-flex align-items-center gap-1';
                badge.style.padding = '8px 12px';
                badge.style.borderRadius = '8px';
                badge.style.fontSize = '0.85rem';
                badge.style.background = 'rgba(82, 234, 210, 0.12)';
                badge.style.color = 'var(--brand)';
                
                badge.innerHTML = `
                    <span>${feature}</span>
                    <a href="javascript:void(0);" class="text-danger ms-2 remove-feature-btn" data-index="${index}" style="font-weight: bold; text-decoration: none;">&times;</a>
                    <input type="hidden" name="features[]" value="${feature.replace(/"/g, '&quot;')}">
                `;
                featuresList.appendChild(badge);
            });
        }

        // Add feature action
        function addFeature() {
            const value = featureInput.value.trim();
            if (value && !features.includes(value)) {
                features.push(value);
                featureInput.value = '';
                renderFeatures();
            }
        }

        addFeatureBtn.addEventListener('click', addFeature);
        featureInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addFeature();
            }
        });

        // Remove feature action
        featuresList.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-feature-btn')) {
                const index = parseInt(e.target.getAttribute('data-index'), 10);
                features.splice(index, 1);
                renderFeatures();
            }
        });
    });
</script>
@endsection
