@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="margin-bottom: 20px;">
            <h2>Create Admin User</h2>
        </div>

        <div class="panel-card" style="padding: 24px;">
            <form action="{{ route('admin.admin-users.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label" style="color: #f8fafc; font-weight: 600;">NAME <span style="color: #fb7185;">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" value="{{ old('name') }}" required style="background: #050711; border: 1px solid rgba(255,255,255,0.15); color: #ffffff;">
                    @error('name')
                        <div class="text-danger" style="color: #fb7185; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" style="color: #f8fafc; font-weight: 600;">EMAIL <span style="color: #fb7185;">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="e.g. admin@example.com" value="{{ old('email') }}" required style="background: #050711; border: 1px solid rgba(255,255,255,0.15); color: #ffffff;">
                    @error('email')
                        <div class="text-danger" style="color: #fb7185; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" style="color: #f8fafc; font-weight: 600;">PASSWORD <span style="color: #fb7185;">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required style="background: #050711; border: 1px solid rgba(255,255,255,0.15); color: #ffffff;">
                    @error('password')
                        <div class="text-danger" style="color: #fb7185; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" style="color: #f8fafc; font-weight: 600;">ASSIGN ROLE <span style="color: #fb7185;">*</span></label>
                    <select name="role_id" class="form-control" required style="background: #050711; border: 1px solid rgba(255,255,255,0.15); color: #ffffff; appearance: auto;">
                        <option value="" disabled selected>Select a role...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="text-danger" style="color: #fb7185; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <a href="{{ route('admin.admin-users.index') }}" class="btn" style="background: rgba(255,255,255,0.1); color: #ffffff; padding: 10px 24px; font-weight: 700; border-radius: 6px; text-decoration: none;">Cancel</a>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; padding: 10px 24px; font-weight: 700; border: none; border-radius: 6px; cursor: pointer;">Save & Send Email</button>
                </div>
            </form>
        </div>
    </div>
@endsection
