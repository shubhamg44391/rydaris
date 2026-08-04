@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div>
                <h2 style="margin: 0; font-size: 1.35rem; font-weight: 800;">Group Management</h2>
            </div>
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: nowrap;">
              

                <button type="button" onclick="openAddGroupModal()" class="btn" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border-radius: 999px; font-weight: 800 !important; font-size: 0.85rem; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35); white-space: nowrap; flex-shrink: 0; transition: all 0.2s;">
                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 3;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Group
                </button>
            </div>
        </div>

        <div id="groupsTableContainer">
            @section('groups_table_section')
            <div class="panel-body admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">S.No</th>
                            <th style="white-space: nowrap;">Name</th>
                            <th style="white-space: nowrap;">Description</th>
                            <th style="white-space: nowrap;">Created Date</th>
                            <th style="white-space: nowrap; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startingNumber = ($groups->currentPage() - 1) * $groups->perPage() + 1;
                        @endphp
                        @forelse ($groups as $group)
                            <tr id="group-row-{{ $group->id }}">
                                <td>{{ $startingNumber++ }}</td>
                                <td>
                                    <strong>{{ $group->name }}</strong>
                                </td>
                                <td>{{ Str::limit(strip_tags($group->description ?? 'N/A'), 100) }}</td>
                                <td>{{ $group->created_at->format('M d, Y H:i') }}</td>
                                <td style="text-align: right;">
                                    <div class="table-actions" style="display: inline-flex; gap: 8px; justify-content: flex-end;">
                                        <button type="button" class="icon-button edit-group-btn" title="Edit Group"
                                                data-id="{{ $group->id }}"
                                                data-name="{{ $group->name }}"
                                                data-description="{{ $group->description ?? '' }}"
                                                style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(82,234,210,0.3); border-radius: 4px; color: #52ead2; background: rgba(82,234,210,0.1); cursor: pointer;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                        </button>
                                        <button type="button" class="icon-button ajax-delete-group-btn" title="Delete Group"
                                                data-id="{{ $group->id }}"
                                                data-name="{{ $group->name }}"
                                                style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(239,68,68,0.3); border-radius: 4px; color: #ef4444; background: rgba(239,68,68,0.1); cursor: pointer;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4" style="text-align: center; padding: 24px; color: #94a3b8;">No vehicle groups found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($groups->hasPages())
                <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; padding: 16px 24px;">
                    <div class="text-muted small">
                        Showing {{ $groups->firstItem() ?? 0 }} to {{ $groups->lastItem() ?? 0 }} of {{ $groups->total() }} results
                    </div>
                    <div>
                        {{ $groups->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
            @endsection
            @yield('groups_table_section')
        </div>
    </div>

    <!-- Add / Edit Group Modal -->
    <div id="groupModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: var(--bg-card, #1e293b); border: 1px solid var(--line, #334155); border-radius: 12px; width: 100%; max-width: 520px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); overflow: hidden;">
            <div style="padding: 16px 20px; border-bottom: 1px solid var(--line, #334155); display: flex; justify-content: space-between; align-items: center;">
                <h5 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: var(--text, #f8fafc);" id="groupModalTitle">
                    Add Vehicle Group
                </h5>
                <button type="button" onclick="closeGroupModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <form id="groupForm" onsubmit="event.preventDefault(); submitGroupForm(event); return false;">
                @csrf
                <input type="hidden" id="group_id" value="">
                <div style="padding: 20px;">
                    <div class="mb-3" style="margin-bottom: 16px;">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 8px;">Group Name *</label>
                        <input type="text" name="name" id="modal_group_name" class="form-control dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;" required placeholder="e.g. SUV, Luxury, Sedan">
                    </div>
                    <div class="mb-3" style="margin-bottom: 16px;">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 8px;">Description</label>
                        <textarea name="description" id="modal_group_description" rows="4" class="form-control dark-input" style="width: 100%; padding: 8px 12px; background: #0b0f17; border: 1px solid rgba(255,255,255,0.12); color: #f8fafc; border-radius: 6px;" placeholder="Enter group description..."></textarea>
                    </div>
                </div>
                <div style="padding: 14px 20px; border-top: 1px solid var(--line, #334155); display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeGroupModal()" class="btn btn-secondary rounded-pill px-4" style="font-weight: 700;">Cancel</button>
                    <button type="submit" id="btnGroupSubmit" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border: none; font-weight: 800 !important; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35);">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    var currentGroupSearchQuery = '';
    var groupSearchTimer = null;

    function fetchGroups(url) {
        url = url || '{{ route("vendor.groups.index") }}';
        $('#groupsTableContainer').css('opacity', '0.5');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search: currentGroupSearchQuery
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success && response.html) {
                    $('#groupsTableContainer').html(response.html).css('opacity', '1');
                }
            },
            error: function() {
                $('#groupsTableContainer').css('opacity', '1');
            }
        });
    }

    function openAddGroupModal() {
        $('#group_id').val('');
        $('#modal_group_name').val('');
        $('#modal_group_description').val('');
        $('#groupModalTitle').text('Add Vehicle Group');
        $('#groupModal').css('display', 'flex');
    }

    function openEditGroupModal(id, name, description) {
        $('#group_id').val(id);
        $('#modal_group_name').val(name);
        $('#modal_group_description').val(description);
        $('#groupModalTitle').text('Edit Vehicle Group');
        $('#groupModal').css('display', 'flex');
    }

    function closeGroupModal() {
        $('#groupModal').css('display', 'none');
    }

    function submitGroupForm(e) {
        if (e && e.preventDefault) e.preventDefault();
        var groupId = $('#group_id').val();
        var isEdit = !!groupId;
        var url = isEdit ? '{{ url("vendor/groups") }}/' + groupId : '{{ route("vendor.groups.store") }}';
        var method = isEdit ? 'PUT' : 'POST';

        var nameVal = $('#modal_group_name').val();
        if (!nameVal) {
            Swal.fire('Error!', 'Please enter group name.', 'error');
            return false;
        }

        $('#btnGroupSubmit').prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: method,
                name: nameVal,
                description: $('#modal_group_description').val()
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success) {
                    closeGroupModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Vehicle Group saved successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    fetchGroups();
                } else {
                    Swal.fire('Error!', response.message || 'Failed to save group.', 'error');
                }
            },
            error: function(xhr) {
                var errorMsg = 'An error occurred.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errs = [];
                    $.each(xhr.responseJSON.errors, function(key, msgs) {
                        errs.push(msgs.join(', '));
                    });
                    errorMsg = errs.join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error!', errorMsg, 'error');
            },
            complete: function() {
                $('#btnGroupSubmit').prop('disabled', false).text('Save');
            }
        });

        return false;
    }

    $(document).ready(function() {
        // Edit group button click
        $(document).on('click', '.edit-group-btn', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            openEditGroupModal(id, name, description);
        });

        // Delete group button click
        $(document).on('click', '.ajax-delete-group-btn', function() {
            var groupId = $(this).data('id');
            var groupName = $(this).data('name') || 'this group';
            var $row = $('#group-row-' + groupId);

            Swal.fire({
                title: 'Delete Vehicle Group?',
                text: 'Are you sure you want to delete "' + groupName + '"? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("vendor/groups") }}/' + groupId,
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
                                    text: response.message || 'Vehicle group deleted successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete group.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete vehicle group.', 'error');
                        }
                    });
                }
            });
        });

        // Search input keyup
        $(document).on('keyup', '#groupSearchInput', function() {
            clearTimeout(groupSearchTimer);
            currentGroupSearchQuery = $(this).val();
            groupSearchTimer = setTimeout(function() {
                fetchGroups();
            }, 350);
        });

        // AJAX Pagination click
        $(document).on('click', '#groupsTableContainer .pagination a', function(e) {
            e.preventDefault();
            var pageUrl = $(this).attr('href');
            if (pageUrl) {
                fetchGroups(pageUrl);
            }
        });
    });
</script>
@endsection
