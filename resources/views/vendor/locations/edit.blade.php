@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h2 style="font-size:1.4rem;color:#111827;margin:0;">Edit Location</h2>
               
            </div>
            <nav style="font-size:0.85rem;color:#94a3b8;">
                <a href="{{ route('vendor.locations.index') }}" style="color:#0f766e;text-decoration:none;">Location</a>
                <span style="margin:0 6px;">/</span>
                <span>Edit Location</span>
            </nav>
        </div>

        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.locations.update', $location->id) }}" id="locationForm">
                @csrf
                @method('PUT')

                {{-- Row 1: Type | Location | Price --}}
                <div class="row">
                    {{-- Type --}}
                    <div class="col-md-4 mb-4">
                        <label for="type" class="loc-label">Type <span style="color:#ef4444;">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror"
                                name="type" id="type" required
                                style="border-radius:var(--radius);padding:12px;font-size:0.95rem;">
                            <option value="">Select Type</option>
                            @foreach($types as $t)
                                <option value="{{ $t }}" {{ old('type', $location->type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Location --}}
                    <div class="col-md-4 mb-4">
                        <label for="location" class="loc-label">Location <span style="color:#ef4444;">*</span></label>
                        <input type="text"
                               class="form-control @error('location') is-invalid @enderror"
                               name="location" id="location"
                               value="{{ old('location', $location->location) }}"
                               required placeholder="Location"
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Price --}}
                    <div class="col-md-4 mb-4">
                        <label for="price" class="loc-label">Price <span style="color:#ef4444;">*</span></label>
                        <input type="number" step="0.01" min="0"
                               class="form-control @error('price') is-invalid @enderror"
                               name="price" id="price"
                               value="{{ old('price', $location->price) }}"
                               required placeholder="Price"
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Row 2: Map Type | Conditional fields --}}
                <div class="row">
                    {{-- Map Type --}}
                    <div class="col-md-4 mb-4">
                        <label for="map_type" class="loc-label">Map Type</label>
                        <select class="form-select @error('map_type') is-invalid @enderror"
                                name="map_type" id="map_type"
                                style="border-radius:var(--radius);padding:12px;font-size:0.95rem;"
                                onchange="toggleMapFields(this.value)">
                            <option value="coordinates" {{ old('map_type', $location->map_type) === 'coordinates' ? 'selected' : '' }}>Coordinates</option>
                            <option value="embedded"    {{ old('map_type', $location->map_type) === 'embedded'    ? 'selected' : '' }}>Embedded Map (iframe)</option>
                        </select>
                        @error('map_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Latitude --}}
                    <div class="col-md-4 mb-4" id="field-latitude">
                        <label for="latitude" class="loc-label">Latitude</label>
                        <input type="text"
                               class="form-control @error('latitude') is-invalid @enderror"
                               name="latitude" id="latitude"
                               value="{{ old('latitude', $location->latitude) }}"
                               placeholder="e.g. 28.6139"
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Longitude --}}
                    <div class="col-md-4 mb-4" id="field-longitude">
                        <label for="longitude" class="loc-label">Longitude</label>
                        <input type="text"
                               class="form-control @error('longitude') is-invalid @enderror"
                               name="longitude" id="longitude"
                               value="{{ old('longitude', $location->longitude) }}"
                               placeholder="e.g. 77.2090"
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Embed code --}}
                    <div class="col-md-8 mb-4" id="field-embed" style="display:none;">
                        <label for="map_embed" class="loc-label">Map Embed Code (iframe)</label>
                        <textarea class="form-control @error('map_embed') is-invalid @enderror"
                                  name="map_embed" id="map_embed" rows="3"
                                  placeholder="Paste your Google Maps embed iframe code here..."
                                  style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;resize:vertical;">{{ old('map_embed', $location->map_embed) }}</textarea>
                        @error('map_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div style="display:flex;justify-content:flex-end;padding-top:8px;">
                    <a href="{{ route('vendor.locations.index') }}"
                       style="padding:10px 20px;border:1px solid #d7e0e8;border-radius:var(--radius);color:#64748b;background:#fff;font-size:0.95rem;margin-right:10px;text-decoration:none;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary"
                            style="padding:10px 28px;font-size:0.95rem;font-weight:600;">
                        UPDATE
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
