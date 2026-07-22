@extends('admin.layouts.app')

@section('title', $type === 'extra' ? 'Add New Extra' : 'Add New Insurance')

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
/* Checkbox Theme Accent Redesign & Double-Checkmark Fix */
.form-check-input {
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
    accent-color: initial !important;
    width: 1.2rem !important;
    height: 1.2rem !important;
    background-color: var(--bg, #050711) !important;
    background-repeat: no-repeat !important;
    background-position: center !important;
    background-size: 0.75rem 0.75rem !important;
    border: 1px solid rgba(255, 255, 255, 0.25) !important;
    border-radius: 4px !important;
    cursor: pointer !important;
    vertical-align: middle !important;
    box-shadow: none !important;
}
.form-check-input:checked {
    background-color: var(--brand, #52ead2) !important;
    border-color: var(--brand, #52ead2) !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M4 10l4 4l8-8'/%3e%3c/svg%3e") !important;
}
</style>
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">{{ $type === 'extra' ? 'Add New Extra' : 'Add New Insurance' }}</h2>
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

            <form method="POST" action="{{ route('vendor.extras.store') }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">

                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label for="name" class="form-label-custom">{{ $type === 'extra' ? 'Extra Name' : 'Insurance Name' }} <span style="color:#ef4444">*</span></label>
                        <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" name="name" id="name"
                            value="{{ old('name') }}" required placeholder="Enter {{ $type === 'extra' ? 'extra' : 'insurance' }} name"  />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="price" class="form-label-custom">Online Pay Price <span style="color:#ef4444">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-input-custom @error('price') is-invalid @enderror" name="price" id="price"
                            value="{{ old('price') }}" required placeholder="Enter Online Pay Price"  />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="arrival_price" class="form-label-custom">Arrival Pay Price <span style="color:#ef4444">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-input-custom @error('arrival_price') is-invalid @enderror" name="arrival_price" id="arrival_price"
                            value="{{ old('arrival_price') }}" required placeholder="Enter Arrival Price"  />
                        @error('arrival_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="icon_class" class="form-label-custom">Icon Class <span style="color:#ef4444">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <select class="form-select form-input-custom @error('icon_class') is-invalid @enderror" name="icon_class" id="icon_class" onchange="fcIconPrev()" style=" border-radius: var(--radius); padding: 12px; font-size: 0.95rem; min-height: 48px; flex: 1;">
                                <option value="">Select Icon</option>
                                @if($type === 'extra')
                                    <option value="fas fa-user-plus"      {{ old('icon_class')=='fas fa-user-plus' ? 'selected':'' }}>Additional Driver</option>
                                    <option value="fas fa-map-marker-alt" {{ old('icon_class')=='fas fa-map-marker-alt' ? 'selected':'' }}>GPS Navigation System</option>
                                    <option value="fas fa-baby"           {{ old('icon_class')=='fas fa-baby' ? 'selected':'' }}>Baby Seat (0-13kg)</option>
                                    <option value="fas fa-child"          {{ old('icon_class')=='fas fa-child' ? 'selected':'' }}>Child Seat (9-18kg)</option>
                                    <option value="fas fa-wifi"           {{ old('icon_class')=='fas fa-wifi' ? 'selected':'' }}>WiFi</option>
                                    <option value="fas fa-snowflake"      {{ old('icon_class')=='fas fa-snowflake' ? 'selected':'' }}>Snow Chains</option>
                                    <option value="fas fa-car"            {{ old('icon_class')=='fas fa-car' ? 'selected':'' }}>Extra Car Seat</option>
                                    <option value="fas fa-gas-pump"       {{ old('icon_class')=='fas fa-gas-pump' ? 'selected':'' }}>Fuel Option</option>
                                    <option value="fas fa-parking"        {{ old('icon_class')=='fas fa-parking' ? 'selected':'' }}>Parking Pass</option>
                                    <option value="fas fa-road"           {{ old('icon_class')=='fas fa-road' ? 'selected':'' }}>Roadside Assistance</option>
                                    <option value="fas fa-box"            {{ old('icon_class')=='fas fa-box' ? 'selected':'' }}>Other</option>
                                @else
                                    <option value="fas fa-shield-alt"       {{ old('icon_class')=='fas fa-shield-alt' ? 'selected':'' }}>Full Insurance</option>
                                    <option value="fas fa-umbrella"         {{ old('icon_class')=='fas fa-umbrella' ? 'selected':'' }}>Basic Insurance</option>
                                    <option value="fas fa-road"             {{ old('icon_class')=='fas fa-road' ? 'selected':'' }}>Roadside Assistance</option>
                                    <option value="fas fa-car-crash"        {{ old('icon_class')=='fas fa-car-crash' ? 'selected':'' }}>Collision Coverage</option>
                                    <option value="fas fa-heartbeat"        {{ old('icon_class')=='fas fa-heartbeat' ? 'selected':'' }}>Personal Injury</option>
                                    <option value="fas fa-lock"             {{ old('icon_class')=='fas fa-lock' ? 'selected':'' }}>Theft Protection</option>
                                    <option value="fas fa-tools"            {{ old('icon_class')=='fas fa-tools' ? 'selected':'' }}>Breakdown Coverage</option>
                                @endif
                            </select>
                             <div id="fc_prev" style="width: 48px; height: 48px; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--brand, #52ead2); background: rgba(255, 255, 255, 0.03); flex-shrink: 0;">
                                 <i class="{{ old('icon_class', $type === 'extra' ? 'fas fa-box' : 'fas fa-shield-alt') }}"></i>
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
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label for="refunded_amount" class="form-label-custom">Refundable Deposit Amount <span style="color:#ef4444">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-input-custom @error('refunded_amount') is-invalid @enderror" name="refunded_amount" id="refunded_amount"
                            value="{{ old('refunded_amount') }}" required placeholder="Enter Refundable Amount"  />
                        @error('refunded_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="excess_amount" class="form-label-custom">Excess Amount <span style="color:#ef4444">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control form-input-custom @error('excess_amount') is-invalid @enderror" name="excess_amount" id="excess_amount"
                            value="{{ old('excess_amount') }}" required placeholder="Enter Excess Amount"  />
                        @error('excess_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="group_ids" class="form-label-custom">Group Type</label>
                        <select class="form-select form-input-custom select2-multi @error('group_ids') is-invalid @enderror" name="group_ids[]" id="group_ids" multiple>
                            @if(isset($groups))
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ (is_array(old('group_ids')) && in_array($group->id, old('group_ids'))) ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('group_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

               

                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%); border: none; color: #051013; cursor: pointer;">{{ $type === 'extra' ? 'Create Extra' : 'Create Insurance' }}</button>
                    <a href="{{ $type === 'extra' ? route('vendor.extras.index') : route('vendor.insurance.index') }}" class="btn btn-link text-muted cancel-link">Cancel</a>
                </div>
            </form>
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
});
</script>
@endsection
