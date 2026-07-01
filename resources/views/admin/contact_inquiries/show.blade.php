@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 1.4rem; color: #111827; margin: 0;">Inquiry Details</h2>
            </div>
            <div>
                <a href="{{ route('admin.contact-inquiries.index') }}" class="admin-action" style="text-decoration: none;">
                    &larr; Back to Inquiries
                </a>
            </div>
        </div>

        <div class="panel-body" style="padding: 24px;">
            <div style="background: #f8fafc; border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 24px; margin-bottom: 24px;">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 20px;">
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Full Name</span>
                        <strong style="font-size: 1.15rem; color: #0f172a;">{{ $inquiry->name }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Company Name</span>
                        <span style="font-size: 1.1rem; color: #475569; font-weight: 600;">{{ $inquiry->company }}</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 20px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Email Address</span>
                        <a href="mailto:{{ $inquiry->email }}" style="font-size: 1rem; color: #0f766e; text-decoration: none; font-weight: bold;">{{ $inquiry->email }}</a>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Phone Number</span>
                        <span style="font-size: 1rem; color: #0f172a; font-weight: bold;">{{ $inquiry->phone }}</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 20px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Fleet Size</span>
                        <span style="font-size: 1rem; color: #475569; font-weight: 600;">{{ $inquiry->fleet_size }}</span>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Primary Need</span>
                        <span style="font-size: 1rem; color: #475569; font-weight: 600;">{{ $inquiry->need }}</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Date Received</span>
                        <span style="font-size: 0.95rem; color: #475569; font-weight: 600;">{{ $inquiry->created_at->format('M d, Y H:i A') }}</span>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Status</span>
                        <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.75rem; text-transform: uppercase;">{{ $inquiry->status }}</span>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; letter-spacing: 0.05em; display: block; margin-bottom: 8px;">Message / Needs Description</span>
                <div style="background: #ffffff; border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 20px; font-size: 1rem; color: #334155; line-height: 1.6; min-height: 120px; white-space: pre-wrap;">{{ $inquiry->message }}</div>
            </div>

            <div style="display: flex; gap: 16px; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 24px;">
                <a href="mailto:{{ $inquiry->email }}?subject=Re: Rydaris Inquiry" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: var(--brand, #52ead2); border: none; color: #061218; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; padding: 0 20px;">
                    Reply via Email
                </a>
                <form action="{{ route('admin.contact-inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger delete-btn" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: #ffffff; border: 1px solid #fecaca; color: #ef4444; border-radius: 9999px; cursor: pointer; padding: 0 20px; display: inline-flex; align-items: center; justify-content: center; gap: 5px;">
                        Delete Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelector('.delete-btn').addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the contact inquiry permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
