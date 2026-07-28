@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>Inquiries Management</h2>
            </div>
        </div>

        
        <div class="panel-filter-bar">
            <a href="{{ route('admin.contact-inquiries.index') }}" class="btn btn-sm {{ !$status ? 'active' : '' }}">
                All
                <span>{{ $totalCount }}</span>
            </a>
            <a href="{{ route('admin.contact-inquiries.index', ['status' => 'unread']) }}" class="btn btn-sm {{ $status === 'unread' ? 'active' : '' }}">
                Unread
                <span>{{ $unreadCount }}</span>
            </a>
            <a href="{{ route('admin.contact-inquiries.index', ['status' => 'read']) }}" class="btn btn-sm {{ $status === 'read' ? 'active' : '' }}">
                Read
                <span>{{ $readCount }}</span>
            </a>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Fleet Size</th>
                        <th>Primary Need</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($inquiries->currentPage() - 1) * $inquiries->perPage() + 1;
                    @endphp
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                {{ $inquiry->name }}
                                <span style="font-size: 0.8rem; color: #64748b; display: block;">{{ $inquiry->company }}</span>
                            </td>
                            <td>
                                <a href="mailto:{{ $inquiry->email }}" style="color: #0f766e; text-decoration: none;">{{ $inquiry->email }}</a>
                            </td>
                            <td>
                                <span style="font-size: 0.9rem; color: #475569;">{{ $inquiry->fleet_size }}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.9rem; color: #475569;">{{ $inquiry->need }}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.85rem; color: #64748b;">{{ $inquiry->created_at->format('M d, Y H:i') }}</span>
                            </td>
                            <td>
                                
                                <form action="{{ route('admin.contact-inquiries.toggle-status', $inquiry->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                     @if($inquiry->status === 'unread')
                                        <button type="submit" title="Mark as Read" class="status-badge-active">Unread</button>
                                    @else
                                        <button type="submit" title="Mark as Unread" class="status-badge-inactive">Read</button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    
                                    <button type="button" class="icon-button" title="View Inquiry Details" style="cursor: pointer; background: transparent; border: none;" onclick="openInquiryModal({{ json_encode([
                                        'id' => $inquiry->id,
                                        'title' => 'Contact Inquiry Details',
                                        'name' => $inquiry->name,
                                        'company' => $inquiry->company ?? 'N/A',
                                        'email' => $inquiry->email,
                                        'phone' => $inquiry->phone ?? 'N/A',
                                        'date' => $inquiry->created_at->format('n/j/Y'),
                                        'description' => $inquiry->message ?? 'No description provided.',
                                        'status' => $inquiry->status,
                                        'toggle_url' => route('admin.contact-inquiries.toggle-status', $inquiry->id)
                                    ]) }})">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>

                                    <a href="mailto:{{ $inquiry->email }}?subject=Re: Rydaris Inquiry" title="Reply via Email" class="icon-button">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.contact-inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4" style="color: #64748b; font-style: italic;">No inquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line);">
                <div class="text-muted small">
                    Showing {{ $inquiries->firstItem() ?? 0 }} to {{ $inquiries->lastItem() ?? 0 }} of {{ $inquiries->total() }} results
                </div>
                <div>
                    {{ $inquiries->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Contact Inquiry Details Modal -->
    <div id="inquiryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(5, 7, 17, 0.75); backdrop-filter: blur(6px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
        <div class="inquiry-modal-card" style="width: 100%; max-width: 560px; background: #0b1020; border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 14px; box-shadow: 0 20px 50px rgba(0,0,0,0.6); overflow: hidden; display: flex; flex-direction: column;">
            
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <h3 id="modalTitle" style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #f8fafc;">Contact Inquiry Details</h3>
                <button onclick="closeInquiryModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.2rem; cursor: pointer; padding: 4px 8px; line-height: 1; border-radius: 6px;">&times;</button>
            </div>

            <!-- Body -->
            <div style="padding: 24px; display: flex; flex-direction: column; gap: 18px;">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Name</span>
                        <strong id="modalName" style="font-size: 0.95rem; color: #ffffff; font-weight: 700;">-</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Company</span>
                        <span id="modalCompany" style="font-size: 0.92rem; color: #e2e8f0; font-weight: 600;">-</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Email</span>
                        <a id="modalEmail" href="#" style="font-size: 0.92rem; color: #f8fafc; background: transparent !important; padding: 0 !important; border: none !important; box-shadow: none !important; text-decoration: none; font-weight: 700; word-break: break-all; display: inline-block;">-</a>
                    </div>
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Contact</span>
                        <span id="modalPhone" style="font-size: 0.92rem; color: #ffffff; font-weight: 700;">-</span>
                    </div>
                </div>

                <div>
                    <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Date Submitted</span>
                    <span id="modalDate" style="font-size: 0.92rem; color: #e2e8f0; font-weight: 600;">-</span>
                </div>

                <div>
                    <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Description</span>
                    <div id="modalDescription" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 14px 16px; font-size: 0.9rem; color: #e2e8f0; line-height: 1.6; min-height: 80px; white-space: pre-wrap;">-</div>
                </div>

            </div>

            <!-- Footer -->
            <div style="display: flex; justify-content: flex-end; padding: 16px 24px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                <button onclick="closeInquiryModal()" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 8px 24px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Close</button>
            </div>

        </div>
    </div>

    <style>
    /* Light mode modal overrides */
    body.light-mode .inquiry-modal-card {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15) !important;
    }
    body.light-mode #modalTitle,
    body.light-mode #modalName,
    body.light-mode #modalPhone {
        color: #0f172a !important;
    }
    body.light-mode #modalCompany,
    body.light-mode #modalDate {
        color: #334155 !important;
    }
    body.light-mode #modalEmail {
        color: #0d9488 !important;
    }
    body.light-mode #modalDescription {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        color: #1e293b !important;
    }
    body.light-mode .inquiry-modal-card button {
        background: #f1f5f9 !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
    }
    </style>
@endsection

@section('js')
<script>
    function openInquiryModal(data) {
        document.getElementById('modalTitle').innerText = data.title || 'Inquiry Details';
        document.getElementById('modalName').innerText = data.name || '-';
        document.getElementById('modalCompany').innerText = data.company || 'N/A';
        document.getElementById('modalEmail').innerText = data.email || '-';
        document.getElementById('modalEmail').href = 'mailto:' + data.email;
        document.getElementById('modalPhone').innerText = data.phone || 'N/A';
        document.getElementById('modalDate').innerText = data.date || '-';
        document.getElementById('modalDescription').innerText = data.description || '-';

        var modal = document.getElementById('inquiryModal');
        modal.style.display = 'flex';

        if (data.status === 'unread' && data.toggle_url) {
            fetch(data.toggle_url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                // optional refresh indicator
            }).catch(err => console.log(err));
        }
    }

    function closeInquiryModal() {
        document.getElementById('inquiryModal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('inquiryModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeInquiryModal();
            }
        });

        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
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

        // Success session alert
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endsection
