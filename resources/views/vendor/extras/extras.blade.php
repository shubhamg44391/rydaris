@extends('admin.layouts.app')

@section('title', 'Extras Management')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>Extras Management</h2>
            </div>
            <div>
                <a href="{{ route('vendor.extras.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add New Extra
                </a>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success" style="margin: 0 24px 16px;">
                {{ session('success') }}
            </div>
        @endif

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
                    @forelse ($extras as $extra)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                <div style="width: 40px; height: 40px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #475569;">
                                    <i class="{{ $extra->icon_class ?: 'fas fa-box' }}"></i>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $extra->name }}</strong>
                            </td>
                            <td>${{ number_format($extra->price, 2) }}</td>
                            <td title="{{ $extra->description }}" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $extra->description ?: '—' }}
                            </td>
                            <td>
                                @if($extra->status)
                                    <span class="badge" style="background: #dcfce7; color: #067647; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem; cursor: pointer;" onclick="xpToggle({{ $extra->id }}, this)">Active</span>
                                @else
                                    <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem; cursor: pointer;" onclick="xpToggle({{ $extra->id }}, this)">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $extra->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <button type="button" class="icon-button" title="View" onclick="xpView('{{ addslashes($extra->name) }}','{{ $extra->icon_class }}','{{ $extra->price }}','{{ addslashes($extra->description) }}')" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #3b82f6; background: #ffffff; cursor: pointer;">
                                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                    <a href="{{ route('vendor.extras.edit', $extra->id) }}" class="icon-button" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0f766e; background: #ffffff;">
                                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('vendor.extras.destroy', $extra->id) }}" method="POST" class="delete-form" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #fee2e2; border-radius: var(--radius); color: #ef4444; background: #ffffff; cursor: pointer; padding: 0;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4" style="text-align: center; padding: 20px;">No extras found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the extra. You won't be able to revert this!",
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

    function xpToggle(id, el) {
        fetch(`/vendor/extras/${id}/toggle`, {
            method:'POST',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}
        }).then(r=>r.json()).then(d=>{
            if(d.status==='success'){
                el.style.background = d.new_status ? '#dcfce7' : '#f1f5f9';
                el.style.color = d.new_status ? '#067647' : '#64748b';
                el.textContent = d.new_status ? 'Active' : 'Inactive';
            }
        });
    }

    function xpView(name, icon, price, desc) {
        Swal.fire({
            title: name,
            html: `
                <div style="text-align: left; padding-top: 10px;">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
                        <div style="width:50px;height:50px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:#3b82f6;flex-shrink:0;">
                            <i class="${icon||'fas fa-box'}"></i>
                        </div>
                        <div>
                            <div style="color:#64748b;font-size:0.83rem;">Vehicle Extra Add-on</div>
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
