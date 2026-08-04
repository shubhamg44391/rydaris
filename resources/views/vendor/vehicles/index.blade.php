@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div>
                <h2 style="margin: 0; font-size: 1.35rem; font-weight: 800;">Vehicle Management</h2>
            </div>
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: nowrap;">
             

                <a href="{{ route('vendor.vehicles.create') }}" class="btn" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border-radius: 999px; font-weight: 800 !important; font-size: 0.85rem; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35); text-decoration: none; white-space: nowrap; flex-shrink: 0; transition: all 0.2s;">
                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 3;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Vehicle
                </a>
            </div>
        </div>

        <div id="vehiclesTableContainer">
            @section('vehicles_table_section')
            <div class="panel-body admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">S.No</th>
                            <th style="white-space: nowrap;">Vehicle Code</th>
                            <th style="white-space: nowrap;">Vehicle Name</th>
                            <th style="white-space: nowrap;">Model</th>
                            <th style="white-space: nowrap;">Group</th>
                            <th style="white-space: nowrap;">Stock</th>
                            <th style="white-space: nowrap;">Utilization</th>
                            <th style="white-space: nowrap;">Active</th>
                            <th style="white-space: nowrap; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startingNumber = ($vehicles->currentPage() - 1) * $vehicles->perPage() + 1;
                        @endphp
                        @forelse ($vehicles as $vehicle)
                            <tr id="vehicle-row-{{ $vehicle->id }}">
                                <td>{{ $startingNumber++ }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(82, 234, 210, 0.15); color: var(--brand, #52ead2); font-weight: 700; padding: 4px 8px; border-radius: 6px;">{{ $vehicle->code }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        @if ($vehicle->image)
                                            <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" style="width: 45px; height: auto; border-radius: 4px; object-fit: cover;">
                                        @else
                                            <div style="width: 45px; height: 30px; background: rgba(255,255,255,0.05); border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; color: #64748b;">No Img</div>
                                        @endif
                                        <strong>{{ $vehicle->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $vehicle->model ?? 'N/A' }}</td>
                                <td>{{ $vehicle->group?->name ?? 'N/A' }}</td>
                                <td>{{ $vehicle->stock }}</td>
                                <td>
                                    <span>0%</span>
                                </td>
                                <td>
                                    @if($vehicle->status === 'active')
                                        <span class="badge" style="background: rgba(74, 222, 128, 0.15); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 0.8rem;">Active</span>
                                    @else
                                        <span class="badge" style="background: rgba(148, 163, 184, 0.15); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.3); padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 0.8rem;">Inactive</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div class="table-actions" style="display: inline-flex; gap: 8px; justify-content: flex-end;">
                                        <a href="{{ route('vendor.vehicles.edit', $vehicle->id) }}" class="icon-button" title="Edit Vehicle" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(82,234,210,0.3); border-radius: 4px; color: #52ead2; background: rgba(82,234,210,0.1); text-decoration: none;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                        </a>
                                        <button type="button" class="icon-button ajax-delete-vehicle-btn" title="Delete Vehicle"
                                                data-id="{{ $vehicle->id }}"
                                                data-name="{{ $vehicle->name }}"
                                                style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(239,68,68,0.3); border-radius: 4px; color: #ef4444; background: rgba(239,68,68,0.1); cursor: pointer;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4" style="text-align: center; padding: 24px; color: #94a3b8;">No vehicles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($vehicles->hasPages())
                <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; padding: 16px 24px;">
                    <div class="text-muted small">
                        Showing {{ $vehicles->firstItem() ?? 0 }} to {{ $vehicles->lastItem() ?? 0 }} of {{ $vehicles->total() }} results
                    </div>
                    <div>
                        {{ $vehicles->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
            @endsection
            @yield('vehicles_table_section')
        </div>
    </div>
@endsection

@section('js')
<script>
    var currentVehicleSearchQuery = '';
    var vehicleSearchTimer = null;

    function fetchVehicles(url) {
        url = url || '{{ route("vendor.vehicles.index") }}';
        $('#vehiclesTableContainer').css('opacity', '0.5');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search: currentVehicleSearchQuery
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success && response.html) {
                    $('#vehiclesTableContainer').html(response.html).css('opacity', '1');
                }
            },
            error: function() {
                $('#vehiclesTableContainer').css('opacity', '1');
            }
        });
    }

    $(document).ready(function() {
        // Delete Vehicle button click
        $(document).on('click', '.ajax-delete-vehicle-btn', function() {
            var vehicleId = $(this).data('id');
            var vehicleName = $(this).data('name') || 'this vehicle';
            var $row = $('#vehicle-row-' + vehicleId);

            Swal.fire({
                title: 'Delete Vehicle?',
                text: 'Are you sure you want to delete "' + vehicleName + '"? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("vendor/vehicles") }}/' + vehicleId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        dataType: 'json',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        success: function(response) {
                            if (response.success) {
                                $row.fadeOut(300, function() {
                                    $(this).remove();
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message || 'Vehicle deleted successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete vehicle.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete vehicle.', 'error');
                        }
                    });
                }
            });
        });

        // Search input keyup
        $(document).on('keyup', '#vehicleSearchInput', function() {
            clearTimeout(vehicleSearchTimer);
            currentVehicleSearchQuery = $(this).val();
            vehicleSearchTimer = setTimeout(function() {
                fetchVehicles();
            }, 350);
        });

        // AJAX Pagination click
        $(document).on('click', '#vehiclesTableContainer .pagination a', function(e) {
            e.preventDefault();
            var pageUrl = $(this).attr('href');
            if (pageUrl) {
                fetchVehicles(pageUrl);
            }
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endsection
