@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2>Generate Maintenance Request</h2>
            <p class="panel-muted" style="margin: 4px 0 0 0; font-size: 0.88rem;">Create a maintenance service request for a fleet vehicle.</p>
        </div>
        <a href="{{ route('vendor.maintenance-requests.index') }}" class="btn btn-secondary">
            &larr; Back to Requests
        </a>
    </div>

    <div class="panel-body" style="padding: 24px; max-width: 680px;">
        <form action="{{ route('vendor.maintenance-requests.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Select Vehicle <span style="color: #ef4444;">*</span></label>
                <select name="vehicle_id" required class="form-control" style="width: 100%; padding: 10px 14px;">
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}">[{{ $v->code ?? ('VEH-'.$v->id) }}] {{ $v->name }} ({{ $v->reg_number ?? 'REG' }})</option>
                    @endforeach
                    <option value="901">[VEH-901] Tata Nexon EV (DL03 EF 9012)</option>
                    <option value="902">[VEH-902] Kia Seltos (MH12 JK 7890)</option>
                    <option value="903">[VEH-903] Mahindra XUV700 (GJ05 GH 3344)</option>
                    <option value="904">[VEH-904] Hyundai Creta (GJ01 AB 1234)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Interval Type <span style="color: #ef4444;">*</span></label>
                    <select name="interval_type" required class="form-control" style="width: 100%; padding: 10px 14px;">
                        <!-- <option value="Time & Inspection">Time & Inspection</option> -->
                        <option value="Engine Hours">Engine Hours</option>
                        <!-- <option value="Odometer Km">Odometer Km</option> -->
                        <!-- <option value="Emergency Repair">Emergency Repair</option> -->
                    </select>
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Priority Level</label>
                    <select name="priority" class="form-control" style="width: 100%; padding: 10px 14px;">
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Low">Low</option>
                        <option value="Emergency">Emergency</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-weight: 600; margin-bottom: 8px;">Service Reason & Checklist <span style="color: #ef4444;">*</span></label>
                <textarea name="checklist" rows="3" placeholder="Describe requested maintenance (e.g., Brake pad noise, Battery check, Oil change)" required class="form-control" style="width: 100%; padding: 10px 14px;"></textarea>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-weight: 700;">Submit Request</button>
                <a href="{{ route('vendor.maintenance-requests.index') }}" class="btn btn-secondary" style="padding: 10px 20px;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
