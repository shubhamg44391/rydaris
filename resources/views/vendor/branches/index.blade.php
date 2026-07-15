@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>Branch Management</h2>
                <p class="panel-muted" style="margin: 4px 0 0 0; font-size: 0.88rem;">Manage your physical office branches. <span id="limitBadge" style="font-weight: 700; color: var(--brand, #52ead2);">Loading limits...</span></p>
            </div>
            <div>
                <button type="button" id="addNewBtn" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Branch
                </button>
            </div>
        </div>

        <div class="panel-body admin-table-wrap" style="position: relative;">
            <!-- Loading Indicator -->
            <div id="tableLoader" style="position: absolute; inset: 0; background: rgba(5, 7, 17, 0.7); display: flex; align-items: center; justify-content: center; z-index: 10;">
                <div style="width: 40px; height: 40px; border: 3px solid rgba(255, 255, 255, 0.1); border-top: 3px solid var(--brand, #52ead2); border-radius: 50%; animation: spin 1s linear infinite;"></div>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="branchesTableBody">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Branch Modal -->
    <div id="addModal" style="position: fixed; inset: 0; background: rgba(5, 7, 17, 0.85); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; z-index: 99999;">
        <div style="background: #0b1020; border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 16px; width: 100%; max-width: 500px; padding: 30px; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px;">
                <h4 style="margin: 0; color: #f8fafc; font-weight: 600;">Add New Branch</h4>
                <button type="button" class="close-modal-btn" style="background: none; border: none; font-size: 20px; color: #cbd5e1; cursor: pointer;">&times;</button>
            </div>
            <form id="addBranchForm">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom" style="display: block; margin-bottom: 6px; color: #f8fafc;">Branch Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" required class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: var(--radius); padding: 12px; color: #fff; width: 100%;" placeholder="e.g. Downtown Office" />
                    <div class="error-msg" id="add-error-name" style="color: #f87171; font-size: 0.8rem; margin-top: 4px;"></div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" class="btn btn-secondary close-modal-btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); color: #cbd5e1; padding: 10px 20px; border-radius: var(--radius); cursor: pointer;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="border: none; cursor: pointer; padding: 10px 20px; border-radius: var(--radius);">Save Branch</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Branch Modal -->
    <div id="editModal" style="position: fixed; inset: 0; background: rgba(5, 7, 17, 0.85); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; z-index: 99999;">
        <div style="background: #0b1020; border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 16px; width: 100%; max-width: 500px; padding: 30px; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px;">
                <h4 style="margin: 0; color: #f8fafc; font-weight: 600;">Edit Branch</h4>
                <button type="button" class="close-modal-btn" style="background: none; border: none; font-size: 20px; color: #cbd5e1; cursor: pointer;">&times;</button>
            </div>
            <form id="editBranchForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_branch_id" />
                <div style="margin-bottom: 15px;">
                    <label class="form-label-custom" style="display: block; margin-bottom: 6px; color: #f8fafc;">Branch Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="edit_name" name="name" required class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: var(--radius); padding: 12px; color: #fff; width: 100%;" />
                    <div class="error-msg" id="edit-error-name" style="color: #f87171; font-size: 0.8rem; margin-top: 4px;"></div>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom" style="display: block; margin-bottom: 6px; color: #f8fafc;">Status</label>
                    <select id="edit_status" name="status" class="form-control" style="background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: var(--radius); padding: 12px; color: #fff; width: 100%;">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <div class="error-msg" id="edit-error-status" style="color: #f87171; font-size: 0.8rem; margin-top: 4px;"></div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" class="btn btn-secondary close-modal-btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); color: #cbd5e1; padding: 10px 20px; border-radius: var(--radius); cursor: pointer;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="border: none; cursor: pointer; padding: 10px 20px; border-radius: var(--radius);">Update Branch</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const branchesTableBody = document.getElementById('branchesTableBody');
            const tableLoader = document.getElementById('tableLoader');
            const limitBadge = document.getElementById('limitBadge');

            const addModal = document.getElementById('addModal');
            const editModal = document.getElementById('editModal');

            // Open/Close Modals
            document.getElementById('addNewBtn').addEventListener('click', () => {
                document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');
                document.getElementById('addBranchForm').reset();
                addModal.style.display = 'flex';
            });

            document.querySelectorAll('.close-modal-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    addModal.style.display = 'none';
                    editModal.style.display = 'none';
                });
            });

            // Load Branches List
            function loadBranches() {
                tableLoader.style.display = 'flex';
                fetch("{{ route('vendor.branches.list') }}")
                    .then(res => res.json())
                    .then(data => {
                        tableLoader.style.display = 'none';
                        if (data.status === 'success') {
                            limitBadge.innerHTML = `(${data.used} / ${data.limit_text} Used)`;
                            
                            // Enable/disable Add Button based on capacity
                            const addNewBtn = document.getElementById('addNewBtn');
                            if (!data.can_add) {
                                addNewBtn.disabled = true;
                                addNewBtn.title = "Your package limit for branches has been reached.";
                                addNewBtn.style.opacity = '0.5';
                            } else {
                                addNewBtn.disabled = false;
                                addNewBtn.title = "";
                                addNewBtn.style.opacity = '1';
                            }

                            branchesTableBody.innerHTML = '';
                            if (data.branches.length === 0) {
                                branchesTableBody.innerHTML = `
                                    <tr>
                                        <td colspan="4" class="text-center py-4" style="text-align: center; padding: 30px; color: #a8b3c5;">No branches found. Click 'Add Branch' to add one.</td>
                                    </tr>
                                `;
                                return;
                            }

                            data.branches.forEach((branch, index) => {
                                const tr = document.createElement('tr');
                                const statusBadge = branch.status 
                                    ? `<span style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">Active</span>` 
                                    : `<span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">Inactive</span>`;

                                tr.innerHTML = `
                                    <td>${index + 1}</td>
                                    <td style="font-weight: 600; color: #fff;">${branch.name}</td>
                                    <td>${statusBadge}</td>
                                    <td>
                                        <div class="table-actions" style="display: flex; gap: 8px;">
                                            <button type="button" class="icon-button edit-btn" data-id="${branch.id}" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(82, 234, 210, 0.2); border-radius: var(--radius); color: #52ead2; background: rgba(82, 234, 210, 0.05); cursor: pointer; padding:0;">
                                                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                            </button>
                                            <button type="button" class="icon-button delete-btn" data-id="${branch.id}" title="Delete" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: var(--radius); color: #ef4444; background: rgba(239, 68, 68, 0.05); cursor: pointer; padding:0;">
                                                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                `;
                                branchesTableBody.appendChild(tr);
                            });

                            bindActionButtons();
                        }
                    })
                    .catch(err => {
                        tableLoader.style.display = 'none';
                        console.error("Error loading branches: ", err);
                    });
            }

            // Bind click events to dynamically loaded table action buttons
            function bindActionButtons() {
                // Edit Click
                document.querySelectorAll('.edit-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');
                        
                        fetch(`/vendor/branches/${id}/edit`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    document.getElementById('edit_branch_id').value = data.branch.id;
                                    document.getElementById('edit_name').value = data.branch.name;
                                    document.getElementById('edit_status').value = data.branch.status ? "1" : "0";
                                    editModal.style.display = 'flex';
                                }
                            });
                    });
                });

                // Delete Click
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This will delete the branch. You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#8592a3',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/vendor/branches/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: data.message,
                                            icon: 'success',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                        loadBranches();
                                    } else {
                                        Swal.fire('Error', data.message || 'Failed to delete branch.', 'error');
                                    }
                                });
                            }
                        });
                    });
                });
            }

            // Submit Add Branch Form
            document.getElementById('addBranchForm').addEventListener('submit', function (e) {
                e.preventDefault();
                document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

                const formData = new FormData(this);
                fetch("{{ route('vendor.branches.store') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => {
                    if (res.status === 422) {
                        return res.json().then(errData => {
                            throw errData;
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        addModal.style.display = 'none';
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadBranches();
                    }
                })
                .catch(err => {
                    if (err.errors) {
                        for (let field in err.errors) {
                            const errContainer = document.getElementById(`add-error-${field}`);
                            if (errContainer) {
                                errContainer.textContent = err.errors[field][0];
                            }
                        }
                    } else {
                        Swal.fire('Error', err.message || 'An error occurred.', 'error');
                    }
                });
            });

            // Submit Edit Branch Form
            document.getElementById('editBranchForm').addEventListener('submit', function (e) {
                e.preventDefault();
                document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

                const id = document.getElementById('edit_branch_id').value;
                const name = document.getElementById('edit_name').value;
                const status = document.getElementById('edit_status').value;

                fetch(`/vendor/branches/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name, status })
                })
                .then(res => {
                    if (res.status === 422) {
                        return res.json().then(errData => {
                            throw errData;
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        editModal.style.display = 'none';
                        Swal.fire({
                            title: 'Updated!',
                            text: data.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadBranches();
                    }
                })
                .catch(err => {
                    if (err.errors) {
                        for (let field in err.errors) {
                            const errContainer = document.getElementById(`edit-error-${field}`);
                            if (errContainer) {
                                errContainer.textContent = err.errors[field][0];
                            }
                        }
                    } else {
                        Swal.fire('Error', err.message || 'An error occurred.', 'error');
                    }
                });
            });

            // Initial Load
            loadBranches();
        });
    </script>
@endsection
