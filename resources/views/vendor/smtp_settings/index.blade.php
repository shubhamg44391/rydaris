@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2>SMTP Settings</h2>
            <p class="text-muted">Configure your mail server details to send emails.</p>
        </div>
        <div class="text-muted" style="font-size: 0.9rem;">
            Home / SMTP Settings
        </div>
    </div>

    <div class="admin-table-wrap p-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 12px;">
        <h5 class="mb-4" style="color: var(--brand); border-bottom: 1px solid rgba(82, 234, 210, 0.1); padding-bottom: 15px;">Manage SMTP Details</h5>
        
        @if(session('success'))
            <div class="alert alert-success" style="background: rgba(74, 222, 128, 0.1); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.2); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('vendor.smtp_settings.update') }}" method="POST">
            @csrf
            
            <div class="row mb-4 g-4">
                <div class="col-md-6">
                    <label class="form-label-custom" style="font-weight: 600;">SMTP Host</label>
                    <input type="text" name="smtp_host" value="{{ old('smtp_host', $setting->smtp_host ?? '') }}" class="form-control-custom w-100" placeholder="e.g. smtp.gmail.com" style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                    @error('smtp_host') <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label-custom" style="font-weight: 600;">SMTP Port</label>
                    <input type="text" name="smtp_port" value="{{ old('smtp_port', $setting->smtp_port ?? '') }}" class="form-control-custom w-100" placeholder="e.g. 587 or 465" style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                    @error('smtp_port') <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-4 g-4">
                <div class="col-md-6">
                    <label class="form-label-custom" style="font-weight: 600;">SMTP Username (Email)</label>
                    <input type="text" name="smtp_username" value="{{ old('smtp_username', $setting->smtp_username ?? '') }}" class="form-control-custom w-100" style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                    @error('smtp_username') <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom" style="font-weight: 600;">SMTP Password (App Password)</label>
                    <input type="password" name="smtp_password" value="{{ old('smtp_password', $setting->smtp_password ?? '') }}" class="form-control-custom w-100" style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                    @error('smtp_password') <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-4 g-4">
                <div class="col-md-4">
                    <label class="form-label-custom" style="font-weight: 600;">Encryption</label>
                    <select name="smtp_encryption" class="form-control-custom w-100" style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                        <option value="" style="background: #0b1020; color: #f8fafc;">None</option>
                        <option value="tls" {{ (old('smtp_encryption', $setting->smtp_encryption ?? '') == 'tls') ? 'selected' : '' }} style="background: #0b1020; color: #f8fafc;">TLS</option>
                        <option value="ssl" {{ (old('smtp_encryption', $setting->smtp_encryption ?? '') == 'ssl') ? 'selected' : '' }} style="background: #0b1020; color: #f8fafc;">SSL</option>
                    </select>
                    @error('smtp_encryption') <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label-custom" style="font-weight: 600;">From Email</label>
                    <input type="email" name="from_email" value="{{ old('from_email', $setting->from_email ?? '') }}" class="form-control-custom w-100" style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                    @error('from_email') <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label-custom" style="font-weight: 600;">From Name</label>
                    <input type="text" name="from_name" value="{{ old('from_name', $setting->from_name ?? '') }}" class="form-control-custom w-100" style="background: rgba(11, 16, 32, 0.8); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.2); padding: 8px 12px; border-radius: 6px;">
                    @error('from_name') <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-5 text-end border-top pt-4" style="border-color: rgba(82, 234, 210, 0.1) !important;">
                <button type="submit" class="btn btn-primary px-4 py-2">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
