@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>My Customers</h2>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <div style="position: relative; min-width: 250px;">
                    <input type="text" id="customerSearchInput" placeholder="Search customers..." value="{{ request('search') }}" class="form-control" style="padding: 9px 16px 9px 38px; border-radius: 999px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.1)); color: var(--text, #f8fafc); font-size: 0.88rem; width: 100%;">
                    <svg viewBox="0 0 24 24" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; fill: none; stroke: #94a3b8; stroke-width: 2;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <button type="button" onclick="openAddCustomerModal()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border-radius: 999px; font-weight: 800 !important; font-size: 0.85rem; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35); white-space: nowrap; flex-shrink: 0; transition: all 0.2s;">
                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 3;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Add Customer
                </button>
            </div>
        </div>

        <div id="customersTableContainer">
        @section('customers_table_section')
            <div class="panel-body admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Registered Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startingNumber = ($customers->currentPage() - 1) * $customers->perPage() + 1;
                        @endphp
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $startingNumber++ }}</td>
                                <td>
                                    {{ $customer->first_name ?? $customer->name }}
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td><strong>{{ trim(($customer->country_code ?? '') . ' ' . ($customer->contact_number ?? 'N/A')) }}</strong></td>
                                <td>{{ $customer->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="table-actions" style="display: flex; gap: 8px; align-items: center;">
                                        <button type="button" onclick="openViewModalFromData(this)" data-customer="{{ json_encode($customer) }}" class="icon-button view-btn" title="View Customer Details" style="color: #52ead2; background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>

                                        <button type="button" onclick="openEditCustomerModal({{ $customer->id }})" class="icon-button edit-btn" title="Edit Customer" style="color: var(--brand, #52ead2); background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>

                                        <form action="{{ route('vendor.customers.destroy', $customer->id) }}" method="POST" class="delete-form" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-button delete-btn" title="Delete Customer" style="color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="text-align: center;">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line, rgba(255,255,255,0.08)); display: flex; justify-content: space-between; align-items: center; padding: 12px 24px;">
                <div class="text-muted small">
                    Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} entries
                </div>
                <div>
                    {{ $customers->links('vendor.pagination.custom') }}
                </div>
            </div>
        @show
        </div>
    </div>

    
    {{-- Add/Edit Customer Modal --}}
    <div id="customerModal" class="custom-modal">
        <div class="modal-content" style="max-width: 600px; padding: 25px; border-radius: 12px; background: rgba(11, 16, 32, 0.95); border: 1px solid rgba(82, 234, 210, 0.2); box-shadow: 0 24px 80px rgba(0,0,0,0.6); width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 id="customerModalTitle" style="margin: 0; color: #f8fafc;">Add New Customer</h3>
                <span onclick="closeCustomerModal()" style="color: #94a3b8; font-size: 24px; cursor: pointer;">&times;</span>
            </div>
            
            <form id="customerForm" onsubmit="submitCustomerModalForm(event)">
                <input type="hidden" id="modal_cust_id" name="cust_id" value="">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">First Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="modal_first_name" required class="form-control" placeholder="Enter first name" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                    </div>
                    <div>
                        <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">Last Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="modal_last_name" required class="form-control" placeholder="Enter last name" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">Email Address <span style="color: #ef4444;">*</span></label>
                    <input type="email" id="modal_email" required class="form-control" placeholder="customer@example.com" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                </div>

                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 10px; margin-bottom: 15px;">
                    <div>
                        <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">Code <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="modal_country_code" required class="form-control" placeholder="+91" value="+91" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                    </div>
                    <div>
                        <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">Contact Number <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="modal_contact_number" required class="form-control" placeholder="Phone number" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">Password <span id="passReqStar" style="color: #ef4444;">*</span></label>
                        <input type="password" id="modal_password" class="form-control" placeholder="Minimum 8 characters" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                    </div>
                    <div>
                        <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">Confirm Password</label>
                        <input type="password" id="modal_password_confirmation" class="form-control" placeholder="Confirm password" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                    </div>
                </div>

                <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                    <button type="button" onclick="closeCustomerModal()" class="btn btn-secondary rounded-pill px-4" style="font-weight: 700;">Cancel</button>
                    <button type="submit" id="btnCustomerSubmit" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border: none; font-weight: 800 !important; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35);">Save Customer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- View Customer Modal --}}
    <div id="viewModal" class="custom-modal">
        <div class="modal-content" style="max-width: 500px; padding: 25px; border-radius: 12px; background: rgba(11, 16, 32, 0.95); border: 1px solid rgba(82, 234, 210, 0.2); box-shadow: 0 24px 80px rgba(0,0,0,0.6); width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #f8fafc;">Customer Details</h3>
                <span onclick="closeViewModal()" style="color: #94a3b8; font-size: 24px; cursor: pointer;">&times;</span>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px; color: #cbd5e1; font-size: 0.95rem;">
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Name</strong>
                    <span id="modalName"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Email</strong>
                    <a id="modalEmail" href="#" style="color: #0f766e; text-decoration: none;"></a>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Contact</strong>
                    <span id="modalContact"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Account Status</strong>
                    <span id="modalStatus" style="text-transform: capitalize;"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Registered Date</strong>
                    <span id="modalDate"></span>
                </div>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn btn-sm" onclick="closeViewModal()" style="background: rgba(255,255,255,0.1); color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>
    
    <style>
        .custom-modal {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(5, 7, 17, 0.85);
            z-index: 9999;
            align-items: center; justify-content: center;
            backdrop-filter: blur(8px);
        }
    </style>
@endsection

