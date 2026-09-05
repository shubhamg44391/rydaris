@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div>
                <h2>Role Management</h2>
            </div>
            <div>
                @if(auth()->user()->hasAdminPermission('role_management', 'add'))
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary rounded-pill px-4" style="font-weight: 800 !important; display: inline-flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Role
                </a>
                @endif
            </div>
        </div>

        <div id="roleTableContainer">
            @include('admin.roles.partials.table')
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        function fetchRoles(url, pushState) {
            if (pushState === undefined) pushState = true;
            $('#roleTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.success) {
                        $('#roleTableContainer').html(data.html);
                        if (pushState) history.pushState({ url: url }, '', url);
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to fetch roles data.', 'error');
                },
                complete: function () {
                    $('#roleTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        }

        $(document).on('click', '#roleTableContainer .pagination a', function (e) {
            e.preventDefault();
            fetchRoles($(this).attr('href'));
        });

        window.addEventListener('popstate', function (e) {
            if (e.state && e.state.url) fetchRoles(e.state.url, false);
            else fetchRoles(window.location.href, false);
        });

        $(document).on('click', '.delete-role-btn', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            var $row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the role permanently!",
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
                                $row.fadeOut(300, function() { $(this).remove(); });
                                Swal.fire('Deleted!', data.message, 'success');
                            } else {
                                Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete role.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
