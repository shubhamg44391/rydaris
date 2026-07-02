@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>Pricing Periods</h2>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('addPeriodForm').style.display='block'" style="display: inline-flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Period
                </button>
            </div>
        </div>

        <div id="addPeriodForm" style="display: none; padding: 20px; border-bottom: 1px solid #d7e0e8; background: #f8fafc;">
            <form action="{{ route('vendor.availability.period-store') }}" method="POST">
                @csrf
                <div class="row" style="display: flex; gap: 15px; align-items: flex-end;">
                    <div class="col-md-3">
                        <label style="font-size: 0.85rem; font-weight: bold; color: #64748b;">Min Day</label>
                        <input type="number" name="min_day" class="form-control" required min="1" placeholder="e.g. 1" style="padding: 10px; border: 1px solid #d7e0e8; border-radius: 4px;">
                    </div>
                    <div class="col-md-3">
                        <label style="font-size: 0.85rem; font-weight: bold; color: #64748b;">Max Day</label>
                        <input type="number" name="max_day" class="form-control" required min="1" placeholder="e.g. 3" style="padding: 10px; border: 1px solid #d7e0e8; border-radius: 4px;">
                    </div>
                    <div class="col-md-4">
                        <label style="font-size: 0.85rem; font-weight: bold; color: #64748b;">Label (Optional)</label>
                        <input type="text" name="label" class="form-control" placeholder="e.g. 1-3 Days" style="padding: 10px; border: 1px solid #d7e0e8; border-radius: 4px;">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Save</button>
                        <button type="button" class="btn" style="padding: 10px 20px; background: #e2e8f0; color: #475569;" onclick="document.getElementById('addPeriodForm').style.display='none'">Cancel</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Day Range</th>
                        <th>Label</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periods as $period)
                        <tr>
                            <td>{{ $period->id }}</td>
                            <td><strong>{{ $period->min_day }} - {{ $period->max_day }} Days</strong></td>
                            <td><span class="badge" style="background: #e0e7ff; color: #3730a3;">{{ $period->label }}</span></td>
                            <td>
                                <form action="{{ route('vendor.availability.period-destroy', $period->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="icon-button delete-btn" title="Delete" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border:1px solid #fee2e2;border-radius:var(--radius);color:#ef4444;background:#fff;cursor:pointer;padding:0;">
                                        <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;">
                                            <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px; color: #64748b;">No rental periods defined yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
                title: 'Delete Period?',
                text: "Are you sure you want to delete this rental period?",
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
