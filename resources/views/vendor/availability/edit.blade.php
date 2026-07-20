@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h2 style="font-size:1.4rem;color:#111827;margin:0;">Edit Rate</h2>
                <p class="panel-muted" style="margin:4px 0 0;font-size:0.9rem;">
                    Modify the pricing rate for a vehicle group or specific vehicle.
                </p>
            </div>
            <nav style="font-size:0.85rem;color:#94a3b8;">
                <a href="{{ route('vendor.availability.index') }}" style="color:#0f766e;text-decoration:none;">Pricing</a>
                <span style="margin:0 6px;">/</span>
                <span>Edit Rate</span>
            </nav>
        </div>

        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.availability.update', $availability->id) }}" id="rateForm">
                @csrf
                @method('PUT')

                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="group_id" class="loc-label">Vehicle Group <span style="color:#ef4444;">*</span></label>
                        <select class="form-select @error('group_id') is-invalid @enderror"
                                name="group_id" id="group_id" required
                                style="border-radius:var(--radius);padding:12px;font-size:0.95rem;">
                            <option value="">Select Group</option>
                            @foreach($groups as $g)
                                <option value="{{ $g->id }}" {{ old('group_id', $availability->group_id) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                            @endforeach
                        </select>
                        @error('group_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="vehicle_id" class="loc-label">Specific Vehicle (Optional Override)</label>
                        <select class="form-select @error('vehicle_id') is-invalid @enderror"
                                name="vehicle_id" id="vehicle_id"
                                style="border-radius:var(--radius);padding:12px;font-size:0.95rem;">
                            <option value="">-- Apply to all vehicles in group --</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}" data-group="{{ $v->group_id }}" {{ old('vehicle_id', $availability->vehicle_id) == $v->id ? 'selected' : '' }}>
                                    {{ $v->name }} ({{ $v->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('vehicle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small style="color: #94a3b8; font-size: 0.8rem;">Leave blank to apply this rate to the entire group.</small>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="pickup_date" class="loc-label">Pickup Date <span style="color:#ef4444;">*</span></label>
                        <input type="date"
                               class="form-control @error('pickup_date') is-invalid @enderror"
                               name="pickup_date" id="pickup_date"
                               value="{{ old('pickup_date', $availability->pickup_date->format('Y-m-d')) }}"
                               required
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('pickup_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="dropup_date" class="loc-label">Drop-off Date <span style="color:#ef4444;">*</span></label>
                        <input type="date"
                               class="form-control @error('dropup_date') is-invalid @enderror"
                               name="dropup_date" id="dropup_date"
                               value="{{ old('dropup_date', $availability->dropup_date->format('Y-m-d')) }}"
                               required
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('dropup_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label for="rental_period_id" class="loc-label">Rental Period (Optional preset)</label>
                        <select class="form-select @error('rental_period_id') is-invalid @enderror"
                                name="rental_period_id" id="rental_period_id"
                                style="border-radius:var(--radius);padding:12px;font-size:0.95rem;">
                            <option value="">Custom Days...</option>
                            @foreach($periods as $p)
                                <option value="{{ $p->id }}" data-min="{{ $p->min_day }}" data-max="{{ $p->max_day }}" {{ old('rental_period_id', $availability->rental_period_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->label }}
                                </option>
                            @endforeach
                        </select>
                        @error('rental_period_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-2 mb-4">
                        <label for="min_day" class="loc-label">Min Day <span style="color:#ef4444;">*</span></label>
                        <input type="number"
                               class="form-control @error('min_day') is-invalid @enderror"
                               name="min_day" id="min_day"
                               value="{{ old('min_day', $availability->min_day) }}"
                               required min="1"
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('min_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-2 mb-4">
                        <label for="max_day" class="loc-label">Max Day <span style="color:#ef4444;">*</span></label>
                        <input type="number"
                               class="form-control @error('max_day') is-invalid @enderror"
                               name="max_day" id="max_day"
                               value="{{ old('max_day', $availability->max_day) }}"
                               required min="1"
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('max_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="price" class="loc-label">Daily Price <span style="color:#ef4444;">*</span></label>
                        <input type="number" step="0.01" min="0"
                               class="form-control @error('price') is-invalid @enderror"
                               name="price" id="price"
                               value="{{ old('price', $availability->price) }}"
                               required placeholder="0.00"
                               style="border:1px solid #d7e0e8;border-radius:var(--radius);padding:12px;font-size:0.95rem;" />
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label for="status" class="loc-label">Status <span style="color:#ef4444;">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                name="status" id="status" required
                                style="border-radius:var(--radius);padding:12px;font-size:0.95rem;">
                            <option value="1" {{ old('status', $availability->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $availability->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                
                <div style="display:flex;justify-content:flex-end;padding-top:8px;">
                    <a href="{{ route('vendor.availability.index') }}"
                       style="padding:10px 20px;border:1px solid #d7e0e8;border-radius:var(--radius);color:#64748b;background:#fff;font-size:0.95rem;margin-right:10px;text-decoration:none;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary"
                            style="padding:10px 28px;font-size:0.95rem;font-weight:600;">
                        UPDATE RATE
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
document.addEventListener('DOMContentLoaded', function () {
    const groupSelect = document.getElementById('group_id');
    const vehicleSelect = document.getElementById('vehicle_id');
    const periodSelect = document.getElementById('rental_period_id');
    const minDayInput = document.getElementById('min_day');
    const maxDayInput = document.getElementById('max_day');

    // Filter vehicles by selected group
    function filterVehicles() {
        const groupId = groupSelect.value;
        let hasOptions = false;
        
        Array.from(vehicleSelect.options).forEach(opt => {
            if (opt.value === "") return; // keep "apply to all" option
            if (opt.dataset.group === groupId || !groupId) {
                opt.style.display = '';
                hasOptions = true;
            } else {
                opt.style.display = 'none';
                if (vehicleSelect.value === opt.value) {
                    vehicleSelect.value = '';
                }
            }
        });
    }

    groupSelect.addEventListener('change', filterVehicles);
    filterVehicles(); // init on load

    // Auto-fill min/max days when period selected
    periodSelect.addEventListener('change', function() {
        const selectedOpt = this.options[this.selectedIndex];
        if (this.value) {
            minDayInput.value = selectedOpt.dataset.min;
            maxDayInput.value = selectedOpt.dataset.max;
            minDayInput.readOnly = true;
            maxDayInput.readOnly = true;
        } else {
            minDayInput.readOnly = false;
            maxDayInput.readOnly = false;
        }
    });
    
    // Only dispatch change if it wasn't pre-filled by old input manually overriding
    if (periodSelect.value && !minDayInput.value) {
        periodSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
