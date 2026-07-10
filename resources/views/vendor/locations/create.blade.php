@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
            <div>
                <h2>Add Location</h2>
            </div>
        </div>

        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.locations.store') }}" id="locationForm">
                @csrf

                {{-- Row 1: Type | Location | Price --}}
                <div class="row">
                    {{-- Type --}}
                    <div class="col-md-4 mb-4">
                        <label for="type" class="form-label-custom">Type <span style="color:#ef4444;">*</span></label>
                        <select class="form-select form-input-custom @error('type') is-invalid @enderror"
                                name="type" id="type" required
                                style="padding:12px;font-size:0.95rem;">
                            <option value="">Select Type</option>
                            @foreach($types as $t)
                                <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Location --}}
                    <div class="col-md-4 mb-4">
                        <label for="location" class="form-label-custom">Location <span style="color:#ef4444;">*</span></label>
                        <input type="text"
                               class="form-control form-input-custom @error('location') is-invalid @enderror"
                               name="location" id="location"
                               value="{{ old('location') }}"
                               required placeholder="Location"
                               style="padding:12px;font-size:0.95rem;" />
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Price --}}
                    <div class="col-md-4 mb-4">
                        <label for="price" class="form-label-custom">Price <span style="color:#ef4444;">*</span></label>
                        <input type="number" step="0.01" min="0"
                               class="form-control form-input-custom @error('price') is-invalid @enderror"
                               name="price" id="price"
                               value="{{ old('price') }}"
                               required placeholder="Price"
                               style="padding:12px;font-size:0.95rem;" />
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Row 2: Map Type | Conditional fields --}}
                <div class="row">
                    {{-- Map Type --}}
                    <div class="col-md-4 mb-4">
                        <label for="map_type" class="form-label-custom">Map Type</label>
                        <select class="form-select form-input-custom @error('map_type') is-invalid @enderror"
                                name="map_type" id="map_type"
                                style="padding:12px;font-size:0.95rem;"
                                onchange="toggleMapFields(this.value)">
                            <option value="coordinates" {{ old('map_type','coordinates') === 'coordinates' ? 'selected' : '' }}>Coordinates</option>
                            <option value="embedded"    {{ old('map_type') === 'embedded' ? 'selected' : '' }}>Embedded Map (iframe)</option>
                        </select>
                        @error('map_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Latitude (coordinates) --}}
                    <div class="col-md-4 mb-4" id="field-latitude">
                        <label for="latitude" class="form-label-custom">Latitude</label>
                        <input type="text"
                               class="form-control form-input-custom @error('latitude') is-invalid @enderror"
                               name="latitude" id="latitude"
                               value="{{ old('latitude') }}"
                               placeholder="e.g. 28.6139"
                               style="padding:12px;font-size:0.95rem;" />
                        @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Longitude (coordinates) --}}
                    <div class="col-md-4 mb-4" id="field-longitude">
                        <label for="longitude" class="form-label-custom">Longitude</label>
                        <input type="text"
                               class="form-control form-input-custom @error('longitude') is-invalid @enderror"
                               name="longitude" id="longitude"
                               value="{{ old('longitude') }}"
                               placeholder="e.g. 77.2090"
                               style="padding:12px;font-size:0.95rem;" />
                        @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Embed code (embedded) --}}
                    <div class="col-md-8 mb-4" id="field-embed" style="display:none;">
                        <label for="map_embed" class="form-label-custom">Map Embed Code (iframe)</label>
                        <textarea class="form-control form-input-custom @error('map_embed') is-invalid @enderror"
                                  name="map_embed" id="map_embed" rows="3"
                                  placeholder="Paste your Google Maps embed iframe code here..."
                                  style="padding:12px;font-size:0.95rem;resize:vertical;">{{ old('map_embed') }}</textarea>
                        @error('map_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div style="display:flex;justify-content:flex-end;padding-top:8px;gap:12px;">
                    <a href="{{ route('vendor.locations.index') }}" class="btn btn-secondary" style="padding:10px 20px;font-size:0.95rem;text-decoration:none;display:inline-flex;align-items:center;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="padding:10px 28px;font-size:0.95rem;font-weight:600;">
                        ADD
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .loc-label {
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 800;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: block;
        }
    </style>
@endsection

@section('js')
<script>
function toggleMapFields(val) {
    const isCoords  = val === 'coordinates';
    document.getElementById('field-latitude').style.display  = isCoords ? '' : 'none';
    document.getElementById('field-longitude').style.display = isCoords ? '' : 'none';
    document.getElementById('field-embed').style.display     = isCoords ? 'none' : '';
}

document.addEventListener('DOMContentLoaded', function () {
    // Apply on load for old() values
    toggleMapFields(document.getElementById('map_type').value);

    @if(session('success'))
    Swal.fire({
        title: 'Success!',
        text: "{{ session('success') }}",
        icon: 'success',
        timer: 3000,
        showConfirmButton: false
    });
    @endif
});
</script>
@endsection
