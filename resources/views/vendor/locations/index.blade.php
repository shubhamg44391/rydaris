@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center"
             style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>Pickup Location Management</h2>
            </div>
            <div>
                <a href="{{ route('vendor.locations.create') }}" class="btn btn-primary"
                   style="display: inline-flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Add Location
                </a>
            </div>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Type</th>
                        <th>Pickup Location</th>
                        <th>Location Price</th>
                        <th>Map Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($locations->currentPage() - 1) * $locations->perPage() + 1;
                    @endphp
                    @forelse ($locations as $loc)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>{{ $loc->type }}</td>
                            <td>
                                {{ $loc->location }}
                            </td>
                            <td>
                               
                                    {{ number_format($loc->price, 2) }}
                            </td>
                            <td>
                                @if($loc->map_type === 'coordinates')
                                    Coordinates
                                @else
                                    Embedded Map
                                @endif
                            </td>
                            <td>
                                <div class="table-actions" style="display:flex;gap:8px;">
                                    <a href="{{ route('vendor.locations.edit', $loc->id) }}"
                                       class="icon-button" title="Edit"
                                       style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border:1px solid #d7e0e8;border-radius:var(--radius);color:#0f766e;background:#fff;">
                                        <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;">
                                            <path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('vendor.locations.destroy', $loc->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete"
                                                style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border:1px solid #fee2e2;border-radius:var(--radius);color:#ef4444;background:#fff;cursor:pointer;padding:0;">
                                            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;">
                                                <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:32px;color:#94a3b8;">
                                <svg viewBox="0 0 24 24" style="width:40px;height:40px;fill:none;stroke:#cbd5e1;stroke-width:1.5;display:block;margin:0 auto 10px;">
                                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                                No pickup locations found. <a href="{{ route('vendor.locations.create') }}">Add your first location</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
        <div style="border-top:1px solid #d7e0e8;display:flex;justify-content:space-between;align-items:center;padding:16px 24px;">
            <div class="text-muted small">
                Showing {{ $locations->firstItem() ?? 0 }} to {{ $locations->lastItem() ?? 0 }}
                of {{ $locations->total() }} results
            </div>
            <div>{{ $locations->links() }}</div>
        </div>
    </div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Delete Location?',
                text: "This will permanently remove the pickup location.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

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
