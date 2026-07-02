@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>
                    Vendor Management
                    @if(isset($status) && $status === 'active')
                        - Active
                    @elseif(isset($status) && $status === 'inactive')
                        - Inactive
                    @endif
                </h2>
            </div>
        </div>

        <!-- Filter Tab Buttons -->
        <div class="px-4 py-2" style="border-bottom: 1px solid #d7e0e8; display: flex; gap: 10px; background: #f8fafc;">
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-sm" style="border-radius: var(--radius); padding: 6px 12px; font-weight: bold; border: 1px solid #d7e0e8; {{ !($status ?? null) ? 'background: #061218; color: #ffffff;' : 'background: #ffffff; color: #64748b;' }}">
                All Vendors
            </a>
            <a href="{{ route('admin.vendors.index', ['status' => 'active']) }}" class="btn btn-sm" style="border-radius: var(--radius); padding: 6px 12px; font-weight: bold; border: 1px solid #d7e0e8; {{ ($status ?? null) === 'active' ? 'background: #061218; color: #ffffff;' : 'background: #ffffff; color: #64748b;' }}">
                Active
            </a>
            <a href="{{ route('admin.vendors.index', ['status' => 'inactive']) }}" class="btn btn-sm" style="border-radius: var(--radius); padding: 6px 12px; font-weight: bold; border: 1px solid #d7e0e8; {{ ($status ?? null) === 'inactive' ? 'background: #061218; color: #ffffff;' : 'background: #ffffff; color: #64748b;' }}">
                Inactive
            </a>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>First Name</th>
                        <th>Email</th>
                        <th>Country Codes</th>
                        <th>Contact Number</th>
                        <th>Registered Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($vendors->currentPage() - 1) * $vendors->perPage() + 1;
                    @endphp
                    @forelse ($vendors as $vendor)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                {{ $vendor->first_name ?? $vendor->name }}
                            </td>
                            <td>{{ $vendor->email }}</td>
                            <td>
                                {{ $vendor->country_code ?? 'N/A' }}
                            </td>
                            <td>{{ $vendor->contact_number ?? 'N/A' }}</td>
                            <td>{{ $vendor->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.vendors.toggle-status', $vendor->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @if($vendor->status === 'active')
                                        <button type="button" class="btn btn-xs border-0 bg-transparent p-0 status-toggle-btn" title="Click to Deactivate" style="border: none; background: transparent; padding: 0;">
                                            <span class="badge" style="background: #dcfce7; color: #067647; cursor: pointer; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">Active</span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-xs border-0 bg-transparent p-0 status-toggle-btn" title="Click to Activate" style="border: none; background: transparent; padding: 0;">
                                            <span class="badge" style="background: #f1f5f9; color: #64748b; cursor: pointer; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">Inactive</span>
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="icon-button" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0f766e; background: #ffffff;">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #fee2e2; border-radius: var(--radius); color: #ef4444; background: #ffffff; cursor: pointer; padding: 0;">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No vendors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Controls -->
        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid #d7e0e8;">
            <div class="text-muted small">
                Showing {{ $vendors->firstItem() ?? 0 }} to {{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }} results
            </div>
            <div>
                {{ $vendors->appends(['status' => $status])->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Status toggle confirmation
        document.querySelectorAll('.status-toggle-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                const badge = this.querySelector('.badge').textContent.trim();
                const nextStatus = (badge === 'Active') ? 'Inactive' : 'Active';

                Swal.fire({
                    title: 'Change status?',
                    text: `Are you sure you want to set this vendor's status to ${nextStatus}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#696cff',
                    cancelButtonColor: '#8592a3',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the vendor account. You won't be able to revert this!",
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

        // Success session alert using SweetAlert
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
