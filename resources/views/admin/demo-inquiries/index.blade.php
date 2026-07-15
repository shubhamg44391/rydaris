@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>Demo Inquiries</h2>
            </div>
        </div>

        <div class="panel-filter-bar">
            <a href="{{ route('admin.demo-inquiries.index') }}" class="btn btn-sm {{ !$status ? 'active' : '' }}">
                All <span>{{ $totalCount }}</span>
            </a>
            <a href="{{ route('admin.demo-inquiries.index', ['status' => 'unread']) }}" class="btn btn-sm {{ $status === 'unread' ? 'active' : '' }}">
                Unread <span>{{ $unreadCount }}</span>
            </a>
            <a href="{{ route('admin.demo-inquiries.index', ['status' => 'read']) }}" class="btn btn-sm {{ $status === 'read' ? 'active' : '' }}">
                Read <span>{{ $readCount }}</span>
            </a>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $startingNumber = ($inquiries->currentPage() - 1) * $inquiries->perPage() + 1; @endphp
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                {{ $inquiry->name }}
                                <span style="font-size: 0.8rem; color: #64748b; display: block;">{{ $inquiry->company_name }}</span>
                            </td>
                            <td>
                                <a href="mailto:{{ $inquiry->email }}" style="color: #0f766e; text-decoration: none;">{{ $inquiry->email }}</a>
                            </td>
                            <td>
                                <span style="font-size: 0.9rem; color: #475569;">{{ $inquiry->country_code }} {{ $inquiry->contact_details }}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.8rem; color: #64748b; display: inline-block; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $inquiry->description }}">
                                    {{ Str::limit($inquiry->description, 30) }}
                                </span>
                            </td>
                            <td>
                                <span style="font-size: 0.85rem; color: #64748b;">{{ $inquiry->created_at->format('M d, Y') }}</span>
                            </td>
                            <td>
                                <form action="{{ route('admin.demo-inquiries.toggle-status', $inquiry->id) }}" method="POST" style="display: inline;">
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
                                    <button type="button" class="icon-button view-btn" title="View Details" data-inquiry="{{ json_encode($inquiry) }}" onclick="openDemoViewModal(this)">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                    <a href="mailto:{{ $inquiry->email }}?subject=Re: Rydaris Site Demo" title="Reply via Email" class="icon-button">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
                                    </a>
                                    <form action="{{ route('admin.demo-inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 2-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4" style="color: #64748b; font-style: italic;">No demo inquiries found.</td>
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
                <div>{{ $inquiries->links() }}</div>
            </div>
        @endif
    </div>

    <div id="demoViewModal" class="custom-modal">
        <div class="modal-content" style="max-width: 650px; padding: 25px; border-radius: 12px; background: rgba(11, 16, 32, 0.95); border: 1px solid rgba(82, 234, 210, 0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #f8fafc;">Demo Inquiry Details</h3>
                <span onclick="closeDemoViewModal()" style="color: #94a3b8; font-size: 24px; cursor: pointer;">&times;</span>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; color: #cbd5e1; font-size: 0.95rem;">
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Name</strong><span id="demoModalName"></span></div>
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Company</strong><span id="demoModalCompany"></span></div>
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Email</strong><span id="demoModalEmail"></span></div>
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Contact</strong><span id="demoModalContact"></span></div>
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Date Submitted</strong><span id="demoModalDate"></span></div>
                <div style="grid-column: span 2;">
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Description</strong>
                    <div id="demoModalDescription" style="background: rgba(255,255,255,0.05); padding: 12px; border-radius: 8px; white-space: pre-wrap;"></div>
                </div>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn btn-sm" onclick="closeDemoViewModal()" style="background: rgba(255,255,255,0.1); color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>

    <style>
        .custom-modal {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(5, 7, 17, 0.85);
            z-index: 9999;
            align-items: center; justify-content: center;
            backdrop-filter: blur(8px);
        }
    </style>
@endsection

@section('js')
<script>
    function openDemoViewModal(button) {
        const data = JSON.parse(button.getAttribute('data-inquiry'));
        document.getElementById('demoModalName').textContent = data.name;
        document.getElementById('demoModalCompany').textContent = data.company_name;
        document.getElementById('demoModalEmail').textContent = data.email;
        document.getElementById('demoModalContact').textContent = (data.country_code ? data.country_code + ' ' : '') + data.contact_details;
        document.getElementById('demoModalDate').textContent = new Date(data.created_at).toLocaleDateString();
        document.getElementById('demoModalDescription').textContent = data.description || 'No description provided.';
        document.getElementById('demoViewModal').style.display = 'flex';
    }
    function closeDemoViewModal() {
        document.getElementById('demoViewModal').style.display = 'none';
    }
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('demoViewModal');
        if (event.target === modal) closeDemoViewModal();
    });
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will delete the demo inquiry permanently.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff3e1d',
                    cancelButtonColor: '#8592a3',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
        @if(session('success'))
            Swal.fire({ title: 'Success!', text: "{{ session('success') }}", icon: 'success', timer: 3000, showConfirmButton: false });
        @endif
    });
</script>
@endsection