@section('js')
<script>
    function openAddCustomerModal() {
        $('#modal_cust_id').val('');
        $('#modal_first_name').val('');
        $('#modal_last_name').val('');
        $('#modal_email').val('');
        $('#modal_country_code').val('+91');
        $('#modal_contact_number').val('');
        $('#modal_password').val('').prop('required', true);
        $('#modal_password_confirmation').val('');
        $('#passReqStar').show();
        $('#customerModalTitle').text('Add New Customer');
        $('#customerModal').css('display', 'flex');
    }

    function openEditCustomerModal(id) {
        $.ajax({
            url: '{{ url("vendor/customers") }}/' + id + '/edit',
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success && response.customer) {
                    var cust = response.customer;
                    $('#modal_cust_id').val(cust.id);
                    $('#modal_first_name').val(cust.first_name || cust.name || '');
                    $('#modal_last_name').val(cust.name || '');
                    $('#modal_email').val(cust.email || '');
                    $('#modal_country_code').val(cust.country_code || '+91');
                    $('#modal_contact_number').val(cust.contact_number || '');
                    $('#modal_password').val('').prop('required', false);
                    $('#modal_password_confirmation').val('');
                    $('#passReqStar').hide();
                    $('#customerModalTitle').text('Edit Customer Details');
                    $('#customerModal').css('display', 'flex');
                } else {
                    Swal.fire('Error', 'Failed to load customer details.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to load customer details.', 'error');
            }
        });
    }

    function closeCustomerModal() {
        $('#customerModal').css('display', 'none');
    }

    function submitCustomerModalForm(e) {
        if (e && e.preventDefault) e.preventDefault();
        var custId = $('#modal_cust_id').val();
        var isEdit = !!custId;
        var url = isEdit ? '{{ url("vendor/customers") }}/' + custId : '{{ route("vendor.customers.store") }}';
        var method = isEdit ? 'PUT' : 'POST';

        var firstName = $('#modal_first_name').val();
        var lastName = $('#modal_last_name').val();
        var email = $('#modal_email').val();
        var countryCode = $('#modal_country_code').val();
        var contactNumber = $('#modal_contact_number').val();
        var password = $('#modal_password').val();
        var passwordConfirm = $('#modal_password_confirmation').val();

        if (!firstName || !lastName || !email || !contactNumber) {
            Swal.fire('Error', 'Please fill in all required fields.', 'error');
            return false;
        }

        if (!isEdit && !password) {
            Swal.fire('Error', 'Password is required for new customer.', 'error');
            return false;
        }

        if (password && password !== passwordConfirm) {
            Swal.fire('Error', 'Passwords do not match.', 'error');
            return false;
        }

        $('#btnCustomerSubmit').prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: method,
                first_name: firstName,
                name: lastName,
                email: email,
                country_code: countryCode,
                contact_number: contactNumber,
                password: password,
                password_confirmation: passwordConfirm
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                $('#btnCustomerSubmit').prop('disabled', false).text('Save Customer');
                if (response.success) {
                    closeCustomerModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Customer saved successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    fetchCustomers();
                } else {
                    Swal.fire('Error!', response.message || 'Failed to save customer.', 'error');
                }
            },
            error: function(xhr) {
                $('#btnCustomerSubmit').prop('disabled', false).text('Save Customer');
                var errorMsg = 'An error occurred while saving customer.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error!', errorMsg, 'error');
            }
        });
    }

    function openViewModalFromData(btn) {
        const data = JSON.parse(btn.getAttribute('data-customer'));
        
        document.getElementById('modalName').textContent = (data.first_name || '') + ' ' + (data.name || '');
        document.getElementById('modalEmail').textContent = data.email;
        document.getElementById('modalEmail').href = 'mailto:' + data.email;
        document.getElementById('modalContact').textContent = (data.country_code ? data.country_code + ' ' : '') + (data.contact_number || 'N/A');
        document.getElementById('modalStatus').textContent = data.status || 'Active';
        document.getElementById('modalDate').textContent = new Date(data.created_at).toLocaleString();
        
        document.getElementById('viewModal').style.display = 'flex';
    }

    function closeViewModal() {
        document.getElementById('viewModal').style.display = 'none';
    }

    var currentCustomerSearchQuery = '{{ request("search") }}';
    var customerSearchTimer = null;

    function fetchCustomers(url) {
        url = url || '{{ route("vendor.customers.index") }}';
        $('#customersTableContainer').css('opacity', '0.5');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search: currentCustomerSearchQuery
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success && response.html) {
                    $('#customersTableContainer').html(response.html).css('opacity', '1');
                }
            },
            error: function() {
                $('#customersTableContainer').css('opacity', '1');
            }
        });
    }

    // Close on outside click
    window.onclick = function(event) {
        const vModal = document.getElementById('viewModal');
        const cModal = document.getElementById('customerModal');
        if (event.target == vModal) {
            closeViewModal();
        }
        if (event.target == cModal) {
            closeCustomerModal();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Search input keyup
        $(document).on('keyup', '#customerSearchInput', function() {
            clearTimeout(customerSearchTimer);
            currentCustomerSearchQuery = $(this).val();
            customerSearchTimer = setTimeout(function() {
                fetchCustomers();
            }, 350);
        });

        // AJAX Pagination click
        $(document).on('click', '#customersTableContainer .pagination a', function(e) {
            e.preventDefault();
            var pageUrl = $(this).attr('href');
            if (pageUrl) {
                fetchCustomers(pageUrl);
            }
        });

        // Delete confirmation with AJAX
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const actionUrl = form.attr('action');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the customer account. You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message || 'Customer deleted successfully.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                fetchCustomers();
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete customer.', 'error');
                            }
                        },
                        error: function() {
                            form[0].submit();
                        }
                    });
                }
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
