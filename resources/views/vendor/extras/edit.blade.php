@extends('admin.layouts.app')

@section('title', $type === 'extra' ? 'Edit Extra' : 'Edit Insurance')

@section('main-content')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ============================================
   Tom Select Theme Override – Dark Mode Match
   ============================================ */
.ts-wrapper.multi .ts-control {
    background-color: transparent !important;
    border: 1px solid var(--brand, #52ead2) !important;
    border-radius: var(--radius, 8px) !important;
    min-height: 48px !important;
    padding: 6px 10px !important;
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    gap: 8px !important;
    color: #e2e8f0 !important;
}
.ts-wrapper.multi.focus .ts-control {
    border-color: var(--brand, #52ead2) !important;
    box-shadow: 0 0 0 3px rgba(82, 234, 210, 0.15) !important;
}
.ts-wrapper.multi .ts-control > input {
    color: #e2e8f0 !important;
    font-size: 0.9rem !important;
}
.ts-wrapper.multi .ts-control > input::placeholder {
    color: var(--muted-2, #94a3b8) !important;
}
.ts-wrapper.multi .ts-control .item {
    background-color: var(--brand, #52ead2) !important;
    border: none !important;
    border-radius: 6px !important;
    color: #051013 !important;
    font-size: 0.85rem !important;
    font-weight: 700 !important;
    padding: 4px 6px 4px 10px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    margin: 0 !important;
}
.ts-wrapper.multi .ts-control .item .remove {
    color: rgba(5, 16, 19, 0.7) !important;
    font-size: 1.1rem !important;
    font-weight: 400 !important;
    border-left: none !important;
    padding-left: 0 !important;
    margin-left: 0 !important;
    text-decoration: none !important;
}
.ts-wrapper.multi .ts-control .item .remove:hover {
    color: #000000 !important;
    background: transparent !important;
}
.ts-dropdown {
    background: var(--bg-2, #0b1020) !important;
    border: 1px solid rgba(255,255,255,0.14) !important;
    border-radius: 6px !important;
    box-shadow: 0 8px 24px rgba(0,0,0,0.4) !important;
    z-index: 9999 !important;
    overflow: hidden !important;
    margin-top: 4px !important;
    color: #e2e8f0 !important;
}
.ts-dropdown .option {
    color: #e2e8f0 !important;
    font-size: 0.9rem !important;
    padding: 10px 14px !important;
    background-color: transparent !important;
    cursor: pointer !important;
}
.ts-dropdown .option:hover,
.ts-dropdown .option.active {
    background-color: rgba(255, 255, 255, 0.08) !important; 
    color: var(--brand, #52ead2) !important;
}
.ts-dropdown .option.selected {
    background-color: rgba(82, 234, 210, 0.15) !important;
    color: var(--brand, #52ead2) !important;
    font-weight: 600 !important;
}
</style>
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">{{ $type === 'extra' ? 'Edit Extra' : 'Edit Insurance' }}</h2>
            </div>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <ul style="margin:0;padding-left:18px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('vendor.extras.update', $item->id) }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">

                <!-- Row 1 -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label for="name" class="form-label-custom">{{ $type === 'extra' ? 'Extra Name' : 'Insurance Name' }} <span style="color:#ef4444">*</span></label>
                        <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" name="name" id="name"
                            value="{{ old('name', $item->name) }}" required placeholder="Enter {{ $type === 'extra' ? 'extra' : 'insurance' }} name"  />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="price" class="form-label-custom">Online Pay Price <span style="color:#ef4444">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-input-custom @error('price') is-invalid @enderror" name="price" id="price"
                            value="{{ old('price', $item->price) }}" required placeholder="Enter Online Pay Price"  />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="arrival_price" class="form-label-custom">Arrival Pay Price <span style="color:#ef4444">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-input-custom @error('arrival_price') is-invalid @enderror" name="arrival_price" id="arrival_price"
                            value="{{ old('arrival_price', $item->arrival_price) }}" required placeholder="Enter Arrival Price"  />
                        @error('arrival_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="icon_class" class="form-label-custom">Icon Class <span style="color:#ef4444">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <select class="form-select form-input-custom @error('icon_class') is-invalid @enderror" name="icon_class" id="icon_class" onchange="fcIconPrev()" style=" border-radius: var(--radius); padding: 12px; font-size: 0.95rem; min-height: 48px; flex: 1;">
                                <option value="">Select Icon</option>
                                @if($type === 'extra')
                                    <option value="fas fa-user-plus"      {{ old('icon_class', $item->icon_class)=='fas fa-user-plus' ? 'selected':'' }}>Additional Driver</option>
                                    <option value="fas fa-map-marker-alt" {{ old('icon_class', $item->icon_class)=='fas fa-map-marker-alt' ? 'selected':'' }}>GPS Navigation System</option>
                                    <option value="fas fa-baby"           {{ old('icon_class', $item->icon_class)=='fas fa-baby' ? 'selected':'' }}>Baby Seat (0-13kg)</option>
                                    <option value="fas fa-child"          {{ old('icon_class', $item->icon_class)=='fas fa-child' ? 'selected':'' }}>Child Seat (9-18kg)</option>
                                    <option value="fas fa-wifi"           {{ old('icon_class', $item->icon_class)=='fas fa-wifi' ? 'selected':'' }}>WiFi</option>
                                    <option value="fas fa-snowflake"      {{ old('icon_class', $item->icon_class)=='fas fa-snowflake' ? 'selected':'' }}>Snow Chains</option>
                                    <option value="fas fa-car"            {{ old('icon_class', $item->icon_class)=='fas fa-car' ? 'selected':'' }}>Extra Car Seat</option>
                                    <option value="fas fa-gas-pump"       {{ old('icon_class', $item->icon_class)=='fas fa-gas-pump' ? 'selected':'' }}>Fuel Option</option>
                                    <option value="fas fa-parking"        {{ old('icon_class', $item->icon_class)=='fas fa-parking' ? 'selected':'' }}>Parking Pass</option>
                                    <option value="fas fa-road"           {{ old('icon_class', $item->icon_class)=='fas fa-road' ? 'selected':'' }}>Roadside Assistance</option>
                                    <option value="fas fa-box"            {{ old('icon_class', $item->icon_class)=='fas fa-box' ? 'selected':'' }}>Other</option>
                                @else
                                    <option value="fas fa-shield-alt"       {{ old('icon_class', $item->icon_class)=='fas fa-shield-alt' ? 'selected':'' }}>Full Insurance</option>
                                    <option value="fas fa-umbrella"         {{ old('icon_class', $item->icon_class)=='fas fa-umbrella' ? 'selected':'' }}>Basic Insurance</option>
                                    <option value="fas fa-road"             {{ old('icon_class', $item->icon_class)=='fas fa-road' ? 'selected':'' }}>Roadside Assistance</option>
                                    <option value="fas fa-car-crash"        {{ old('icon_class', $item->icon_class)=='fas fa-car-crash' ? 'selected':'' }}>Collision Coverage</option>
                                    <option value="fas fa-heartbeat"        {{ old('icon_class', $item->icon_class)=='fas fa-heartbeat' ? 'selected':'' }}>Personal Injury</option>
                                    <option value="fas fa-lock"             {{ old('icon_class', $item->icon_class)=='fas fa-lock' ? 'selected':'' }}>Theft Protection</option>
                                    <option value="fas fa-tools"            {{ old('icon_class', $item->icon_class)=='fas fa-tools' ? 'selected':'' }}>Breakdown Coverage</option>
                                @endif
                            </select>
                            <div id="fc_prev" style="width: 48px; height: 48px; border: 1px solid #d7e0e8; border-radius: var(--radius); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #475569; background: #f8fafc; flex-shrink: 0;">
                                <i class="{{ old('icon_class', $item->icon_class ?: ($type === 'extra' ? 'fas fa-box' : 'fas fa-shield-alt')) }}"></i>
                            </div>
                        </div>
                        <small style="display:block; margin-top:5px; font-size:0.77rem; color:#94a3b8;">Font Awesome icon classes (e.g., fas fa-user-plus)</small>
                        @error('icon_class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label-custom">Status <span style="color:#ef4444">*</span></label>
                        <select class="form-select form-input-custom @error('status') is-invalid @enderror" name="status" id="status" required >
                            <option value="1" {{ old('status', $item->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $item->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label for="refunded_amount" class="form-label-custom">Refundable Deposit Amount <span style="color:#ef4444">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-input-custom @error('refunded_amount') is-invalid @enderror" name="refunded_amount" id="refunded_amount"
                            value="{{ old('refunded_amount', $item->refunded_amount) }}" required placeholder="Enter Refundable Amount"  />
                        @error('refunded_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="excess_amount" class="form-label-custom">Excess Amount <span style="color:#ef4444">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-input-custom @error('excess_amount') is-invalid @enderror" name="excess_amount" id="excess_amount"
                            value="{{ old('excess_amount', $item->excess_amount) }}" required placeholder="Enter Excess Amount"  />
                        @error('excess_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="group_ids" class="form-label-custom">Group Type</label>
                        <select class="form-select form-input-custom select2-multi @error('group_ids') is-invalid @enderror" name="group_ids[]" id="group_ids" multiple>
                            @if(isset($groups))
                                @foreach($groups as $group)
                                    @php
                                        $selected = old('group_ids', $item->group_ids ?? []);
                                        if (!is_array($selected)) $selected = [];
                                    @endphp
                                    <option value="{{ $group->id }}" {{ in_array($group->id, $selected) ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('group_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                </div>

                <!-- Manage Features Mapping Static Design -->
                <div class="row mb-4 mt-2">
                    <div class="col-md-12">
                        <h6 class="text-white mb-1" style="font-weight: 600; font-size: 0.95rem;">Manage Features Mapping</h6>
                        <div class="table-responsive mt-3" style="border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; overflow: hidden;">
                            <table class="table table-bordered table-hover text-white mb-0 align-middle" style="background: var(--bg-2, #0b1020);">
                                <thead style="background: rgba(255,255,255,0.02);">
                                    <tr>
                                        <th class="text-center" style="width: 100px; border-color: rgba(255,255,255,0.1); color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">Sort Order</th>
                                        <th style="border-color: rgba(255,255,255,0.1); color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">Feature Title</th>
                                        @if(isset($insurances))
                                            @foreach($insurances as $ins)
                                                <th class="text-center" style="border-color: rgba(255,255,255,0.1); color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">{{ $ins->name }}</th>
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($vendor_features))
                                        @foreach($vendor_features as $feature)
                                            <tr>
                                                <td class="text-center" style="border-color: rgba(255,255,255,0.1);">
                                                    <input type="number" min="1" 
                                                        oninput="if(this.value < 1) this.value = 1;" 
                                                        onfocus="this.dataset.prev = this.value;"
                                                        onchange="updateFeatureSortOrder(this)"
                                                        data-feature-id="{{ $feature->id }}"
                                                        class="form-control form-control-sm text-center d-inline-block sort-order-input" 
                                                        style="width: 60px; background:var(--bg, #050711); color:#fff; border:1px solid rgba(255,255,255,0.2);" 
                                                        value="{{ $feature->index_no > 0 ? $feature->index_no : $loop->iteration }}">
                                                </td>
                                                <td style="border-color: rgba(255,255,255,0.1);">{{ $feature->title }}</td>
                                                @if(isset($insurances))
                                                    @foreach($insurances as $ins)
                                                        <td class="text-center" style="border-color: rgba(255,255,255,0.1);">
                                                            <input type="checkbox" class="form-check-input feature-map-checkbox" 
                                                                data-feature-id="{{ $feature->id }}" 
                                                                data-extra-id="{{ $ins->id }}"
                                                                {{ (isset($existing_mappings[$feature->id]) && in_array($ins->id, $existing_mappings[$feature->id])) ? 'checked' : '' }}
                                                                style="cursor:pointer; width:1.2rem; height:1.2rem;">
                                                        </td>
                                                    @endforeach
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #2563eb); border: none; color: #fff; cursor: pointer;">{{ $type === 'extra' ? 'Update Extra' : 'Update Insurance' }}</button>
                    <a href="{{ $type === 'extra' ? route('vendor.extras.index') : route('vendor.insurance.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
function fcIconPrev() {
    const val = document.getElementById('icon_class').value;
    const def = '{{ $type === "extra" ? "fas fa-box" : "fas fa-shield-alt" }}';
    document.getElementById('fc_prev').innerHTML = val ? `<i class="${val}"></i>` : `<i class="${def}"></i>`;
}
fcIconPrev();

window.updateFeatureSortOrder = function(input) {
    const val = parseInt(input.value);
    const prev = parseInt(input.dataset.prev || input.value);
    const featureId = input.getAttribute('data-feature-id');

    if (isNaN(val) || val < 1) {
        input.value = prev;
        return;
    }

    // Check UI duplicates first
    let hasDuplicate = false;
    document.querySelectorAll('.sort-order-input').forEach(function(el) {
        if (el !== input && parseInt(el.value) === val) {
            hasDuplicate = true;
        }
    });

    if (hasDuplicate) {
        alert('Sort Order must be unique! This value is already assigned.');
        input.value = prev;
        return;
    }

    // Call AJAX to update sort order in DB
    fetch(`/vendor/features/${featureId}/sort`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            index_no: val
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.dataset.prev = val;
            console.log(data.message);
        } else {
            alert('Error: ' + data.message);
            input.value = prev;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        input.value = prev;
    });
};

document.addEventListener('DOMContentLoaded', function() {
    new TomSelect('#group_ids', {
        plugins: ['remove_button'],
        placeholder: 'Select Group Types',
        hideSelected: false,
        closeAfterSelect: false,
        onInitialize: function() {
            this.control.style.backgroundColor = 'transparent';
            this.control.style.border = 'none';
        }
    });

    // Checkbox AJAX toggle mapping
    document.querySelectorAll('.feature-map-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const featureId = this.getAttribute('data-feature-id');
            const extraId = this.getAttribute('data-extra-id');
            const isMapped = this.checked ? 1 : 0;
            const self = this;

            fetch('{{ route("vendor.features.mapping.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    vendor_feature_id: featureId,
                    vendor_extra_id: extraId,
                    is_mapped: isMapped
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data.message);
                } else {
                    alert('Error: ' + data.message);
                    self.checked = !isMapped; // Revert
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                self.checked = !isMapped; // Revert
            });
        });
    });
});
</script>
@endsection
