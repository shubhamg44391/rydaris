@extends('admin.layouts.app')

@section('title', $seo_title ?? 'Insurance Management')

@section('main-content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div>
                <h2>Insurance Management</h2>
            </div>
            <div>
                <a href="{{ route('vendor.insurance.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border-radius: 999px; font-weight: 800 !important; font-size: 0.85rem; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35); white-space: nowrap; flex-shrink: 0; transition: all 0.2s; text-decoration: none;">
                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 3;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add New Insurance
                </a>
            </div>
        </div>
        
        <div id="insuranceTableContainer">
            @section('insurance_table_section')
            <div class="panel-body admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $startingNumber = 1; @endphp
                        @forelse ($insurances as $ins)
                            <tr>
                                <td>{{ $startingNumber++ }}</td>
                                <td>
                                    <div style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--brand, #52ead2);">
                                        <i class="{{ $ins->icon_class ?: 'fas fa-shield-alt' }}"></i>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $ins->name }}</strong>
                                </td>
                                <td>${{ number_format($ins->price, 2) }}</td>
                                <td title="{{ $ins->description }}" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $ins->description ?: '—' }}
                                </td>
                                <td>
                                    @if($ins->status)
                                        <span class="badge" style="background: #dcfce7; color: #067647; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem; cursor: pointer;" onclick="toggleInsuranceStatus({{ $ins->id }}, this)">Active</span>
                                    @else
                                        <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem; cursor: pointer;" onclick="toggleInsuranceStatus({{ $ins->id }}, this)">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $ins->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="table-actions" style="display: flex; gap: 8px;">
                                        <button type="button" class="icon-button" title="View" onclick="xpView('{{ addslashes($ins->name) }}','{{ $ins->icon_class }}','{{ $ins->price }}','{{ addslashes($ins->description) }}')" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #3b82f6; background: #ffffff; cursor: pointer;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <a href="{{ route('vendor.insurance.edit', $ins->id) }}" class="icon-button" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0f766e; background: #ffffff; text-decoration: none;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                        </a>
                                        <button type="button" class="icon-button delete-btn" title="Delete" onclick="deleteInsurance({{ $ins->id }})" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #fee2e2; border-radius: var(--radius); color: #ef4444; background: #ffffff; cursor: pointer; padding: 0;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4" style="text-align: center; padding: 20px;">No insurance packages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @show
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function fetchInsurance() {
        $('#insuranceTableContainer').css('opacity', '0.5');
        $.ajax({
            url: '{{ route("vendor.insurance.index") }}',
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.status === 'success' && response.html) {
                    $('#insuranceTableContainer').html(response.html).css('opacity', '1');
                }
            },
            error: function() {
                $('#insuranceTableContainer').css('opacity', '1');
            }
        });
    }

    function toggleInsuranceStatus(id, el) {
        $.ajax({
            url: `/vendor/extras/${id}/toggle`,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(d) {
                if (d.status === 'success') {
                    el.style.background = d.new_status ? '#dcfce7' : '#f1f5f9';
                    el.style.color = d.new_status ? '#067647' : '#64748b';
                    el.textContent = d.new_status ? 'Active' : 'Inactive';
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated',
                        text: 'Status changed to ' + (d.new_status ? 'Active' : 'Inactive'),
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            }
        });
    }

    function deleteInsurance(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the insurance package. You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('vendor/extras') }}/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    dataType: 'json',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Insurance deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            fetchInsurance();
                        } else {
                            Swal.fire('Error', response.message || 'Failed to delete insurance.', 'error');
                        }
                    }
                });
            }
        });
    }

    function xpView(name, icon, price, desc) {
        Swal.fire({
            title: name,
            html: `
                <div style="text-align: left; padding-top: 10px;">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
                        <div style="width:50px;height:50px;border-radius:10px;background:rgba(82, 234, 210, 0.1);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--brand, #52ead2);flex-shrink:0;">
                            <i class="${icon||'fas fa-shield-alt'}"></i>
                        </div>
                        <div>
                            <div style="color:#94a3b8;font-size:0.83rem;">Insurance Package</div>
                        </div>
                    </div>
                    <div style="margin-bottom: 15px;"><strong>Price:</strong> $${price}</div>
                    ${desc ? `<div><strong>Description:</strong><br/>${desc}</div>` : ''}
                </div>
            `,
            showCloseButton: true,
            showConfirmButton: false,
        });
    }
</script>
@endsection
