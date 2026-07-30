@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>Packages Management</h2>
            </div>
            <div>
                <a href="{{ route('admin.packages.create') }}" class="btn btn-primary rounded-pill px-4" style="font-weight: 800 !important;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Package
                </a>
            </div>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Order</th>
                        <th>Eyebrow</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $pkg)
                        <tr>
                            <td>
                                <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 6px; font-weight: bold;">{{ $pkg->order }}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.85rem; color: #64748b; text-transform: uppercase; font-weight: 700;">{{ $pkg->eyebrow ?? 'N/A' }}</span>
                            </td>
                            <td>
                                {{ $pkg->name }}
                            </td>
                            <td>
                                <strong style="color: #0f766e;">{{ $pkg->price }}
                                <span style="font-size: 0.8rem; color: #64748b;">{{ $pkg->billing_period }}</span>
                            </td>
                           
                            <td>
                                @if($pkg->is_active)
                                    <span class="status-badge-active">Active</span>
                                @else
                                    <span class="status-badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="icon-button" title="Edit">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" style="display: inline;">
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
                            <td colspan="7" class="text-center py-4" style="color: #64748b; font-style: italic;">No packages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($packages->hasPages())
            <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line);">
                <div class="text-muted small">
                    Showing {{ $packages->firstItem() ?? 0 }} to {{ $packages->lastItem() ?? 0 }} of {{ $packages->total() }} results
                </div>
                <div>
                    {{ $packages->links('vendor.pagination.custom') }}
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        // Delete package via jQuery AJAX
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $form = $button.closest('form');
            var $row = $button.closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the pricing plan permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    var formData = new FormData($form[0]);
                    formData.append('_method', 'DELETE');

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function (data) {
                            if (data.success) {
                                $row.css({
                                    'transition': 'opacity 0.3s ease, transform 0.3s ease',
                                    'opacity': '0',
                                    'transform': 'translateX(20px)'
                                });
                                setTimeout(function () { $row.remove(); }, 300);

                                Swal.fire({
                                    title: 'Deleted!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete package.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
