@extends('admin.layouts.app')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Vendors</h4>

        <!-- Vendors Table -->
        <div class="card">
            <h5 class="card-header">All Registered Vendors</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>First Name</th>
                            <th>Email</th>
                            <th>Country Code</th>
                            <th>Contact Number</th>
                            <th>Registered Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $startingNumber = ($vendors->currentPage() - 1) * $vendors->perPage() + 1;
                        @endphp
                        @forelse ($vendors as $vendor)
                            <tr>
                                <td>{{ $startingNumber++ }}</td>
                                <td>
                                    <strong>{{ $vendor->first_name ?? $vendor->name }}</strong>
                                </td>
                                <td>{{ $vendor->email }}</td>
                                <td>
                                    <span class="badge bg-label-info">{{ $vendor->country_code ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $vendor->contact_number ?? 'N/A' }}</td>
                                <td>{{ $vendor->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.vendors.toggle-status', $vendor->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @if($vendor->status === 'active')
                                            <button type="button" class="btn btn-xs border-0 bg-transparent p-0 status-toggle-btn" title="Click to Deactivate">
                                                <span class="badge bg-label-success" style="cursor: pointer;">Active</span>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-xs border-0 bg-transparent p-0 status-toggle-btn" title="Click to Activate">
                                                <span class="badge bg-label-secondary" style="cursor: pointer;">Inactive</span>
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger delete-btn" title="Delete">
                                                <i class="bx bx-trash"></i>
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
            <div class="d-flex justify-content-between align-items-center px-4 py-3">
                <div class="text-muted small">
                    Showing {{ $vendors->firstItem() ?? 0 }} to {{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }} results
                </div>
                <div>
                    {{ $vendors->links() }}
                </div>
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
