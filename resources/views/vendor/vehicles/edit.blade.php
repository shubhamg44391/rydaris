@extends('admin.layouts.app')

@section('main-content')
<style>
    .add-feature-btn {
        background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important;
        color: #051013 !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(82, 234, 210, 0.15) !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .remove-feature-btn {
        background: linear-gradient(135deg, #f43f5e, #e11d48) !important;
        color: #fff !important;
        border: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Edit Vehicle Details</h2>
            </div>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.vehicles.update', $vehicle->id) }}" enctype="multipart/form-data" id="vehicleForm">
                @csrf
                @method('PUT')

                
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label for="name" class="form-label-custom">Vehicle Name</label>
                        <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" name="name" id="name"
                            value="{{ old('name', $vehicle->name) }}" required placeholder="Peugeot 107"  />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="model" class="form-label-custom">Model</label>
                        <input type="text" class="form-control form-input-custom @error('model') is-invalid @enderror" name="model" id="model"
                            value="{{ old('model', $vehicle->model) }}" required placeholder="Model"  />
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="seats" class="form-label-custom">Seats</label>
                        <input type="number" class="form-control form-input-custom @error('seats') is-invalid @enderror" name="seats" id="seats"
                            value="{{ old('seats', $vehicle->seats) }}" required  />
                        @error('seats')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="doors" class="form-label-custom">Doors</label>
                        <input type="number" class="form-control form-input-custom @error('doors') is-invalid @enderror" name="doors" id="doors"
                            value="{{ old('doors', $vehicle->doors) }}" required  />
                        @error('doors')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label for="bags" class="form-label-custom">Bags</label>
                        <input type="number" class="form-control form-input-custom @error('bags') is-invalid @enderror" name="bags" id="bags"
                            value="{{ old('bags', $vehicle->bags) }}" required  />
                        @error('bags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="group_id" class="form-label-custom">Vehicle Type(Group)</label>
                        <select class="form-select form-input-custom @error('group_id') is-invalid @enderror" name="group_id" id="group_id" >
                            <option value="">-- Select Group --</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id', $vehicle->group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="status" class="form-label-custom">Vehicle Status</label>
                        <select class="form-select form-input-custom @error('status') is-invalid @enderror" name="status" id="status" required >
                            <option value="active" {{ old('status', $vehicle->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $vehicle->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="image" class="form-label-custom">Vehicle Image</label>
                        <input type="file" class="form-control form-input-custom @error('image') is-invalid @enderror" name="image" id="image" accept="image/*" onchange="previewImage(event)" />
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2" id="imagePreviewContainer" style="{{ $vehicle->image ? 'display:block;' : 'display:none;' }}">
                            <img id="imagePreview" src="{{ $vehicle->image ? asset('storage/' . $vehicle->image) : '#' }}" alt="Preview" style="max-width: 150px; height: auto; border-radius: 4px; border: 1px solid rgba(82,234,210,0.3);">
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label for="gear_system" class="form-label-custom">Gear system</label>
                        <select class="form-select form-input-custom @error('gear_system') is-invalid @enderror" name="gear_system" id="gear_system" required >
                            <option value="manual" {{ old('gear_system', $vehicle->gear_system) === 'manual' ? 'selected' : '' }}>manual</option>
                            <option value="automatic" {{ old('gear_system', $vehicle->gear_system) === 'automatic' ? 'selected' : '' }}>automatic</option>
                        </select>
                        @error('gear_system')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="passengers" class="form-label-custom">Passengers</label>
                        <input type="number" class="form-control form-input-custom @error('passengers') is-invalid @enderror" name="passengers" id="passengers"
                            value="{{ old('passengers', $vehicle->passengers) }}" required  />
                        @error('passengers')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="wheel_drive" class="form-label-custom">Wheel drive</label>
                        <select class="form-select form-input-custom @error('wheel_drive') is-invalid @enderror" name="wheel_drive" id="wheel_drive" required >
                            <option value="FWD" {{ old('wheel_drive', $vehicle->wheel_drive) === 'FWD' ? 'selected' : '' }}>FWD</option>
                            <option value="RWD" {{ old('wheel_drive', $vehicle->wheel_drive) === 'RWD' ? 'selected' : '' }}>RWD</option>
                            <option value="AWD" {{ old('wheel_drive', $vehicle->wheel_drive) === 'AWD' ? 'selected' : '' }}>AWD</option>
                        </select>
                        @error('wheel_drive')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="code" class="form-label-custom">Vehicle Code</label>
                        <input type="text" class="form-control form-input-custom @error('code') is-invalid @enderror" name="code" id="code"
                            value="{{ old('code', $vehicle->code) }}" required placeholder="Vehicle Code"  />
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <label for="stock" class="form-label-custom">Stock</label>
                        <input type="number" class="form-control form-input-custom @error('stock') is-invalid @enderror" name="stock" id="stock"
                            value="{{ old('stock', $vehicle->stock) }}" required  />
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Vehicle Features</label>
                        <div id="features_container">
                            @php 
                                $existingFeatures = is_string($vehicle->features) ? json_decode($vehicle->features, true) : $vehicle->features;
                                $existingFeatures = is_array($existingFeatures) ? $existingFeatures : [];
                            @endphp
                            
                            @if(count($existingFeatures) > 0)
                                @foreach($existingFeatures as $index => $feature)
                                    <div class="input-group mb-2 feature-row">
                                        <input type="text" name="features[]" class="form-control form-input-custom" placeholder="Enter feature" value="{{ $feature }}" required />
                                        @if($loop->last)
                                            <button class="btn btn-success px-3 add-feature-btn" type="button" style="border-radius: 0 var(--radius) var(--radius) 0; width: 45px; font-weight: bold;">+</button>
                                        @else
                                            <button class="btn btn-danger px-3 remove-feature-btn" type="button" style="border-radius: 0 var(--radius) var(--radius) 0; width: 45px;"><i class="bx bx-trash"></i></button>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 feature-row">
                                    <input type="text" name="features[]" class="form-control form-input-custom" placeholder="Enter feature" required />
                                    <button class="btn btn-success px-3 add-feature-btn" type="button" style="border-radius: 0 var(--radius) var(--radius) 0; width: 45px; font-weight: bold;">+</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="terms" class="form-label-custom">Terms & Conditions</label>
                        <textarea name="terms" id="terms" class="form-control form-input-custom @error('terms') is-invalid @enderror" rows="10">{{ old('terms', $vehicle->terms) }}</textarea>
                        @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 action-btn">Save Changes</button>
                    <a href="{{ route('vendor.vehicles.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    
    <div class="mt-5 pt-4" style="border-top: 1px solid var(--line); width: 100%; max-width: 100%; overflow-x: hidden; box-sizing: border-box;">
        @include('vendor.availability.partial', ['singleVehicleMode' => true])
    </div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    (function() {
        // Initialize CKEditor 4 Full safely
        try {
            if (typeof CKEDITOR !== 'undefined') {
                const isLightMode = document.body.classList.contains('light-mode') || document.documentElement.classList.contains('light-mode');
                const editor = CKEDITOR.replace('terms', {
                    height: 300,
                    versionCheck: false,
                    uiColor: isLightMode ? '#f1f5f9' : '#2a3248',
                    contentsCss: isLightMode 
                        ? 'body { background-color: #ffffff; color: #0f172a; font-family: Inter, sans-serif; } a { color: #0284c7; }' 
                        : 'body { background-color: #050711; color: #f8fafc; font-family: Inter, sans-serif; } a { color: #52ead2; }'
                });

                const updateEditorTheme = () => {
                    if (editor && editor.document) {
                        const body = editor.document.getBody();
                        if (body) {
                            const isLight = document.body.classList.contains('light-mode') || document.documentElement.classList.contains('light-mode');
                            if (isLight) {
                                body.setStyle('background-color', '#ffffff');
                                body.setStyle('color', '#0f172a');
                            } else {
                                body.setStyle('background-color', '#050711');
                                body.setStyle('color', '#f8fafc');
                            }
                        }
                    }
                };

                editor.on('instanceReady', updateEditorTheme);
            } else {
                console.warn('CKEDITOR is not defined, skipping initialization.');
            }
        } catch (error) {
            console.error('Error initializing CKEDITOR:', error);
        }

        // Dynamic Features List Builder (Rows)
        const featuresContainer = document.getElementById('features_container');

        if (!featuresContainer) {
            console.error('Feature builder container not found!');
            return;
        }

        // Handle Add/Remove clicks
        featuresContainer.addEventListener('click', function(e) {
            const addBtn = e.target.closest('.add-feature-btn');
            const removeBtn = e.target.closest('.remove-feature-btn');

            if (addBtn) {
                // Change current + button to - button
                addBtn.classList.remove('btn-success', 'add-feature-btn');
                addBtn.classList.add('btn-danger', 'remove-feature-btn');
                addBtn.innerHTML = '<i class="bx bx-trash"></i>';

                // Create a new row
                const newRow = document.createElement('div');
                newRow.className = 'input-group mb-2 feature-row';
                newRow.innerHTML = `
                    <input type="text" name="features[]" class="form-control form-input-custom" placeholder="Enter feature" required />
                    <button class="btn btn-success px-3 add-feature-btn" type="button" style="border-radius: 0 var(--radius) var(--radius) 0; width: 45px; font-weight: bold;">+</button>
                `;
                featuresContainer.appendChild(newRow);
                
                // Focus the new input
                newRow.querySelector('input').focus();
            }

            if (removeBtn) {
                const row = removeBtn.closest('.feature-row');
                if (row) {
                    row.remove();
                }
            }
        });
    })();

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
            document.getElementById('imagePreviewContainer').style.display = 'block';
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>

<script>
    const singleVehicleMode = true;
    const filterVehicleId = {{ $vehicle->id }};
    const filterGroupId = {{ $vehicle->group_id }};
</script>
@include('vendor.availability.partial-js')
@endsection
