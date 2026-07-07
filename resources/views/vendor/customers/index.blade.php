@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>
                    My Customers
                </h2>
            </div>
        </div>

        <!-- Filter Tab Buttons -->
        <div class="panel-filter-bar">
            <a href="#" class="btn btn-sm active">
                All Customers
            </a>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country Code</th>
                        <th>Contact Number</th>
                        <th>Registered Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($customers->currentPage() - 1) * $customers->perPage() + 1;
                    @endphp
                    @forelse ($customers as $customer)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                {{ $customer->first_name ?? $customer->name }}
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>
                                {{ $customer->country_code ?? 'N/A' }}
                            </td>
                            <td>{{ $customer->contact_number ?? 'N/A' }}</td>
                            <td>{{ $customer->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <button type="button" class="icon-button view-btn" title="View Details" data-customer="{{ json_encode($customer) }}" onclick="openViewModal(this)">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Controls -->
        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line);">
            <div class="text-muted small">
                Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} entries
            </div>
            <div>
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="custom-modal">
        <div class="modal-content" style="max-width: 500px; padding: 25px; border-radius: 12px; background: rgba(11, 16, 32, 0.95); border: 1px solid rgba(82, 234, 210, 0.2); box-shadow: 0 24px 80px rgba(0,0,0,0.6); width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #f8fafc;">Customer Details</h3>
                <span onclick="closeViewModal()" style="color: #94a3b8; font-size: 24px; cursor: pointer;">&times;</span>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px; color: #cbd5e1; font-size: 0.95rem;">
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Name</strong>
                    <span id="modalName"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Email</strong>
                    <a id="modalEmail" href="#" style="color: #0f766e; text-decoration: none;"></a>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Contact</strong>
                    <span id="modalContact"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Account Status</strong>
                    <span id="modalStatus" style="text-transform: capitalize;"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Registered Date</strong>
                    <span id="modalDate"></span>
                </div>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn btn-sm" onclick="closeViewModal()" style="background: rgba(255,255,255,0.1); color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Close</button>
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
    function openViewModal(button) {
        const data = JSON.parse(button.getAttribute('data-customer'));
        
        document.getElementById('modalName').textContent = data.first_name || data.name;
        document.getElementById('modalEmail').textContent = data.email;
        document.getElementById('modalEmail').href = 'mailto:' + data.email;
        document.getElementById('modalContact').textContent = (data.country_code ? data.country_code + ' ' : '') + (data.contact_number || 'N/A');
        document.getElementById('modalStatus').textContent = data.status || 'Active';
        document.getElementById('modalDate').textContent = new Date(data.created_at).toLocaleString();
        
        document.getElementById('viewModal').style.display = 'flex';
    }

    function closeViewModal() {
        document.getElementById('viewModal').style.display = 'none';
    }

    // Close on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('viewModal');
        if (event.target == modal) {
            closeViewModal();
        }
    }

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
