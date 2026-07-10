@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="margin-bottom: 25px;">
            <div>
                <h2 class="panel-title" style="margin: 0;">Invite New User</h2>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px; margin-bottom: 0;">Send an invitation email to register a user under your vendor account.</p>
            </div>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.invitations.store') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="form-label-custom">Invited Person's Name (Optional)</label>
                    <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name') }}" placeholder="Enter full name (e.g. John Doe)" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <input type="email" class="form-control form-input-custom @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" required placeholder="Enter email address (e.g. john@example.com)" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 action-btn" style="background: linear-gradient(135deg, var(--brand, #52ead2), #ffffff) !important; color: #051013 !important; font-weight: 800; border: none; padding: 10px 24px; border-radius: 20px; cursor: pointer; transition: all 0.2s;">
                        Send Invitation Link
                    </button>
                    <a href="{{ route('vendor.invitations.index') }}" class="btn btn-link text-muted cancel-link" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
