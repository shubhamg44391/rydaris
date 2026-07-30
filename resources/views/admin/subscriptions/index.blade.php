@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>
                    Subscription Payments & Invoices
                    <span id="subscriptionStatusHeading">
                        @if(isset($status) && $status === 'active')
                            - Active
                        @elseif(isset($status) && $status === 'expired')
                            - Expired
                        @endif
                    </span>
                </h2>
            </div>
            <!-- <div>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="openAddSubscriptionModal()" style="font-weight: 800 !important;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Assign Subscription
                </button>
            </div> -->
        </div>

        
        <div class="panel-filter-bar" style="margin-bottom: 20px;">
            <a href="{{ route('admin.subscriptions.index') }}" data-filter="" class="btn btn-sm {{ !($status ?? null) ? 'active' : '' }}">
                All Subscriptions
            </a>
            <a href="{{ route('admin.subscriptions.index', ['status' => 'active']) }}" data-filter="active" class="btn btn-sm {{ ($status ?? null) === 'active' ? 'active' : '' }}">
                Active
            </a>
            <a href="{{ route('admin.subscriptions.index', ['status' => 'expired']) }}" data-filter="expired" class="btn btn-sm {{ ($status ?? null) === 'expired' ? 'active' : '' }}">
                Expired
            </a>
        </div>

        <div id="subscriptionTableContainer">
            @include('admin.subscriptions.partials.table')
        </div>
    </div>

    
    <div id="subscriptionModal" class="custom-modal" style="display: none; position: fixed; inset: 0; z-index: 99999; padding: 16px; box-sizing: border-box; align-items: center; justify-content: center; background: rgba(5, 7, 17, 0.85); backdrop-filter: blur(8px);" onclick="if(event.target === this) closeSubscriptionModal();">
        <div class="subscription-modal-card" style="position: relative; z-index: 1; width: 100%; max-width: 600px; background: #0b1020; border-radius: 12px; overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,0.7); border: 1px solid rgba(82, 234, 210, 0.25);">
            <div class="subscription-modal-header" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid rgba(82, 234, 210, 0.2); background: #070a14;">
                <h3 id="subscriptionModalTitle" class="subscription-modal-title" style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #ffffff;">Assign New Subscription</h3>
                <button type="button" class="subscription-modal-close" onclick="closeSubscriptionModal()" style="background: none; border: none; font-size: 24px; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <form id="subscriptionForm" style="padding: 24px;">
                @csrf
                <input type="hidden" id="subscription_id" name="subscription_id">
                <input type="hidden" id="_method" name="_method" value="POST">

                <div class="mb-3">
                    <label class="sub-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">VENDOR <span style="color: #fb7185;">*</span></label>
                    <select id="sub_vendor_id" name="vendor_id" class="sub-form-input" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $v)
                            <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->company_name ?? $v->email }})</option>
                        @endforeach
                    </select>
                    <div id="sub_err_vendor_id" class="invalid-feedback-text" style="color: #fb7185; font-size: 0.8rem; margin-top: 4px; font-weight: 600; display: none;"></div>
                </div>

                <div class="mb-3">
                    <label class="sub-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">PACKAGE / PLAN <span style="color: #fb7185;">*</span></label>
                    <select id="sub_package_id" name="package_id" class="sub-form-input" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                        <option value="">Select Package</option>
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}">{{ $pkg->name }} - ${{ number_format((float) $pkg->price, 2) }} / {{ $pkg->billing_period ?? 'month' }}</option>
                        @endforeach
                    </select>
                    <div id="sub_err_package_id" class="invalid-feedback-text" style="color: #fb7185; font-size: 0.8rem; margin-top: 4px; font-weight: 600; display: none;"></div>
                </div>

                <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label class="sub-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">STARTS AT <span style="color: #fb7185;">*</span></label>
                        <input type="date" id="sub_starts_at" name="starts_at" class="sub-form-input" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                        <div id="sub_err_starts_at" class="invalid-feedback-text" style="color: #fb7185; font-size: 0.8rem; margin-top: 4px; font-weight: 600; display: none;"></div>
                    </div>
                    <div style="flex: 1;">
                        <label class="sub-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">ENDS AT <span style="color: #fb7185;">*</span></label>
                        <input type="date" id="sub_ends_at" name="ends_at" class="sub-form-input" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                        <div id="sub_err_ends_at" class="invalid-feedback-text" style="color: #fb7185; font-size: 0.8rem; margin-top: 4px; font-weight: 600; display: none;"></div>
                    </div>
                </div>

                <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label class="sub-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">AMOUNT PAID (INR / USD eq)</label>
                        <input type="number" step="0.01" id="sub_amount_paid" name="amount_paid" class="sub-form-input" placeholder="e.g. 8300" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                    </div>
                    <div style="flex: 1;">
                        <label class="sub-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">STATUS <span style="color: #fb7185;">*</span></label>
                        <select id="sub_status" name="status" class="sub-form-input" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                        </select>
                        <div id="sub_err_status" class="invalid-feedback-text" style="color: #fb7185; font-size: 0.8rem; margin-top: 4px; font-weight: 600; display: none;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="sub-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">PAYMENT REF ID (Optional)</label>
                    <input type="text" id="sub_payment_id" name="razorpay_payment_id" class="sub-form-input" placeholder="e.g. pay_N23x982a or MANUAL_CASH" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 16px;">
                    <button type="button" class="sub-modal-cancel-btn" onclick="closeSubscriptionModal()" style="background: rgba(255,255,255,0.1); border: none; color: #ffffff; padding: 8px 18px; border-radius: 6px; cursor: pointer; font-size: 0.9rem;">Cancel</button>
                    <button type="submit" id="subSubmitBtn" style="background: var(--brand, #52ead2); border: none; color: #051013; padding: 8px 22px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; font-weight: 700;">Save Subscription</button>
                </div>
            </form>
        </div>
    </div>

    
    <div id="invoiceModal" style="display: none; position: fixed; inset: 0; z-index: 100000; padding: 16px; box-sizing: border-box; align-items: center; justify-content: center;">
        <div style="position: absolute; inset: 0; background: rgba(5, 7, 17, 0.85); backdrop-filter: blur(8px);" onclick="closeInvoiceModal()"></div>
        <div class="invoice-modal-card" style="position: relative; z-index: 1; width: 100%; max-width: 900px; height: calc(100vh - 40px); background: #050711; border-radius: 12px; overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,0.7); display: flex; flex-direction: column; border: 1px solid rgba(82, 234, 210, 0.25);">
            <div class="invoice-modal-header" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid rgba(82, 234, 210, 0.2); background: #0b1020;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #ffffff;">Package Invoice</h3>
                <button type="button" class="subscription-modal-close" onclick="closeInvoiceModal()" style="background: none; border: none; font-size: 24px; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <iframe id="invoiceIframe" style="width: 100%; height: 100%; border: none; background: #050711;"></iframe>
        </div>
    </div>

    <style>
    /* Light Mode Overrides for Subscriptions Page */
    body.light-mode .subscription-modal-card,
    html.light-mode .subscription-modal-card {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
    }

    body.light-mode .subscription-modal-header,
    html.light-mode .subscription-modal-header {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    body.light-mode .subscription-modal-title,
    html.light-mode .subscription-modal-title {
        color: #0f172a !important;
    }

    body.light-mode .subscription-modal-close,
    html.light-mode .subscription-modal-close {
        color: #64748b !important;
    }

    body.light-mode .sub-form-label,
    html.light-mode .sub-form-label {
        color: #1e293b !important;
    }

    body.light-mode .sub-form-input,
    html.light-mode .sub-form-input {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
    }

    body.light-mode .sub-form-input option,
    html.light-mode .sub-form-input option {
        background: #ffffff !important;
        color: #0f172a !important;
    }

    body.light-mode .sub-modal-cancel-btn,
    html.light-mode .sub-modal-cancel-btn {
        background: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
    }

    body.light-mode .invoice-modal-card,
    html.light-mode .invoice-modal-card {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
    }

    body.light-mode .invoice-modal-header,
    html.light-mode .invoice-modal-header {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    body.light-mode .invoice-modal-header h3,
    html.light-mode .invoice-modal-header h3 {
        color: #0f172a !important;
    }

    body.light-mode .sub-vendor-name,
    html.light-mode .sub-vendor-name,
    body.light-mode .sub-plan-name,
    html.light-mode .sub-plan-name {
        color: #0f172a !important;
    }

    body.light-mode .sub-code-block,
    html.light-mode .sub-code-block {
        background: #f1f5f9 !important;
        color: #1e293b !important;
        border: 1px solid #cbd5e1 !important;
    }

    body.light-mode .sub-duration-text,
    html.light-mode .sub-duration-text {
        color: #475569 !important;
    }

    .panel-filter-bar .btn,
    .panel-filter-bar a.btn {
        font-weight: 700 !important;
    }

    body.light-mode .panel-filter-bar .btn,
    html.light-mode .panel-filter-bar .btn,
    body.light-mode .panel-filter-bar a.btn,
    html.light-mode .panel-filter-bar a.btn {
        background: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        font-weight: 700 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04) !important;
    }

    body.light-mode .panel-filter-bar .btn:hover,
    html.light-mode .panel-filter-bar .btn:hover,
    body.light-mode .panel-filter-bar a.btn:hover,
    html.light-mode .panel-filter-bar a.btn:hover {
        background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
        color: #051013 !important;
        border: 1px solid rgba(82, 234, 210, 0.8) !important;
        font-weight: 700 !important;
    }

    body.light-mode .panel-filter-bar .btn.active,
    html.light-mode .panel-filter-bar .btn.active,
    body.light-mode .panel-filter-bar a.btn.active,
    html.light-mode .panel-filter-bar a.btn.active {
        background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
        color: #051013 !important;
        border: 1px solid rgba(82, 234, 210, 0.8) !important;
        font-weight: 700 !important;
    }
    </style>
@endsection

@section('js')
<script>
    function showInvoice(url) {
        $('#invoiceIframe').attr('src', url);
        $('#invoiceModal').css('display', 'flex');
    }

    function closeInvoiceModal() {
        $('#invoiceModal').css('display', 'none');
        $('#invoiceIframe').attr('src', '');
    }

    function clearSubErrors() {
        $('#subscriptionForm .sub-form-input').css('border-color', 'rgba(255,255,255,0.15)');
        $('#subscriptionForm .invalid-feedback-text').text('').hide();
    }

    function showSubError(field, message) {
        $('#sub_' + field).css('border-color', '#fb7185');
        $('#sub_err_' + field).text(message).show();
    }

    function openAddSubscriptionModal() {
        clearSubErrors();
        $('#subscriptionForm')[0].reset();
        $('#subscription_id').val('');
        $('#_method').val('POST');
        $('#subscriptionModalTitle').text('Assign New Subscription');

        // Set default dates
        var today = new Date().toISOString().split('T')[0];
        var nextMonth = new Date(Date.now() + 30*24*60*60*1000).toISOString().split('T')[0];
        $('#sub_starts_at').val(today);
        $('#sub_ends_at').val(nextMonth);

        $('#subscriptionModal').css('display', 'flex');
    }

    function closeSubscriptionModal() {
        clearSubErrors();
        $('#subscriptionModal').css('display', 'none');
    }

    $(document).ready(function () {
        // Function to fetch subscriptions via jQuery AJAX
        function fetchSubscriptions(url, pushState) {
            if (pushState === undefined) pushState = true;

            $('#subscriptionTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.success) {
                        $('#subscriptionTableContainer').html(data.html);
                        $('#subscriptionStatusHeading').text(data.heading_status ? ' ' + data.heading_status : '');

                        $('.panel-filter-bar a').each(function () {
                            var btnFilter = $(this).attr('data-filter');
                            if ((!data.status && !btnFilter) || (data.status === btnFilter)) {
                                $(this).addClass('active');
                            } else {
                                $(this).removeClass('active');
                            }
                        });

                        if (pushState) {
                            history.pushState({ url: url }, '', url);
                        }
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to fetch subscription data.', 'error');
                },
                complete: function () {
                    $('#subscriptionTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        }

        // 1. Filter Tabs Click via jQuery AJAX
        $(document).on('click', '.panel-filter-bar a', function (e) {
            e.preventDefault();
            fetchSubscriptions($(this).attr('href'));
        });

        // 2. Pagination Links Click via jQuery AJAX
        $(document).on('click', '#subscriptionTableContainer .pagination a', function (e) {
            e.preventDefault();
            fetchSubscriptions($(this).attr('href'));
        });

        // 3. Browser History Navigation
        window.addEventListener('popstate', function (e) {
            if (e.state && e.state.url) {
                fetchSubscriptions(e.state.url, false);
            } else {
                fetchSubscriptions(window.location.href, false);
            }
        });

        // 4. Form Submit for Add / Edit Subscription via jQuery AJAX with Validation
        $('#subscriptionForm').on('submit', function (e) {
            e.preventDefault();
            clearSubErrors();

            var hasError = false;
            var vendorVal = $.trim($('#sub_vendor_id').val());
            var packageVal = $.trim($('#sub_package_id').val());
            var startsVal = $.trim($('#sub_starts_at').val());
            var endsVal = $.trim($('#sub_ends_at').val());

            if (!vendorVal) {
                showSubError('vendor_id', 'Vendor is required.');
                hasError = true;
            }
            if (!packageVal) {
                showSubError('package_id', 'Package / Plan is required.');
                hasError = true;
            }
            if (!startsVal) {
                showSubError('starts_at', 'Start Date is required.');
                hasError = true;
            }
            if (!endsVal) {
                showSubError('ends_at', 'End Date is required.');
                hasError = true;
            } else if (startsVal && endsVal && endsVal < startsVal) {
                showSubError('ends_at', 'End Date cannot be earlier than Start Date.');
                hasError = true;
            }

            if (hasError) return;

            var subId = $('#subscription_id').val();
            var url = subId ? "{{ url('admin/subscriptions') }}/" + subId : "{{ route('admin.subscriptions.store') }}";
            var $btn = $('#subSubmitBtn');
            var origText = $btn.text();

            $btn.prop('disabled', true).text('Saving...');

            var formData = new FormData(this);

            $.ajax({
                url: url,
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
                        closeSubscriptionModal();
                        fetchSubscriptions(window.location.href, false);
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, msgs) {
                            showSubError(key, msgs[0]);
                        });
                        var firstErr = Object.values(errors)[0][0];
                        Swal.fire('Validation Error', firstErr, 'warning');
                    } else {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong.';
                        Swal.fire('Error!', msg, 'error');
                    }
                },
                complete: function () {
                    $btn.prop('disabled', false).text(origText);
                }
            });
        });

        // 5. Edit Button Click via jQuery
        $(document).on('click', '.edit-subscription-btn', function () {
            clearSubErrors();
            var d = $(this).data();

            $('#subscription_id').val(d.id);
            $('#_method').val('PUT');
            $('#subscriptionModalTitle').text('Edit Subscription');

            $('#sub_vendor_id').val(d.vendor_id || '');
            $('#sub_package_id').val(d.package_id || '');
            $('#sub_starts_at').val(d.starts_at || '');
            $('#sub_ends_at').val(d.ends_at || '');
            $('#sub_amount_paid').val(d.amount_paid || '');
            $('#sub_status').val(d.status || 'active');
            $('#sub_payment_id').val(d.payment_id || '');

            $('#subscriptionModal').css('display', 'flex');
        });

        // 6. Delete Button Click via jQuery AJAX
        $(document).on('click', '.delete-subscription-btn', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            var $row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the subscription record permanently!",
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
                            } else {
                                Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete subscription.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
