@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="margin-bottom: 20px;">
            <h2>Create New Role</h2>
        </div>

        <div class="panel-card" style="padding: 24px;">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label" style="color: #f8fafc; font-weight: 600;">ROLE NAME <span style="color: #fb7185;">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Administrator" value="{{ old('name') }}" required style="background: #050711; border: 1px solid rgba(255,255,255,0.15); color: #ffffff;">
                    @error('name')
                        <div class="text-danger" style="color: #fb7185; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <label class="form-label" style="color: #f8fafc; font-weight: 600; margin-bottom: 0;">ASSIGN PERMISSIONS</label>
                        <label style="color: #aab7cb; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" id="selectAllPermissions" style="width: 16px; height: 16px; accent-color: #52ead2;">
                            SELECT ALL
                        </label>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                    <th style="padding: 12px; text-align: left; color: #aab7cb; font-size: 0.85rem;">MODULE NAME</th>
                                    <th style="padding: 12px; text-align: center; color: #aab7cb; font-size: 0.85rem;">LIST</th>
                                    <th style="padding: 12px; text-align: center; color: #aab7cb; font-size: 0.85rem;">ADD</th>
                                    <th style="padding: 12px; text-align: center; color: #aab7cb; font-size: 0.85rem;">EDIT</th>
                                    <th style="padding: 12px; text-align: center; color: #aab7cb; font-size: 0.85rem;">DELETE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentUser = Auth::user();
                                    $disabledPermissions = [
                                        'dashboard' => ['add', 'edit', 'delete'],
                                        'vendors' => ['add'],
                                        'reviews' => ['add', 'edit'],
                                        'inquiries' => ['add'],
                                        'custom_packages' => ['add'],
                                        'seo' => ['add', 'delete'],
                                        'settings' => ['add', 'delete'],
                                        'terms' => ['add', 'delete'],
                                    ];
                                @endphp
                                @foreach($modules as $key => $label)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: 12px; color: #ffffff; font-weight: 500;">{{ $label }}</td>
                                    @foreach(['list', 'add', 'edit', 'delete'] as $action)
                                        @php
                                            $hasPerm = $currentUser->hasAdminPermission($key, $action);
                                        @endphp
                                        <td style="padding: 12px; text-align: center;">
                                            @if(isset($disabledPermissions[$key]) && in_array($action, $disabledPermissions[$key]))
                                                <input type="checkbox" disabled style="width: 18px; height: 18px; accent-color: #52ead2; opacity: 0.3; cursor: not-allowed;">
                                            @else
                                                <input type="checkbox" name="permissions[{{ $key }}][{{ $action }}]" value="1" class="perm-checkbox"
                                                    {!! !$hasPerm ? 'onclick="return false;" tabindex="-1"' : '' !!}
                                                    style="width: 18px; height: 18px; accent-color: #52ead2; {!! !$hasPerm ? 'opacity: 0.3; cursor: not-allowed;' : 'cursor: pointer;' !!}">
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <a href="{{ route('admin.roles.index') }}" class="btn" style="background: rgba(255,255,255,0.1); color: #ffffff; padding: 10px 24px; font-weight: 700; border-radius: 6px; text-decoration: none;">Cancel</a>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; padding: 10px 24px; font-weight: 700; border: none; border-radius: 6px; cursor: pointer;">Save Role</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('selectAllPermissions').addEventListener('change', function() {
        const isChecked = this.checked;
        const checkboxes = document.querySelectorAll('.perm-checkbox:not([onclick="return false;"])');
        checkboxes.forEach(cb => cb.checked = isChecked);
    });
</script>
@endpush
