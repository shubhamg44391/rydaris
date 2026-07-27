@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2>Add Maintenance Schedule</h2>
        </div>
        <a href="{{ route('vendor.maintenance-schedules.index') }}" class="btn btn-secondary">
            &larr; Back to Schedules
        </a>
    </div>

    <div class="panel-body" style="padding: 24px; max-width: 680px;">
        <form action="{{ route('vendor.maintenance-schedules.store') }}" method="POST">
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
                    <option value="903">[VEH-903] Toyota Fortuner (MH02 CD 5678)</option>
                    <option value="904">[VEH-904] Kia Seltos (MH12 JK 7890)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Schedule Interval Type <span style="color: #ef4444;">*</span></label>
                    <select name="interval_type" required class="form-control" style="width: 100%; padding: 10px 14px;">
                        <option value="Engine Hours">Engine Hours (Hrs)</option>
                    </select>
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Hrs <span style="color: #ef4444;">*</span></label>
                    <input type="number" name="trigger_limit" min="1" placeholder="e.g. 500" required class="form-control" style="width: 100%; padding: 10px 14px;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Service Checklist Items <span style="color: #ef4444;">*</span></label>
                <input type="text" name="checklist" placeholder="e.g. Engine Oil, Brake Pads, Air Filter Change" required class="form-control" style="width: 100%; padding: 10px 14px;">
            </div>

            <div style="margin-bottom: 24px;">
                <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Next Due Date</label>
                <input type="date" name="next_due_date" min="{{ date('Y-m-d') }}" class="form-control" style="width: 100%; padding: 10px 14px;">
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-weight: 700;">Save Schedule</button>
                <a href="{{ route('vendor.maintenance-schedules.index') }}" class="btn btn-secondary" style="padding: 10px 20px;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
