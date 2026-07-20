@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="margin-bottom: 25px;">
            <div>
                <h2 class="panel-title" style="margin: 0;">Edit User Invitation</h2>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px; margin-bottom: 0;">Update invitation details. If the email is modified, a new email will automatically be sent to the new address.</p>
            </div>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('vendor.invitations.update', $invitation->id) }}">
                @csrf
                @method('PUT')

                
                <div class="mb-4">
                    <label for="name" class="form-label-custom">Invited Person's Name (Optional)</label>
                    <input type="text" class="form-control form-input-custom @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $invitation->name) }}" placeholder="Enter full name (e.g. John Doe)" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <input type="email" class="form-control form-input-custom @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email', $invitation->email) }}" required placeholder="Enter email address (e.g. john@example.com)" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="background: rgba(251, 191, 36, 0.05); border: 1px solid rgba(251, 191, 36, 0.15); border-radius: 8px; padding: 15px; margin-bottom: 25px; display: flex; gap: 12px; align-items: flex-start;">
                    <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; color: #fbbf24; fill: none; stroke: currentColor; stroke-width: 2; flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span style="color: #cbd5e1; font-size: 0.85rem; line-height: 1.5;">
                        <strong>Note:</strong> Modifying the email address will invalidate the previous invitation link and automatically send a new registration link to the updated email address.
                    </span>
                </div>

                <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 action-btn" style="background: linear-gradient(135deg, var(--brand, #52ead2), #ffffff) !important; color: #051013 !important; font-weight: 800; border: none; padding: 10px 24px; border-radius: 20px; cursor: pointer; transition: all 0.2s;">
                        Update & Resend Link
                    </button>
                    <a href="{{ route('vendor.invitations.index') }}" class="btn btn-link text-muted cancel-link" style="color: #94a3b8; text-decoration: none; font-size: 0.95rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
