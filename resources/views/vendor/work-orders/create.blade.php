@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2>Create Vendor Work Order</h2>
            <p class="panel-muted" style="margin: 4px 0 0 0; font-size: 0.88rem;">Assign mechanics, track repair progress %, and control vehicle maintenance status locking.</p>
        </div>
        <a href="{{ route('vendor.work-orders.index') }}" class="btn btn-secondary">
            &larr; Back to Work Orders
        </a>
    </div>

    <div class="panel-body" style="padding: 24px; max-width: 680px;">
        <form action="{{ route('vendor.work-orders.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Select Vehicle <span style="color: #ef4444;">*</span></label>
                <select name="vehicle_id" required class="form-control" style="width: 100%; padding: 10px 14px;">
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}">[{{ $v->code ?? ('VEH-'.$v->id) }}] {{ $v->name }} ({{ $v->reg_number ?? 'REG' }})</option>
                    @endforeach
                    <option value="901">[VEH-901] Mahindra XUV700 (GJ05 GH 3344)</option>
                    <option value="902">[VEH-902] Hyundai Creta (GJ01 AB 1234)</option>
                    <option value="903">[VEH-903] BMW 3 Series (HR26 LM 1122)</option>
                    <option value="904">[VEH-904] Toyota Fortuner (MH02 CD 5678)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Assigned Workshop <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="mechanic" placeholder="e.g. Ramesh Repair Services" required class="form-control" style="width: 100%; padding: 10px 14px;">
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Vehicle Rental Status <span style="color: #ef4444;">*</span></label>
                    <select name="vehicle_status" required class="form-control" style="width: 100%; padding: 10px 14px;">
                        <option value="In Maintenance">In Maintenance</option>
                        <option value="Available">Available </option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Mechanic Progress (%) <span style="color: #ef4444;">*</span></label>
                <input type="number" name="progress" min="0" max="100" value="0" placeholder="e.g. 50" required class="form-control" style="width: 100%; padding: 10px 14px;">
            </div>

            <div style="margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 8px; background: rgba(2, 132, 199, 0.08); border: 1px solid rgba(2, 132, 199, 0.2); padding: 12px 16px; border-radius: 8px; font-size: 0.82rem; color: var(--brand, #0284c7);">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    Completing service (100%) automatically sets vehicle to Available & recalculates next service due date.
                </div>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-weight: 700;">Save Work Order</button>
                <a href="{{ route('vendor.work-orders.index') }}" class="btn btn-secondary" style="padding: 10px 20px;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
