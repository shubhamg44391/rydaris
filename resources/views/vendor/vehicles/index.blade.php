@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>Vehicle Management</h2>
            </div>
            <div>
                <a href="{{ route('vendor.vehicles.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Vehicle
                </a>
            </div>
        </div>
        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Vehicle Code</th>
                        <th>Vehicle Name</th>
                        <th>Model</th>
                        <th>Group</th>
                        <th>Stock</th>
                        <th>Utilization</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($vehicles->currentPage() - 1) * $vehicles->perPage() + 1;
                    @endphp
                    @forelse ($vehicles as $vehicle)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                <span class="badge" style="background: rgba(82, 234, 210, 0.15); color: var(--brand);">{{ $vehicle->code }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    @if ($vehicle->image)
                                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" style="width: 45px; height: auto; border-radius: 4px; object-fit: cover;">
                                    @else
                                        <div style="width: 45px; height: 30px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; color: #64748b;">No Img</div>
                                    @endif
                                    {{ $vehicle->name }}
                                </div>
                            </td>
                            <td>{{ $vehicle->model ?? 'N/A' }}</td>
                            <td>{{ $vehicle->group->name ?? 'N/A' }}</td>
                            <td>{{ $vehicle->stock }}</td>
                            <td>
                                <span>0%</span>
                            </td>
                            <td>
                                @if($vehicle->status === 'active')
                                    <span class="badge" style="background: #dcfce7; color: #067647; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">Active</span>
                                @else
                                    <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('vendor.vehicles.edit', $vehicle->id) }}" class="icon-button" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0f766e; background: #ffffff;">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('vendor.vehicles.destroy', $vehicle->id) }}" method="POST" style="display: inline;">
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
                            <td colspan="9" class="text-center py-4" style="text-align: center; padding: 20px;">No vehicles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Controls -->
        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid #d7e0e8; display: flex; justify-content: space-between; align-items: center; padding: 16px 24px;">
            <div class="text-muted small">
                Showing {{ $vehicles->firstItem() ?? 0 }} to {{ $vehicles->lastItem() ?? 0 }} of {{ $vehicles->total() }} results
            </div>
            <div>
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the vehicle record. You won't be able to revert this!",
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
