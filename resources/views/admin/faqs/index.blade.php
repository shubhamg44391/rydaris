@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>
                    FAQ Management 
                    <span id="faqHeadingCategory">
                        @if($category === 'product_basics')
                            - Product Basics
                        @elseif($category === 'onboarding')
                            - Onboarding
                        @elseif($category === 'reporting')
                            - Reporting
                        @endif
                    </span>
                </h2>
            </div>
            <div>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="openAddFaqModal()" style="font-weight: 800 !important;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add FAQ
                </button>
            </div>
        </div>

        
        <div class="panel-filter-bar" style="margin-bottom: 20px;">
            <a href="{{ route('admin.faqs.index') }}" data-category="" class="btn btn-sm {{ !$category ? 'active' : '' }}">
                All Categories
            </a>
            <a href="{{ route('admin.faqs.index', ['category' => 'product_basics']) }}" data-category="product_basics" class="btn btn-sm {{ $category === 'product_basics' ? 'active' : '' }}">
                Product Basics
            </a>
            <a href="{{ route('admin.faqs.index', ['category' => 'onboarding']) }}" data-category="onboarding" class="btn btn-sm {{ $category === 'onboarding' ? 'active' : '' }}">
                Onboarding
            </a>
            <a href="{{ route('admin.faqs.index', ['category' => 'reporting']) }}" data-category="reporting" class="btn btn-sm {{ $category === 'reporting' ? 'active' : '' }}">
                Reporting
            </a>
        </div>

        <div id="faqTableContainer">
            @include('admin.faqs.partials.table')
        </div>
    </div>

    
    <div id="faqModal" class="custom-modal" style="display: none; position: fixed; inset: 0; z-index: 99999; padding: 16px; box-sizing: border-box; align-items: center; justify-content: center; background: rgba(5, 7, 17, 0.85); backdrop-filter: blur(8px);" onclick="if(event.target === this) closeFaqModal();">
        <div class="faq-modal-card" style="position: relative; z-index: 1; width: 100%; max-width: 600px; background: #0b1020; border-radius: 12px; overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,0.7); border: 1px solid rgba(82, 234, 210, 0.25);">
            <div class="faq-modal-header" style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid rgba(82, 234, 210, 0.2); background: #070a14;">
                <h3 id="faqModalTitle" class="faq-modal-title" style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #ffffff;">Add New FAQ</h3>
                <button type="button" class="faq-modal-close" onclick="closeFaqModal()" style="background: none; border: none; font-size: 24px; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <form id="faqForm" style="padding: 24px;">
                @csrf
                <input type="hidden" id="faq_id" name="faq_id">
                <input type="hidden" id="faq_method" name="_method" value="POST">

                <div class="mb-3">
                    <label class="faq-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">CATEGORY <span style="color: #fb7185;">*</span></label>
                    <select id="faq_category" name="category" class="faq-form-input" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                        <option value="">Select Category</option>
                        <option value="product_basics">Product Basics</option>
                        <option value="onboarding">Onboarding</option>
                        <option value="reporting">Reporting</option>
                    </select>
                    <div id="faq_err_category" class="invalid-feedback-text" style="color: #fb7185; font-size: 0.8rem; margin-top: 4px; font-weight: 600; display: none;"></div>
                </div>

                <div class="mb-3">
                    <label class="faq-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">QUESTION / TITLE <span style="color: #fb7185;">*</span></label>
                    <input type="text" id="faq_title" name="title" class="faq-form-input" placeholder="e.g. How do I upgrade my plan?" style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none;">
                    <div id="faq_err_title" class="invalid-feedback-text" style="color: #fb7185; font-size: 0.8rem; margin-top: 4px; font-weight: 600; display: none;"></div>
                </div>

                <div class="mb-4">
                    <label class="faq-form-label" style="display: block; margin-bottom: 6px; color: #f8fafc; font-size: 0.85rem; font-weight: 600;">ANSWER / DESCRIPTION <span style="color: #fb7185;">*</span></label>
                    <textarea id="faq_description" name="description" rows="4" class="faq-form-input" placeholder="Enter detailed answer..." style="width: 100%; padding: 10px 12px; background: #050711; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #ffffff; font-size: 0.9rem; outline: none; resize: vertical;"></textarea>
                    <div id="faq_err_description" class="invalid-feedback-text" style="color: #fb7185; font-size: 0.8rem; margin-top: 4px; font-weight: 600; display: none;"></div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 16px;">
                    <button type="button" class="faq-modal-cancel-btn" onclick="closeFaqModal()" style="background: rgba(255,255,255,0.1); border: none; color: #ffffff; padding: 8px 18px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; font-weight: 700;">Cancel</button>
                    <button type="submit" id="faqSubmitBtn" style="background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); border: none; color: #051013; padding: 8px 22px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; font-weight: 700;">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>

    <style>
    /* Light Mode Overrides for FAQ Page & Modal */
    body.light-mode .faq-modal-card,
    html.light-mode .faq-modal-card {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
    }

    body.light-mode .faq-modal-header,
    html.light-mode .faq-modal-header {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    body.light-mode .faq-modal-title,
    html.light-mode .faq-modal-title {
        color: #0f172a !important;
    }

    body.light-mode .faq-modal-close,
    html.light-mode .faq-modal-close {
        color: #64748b !important;
    }

    body.light-mode .faq-form-label,
    html.light-mode .faq-form-label {
        color: #1e293b !important;
    }

    body.light-mode .faq-form-input,
    html.light-mode .faq-form-input {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
    }

    body.light-mode .faq-form-input option,
    html.light-mode .faq-form-input option {
        background: #ffffff !important;
        color: #0f172a !important;
    }

    body.light-mode .faq-modal-cancel-btn,
    html.light-mode .faq-modal-cancel-btn {
        background: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
    }

    body.light-mode .faq-title-text,
    html.light-mode .faq-title-text {
        color: #0f172a !important;
    }

    body.light-mode .faq-desc-text,
    html.light-mode .faq-desc-text {
        color: #475569 !important;
    }

    body.light-mode .panel-filter-bar .btn,
    html.light-mode .panel-filter-bar .btn,
    body.light-mode .panel-filter-bar a.btn,
    html.light-mode .panel-filter-bar a.btn {
        background: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        font-weight: 700 !important;
    }

    body.light-mode .panel-filter-bar .btn:hover,
    html.light-mode .panel-filter-bar .btn:hover,
    body.light-mode .panel-filter-bar a.btn:hover,
    html.light-mode .panel-filter-bar a.btn:hover,
    .panel-filter-bar .btn:hover,
    .panel-filter-bar a.btn:hover {
        background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
        color: #051013 !important;
        border: 1px solid rgba(82, 234, 210, 0.8) !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 14px rgba(82, 234, 210, 0.35) !important;
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
    function clearFaqErrors() {
        $('#faqForm .faq-form-input').css('border-color', 'rgba(255,255,255,0.15)');
        $('#faqForm .invalid-feedback-text').text('').hide();
    }

    function showFaqError(field, message) {
        $('#faq_' + field).css('border-color', '#fb7185');
        $('#faq_err_' + field).text(message).show();
    }

    function openAddFaqModal() {
        clearFaqErrors();
        $('#faqForm')[0].reset();
        $('#faq_id').val('');
        $('#faq_method').val('POST');
        $('#faqModalTitle').text('Add New FAQ');

        var activeCategory = '{{ $category ?? "" }}';
        if (activeCategory) {
            $('#faq_category').val(activeCategory);
        }

        $('#faqModal').css('display', 'flex');
    }

    function closeFaqModal() {
        clearFaqErrors();
        $('#faqModal').css('display', 'none');
    }

    $(document).ready(function () {
        // Function to fetch FAQs via jQuery AJAX
        function fetchFaqs(url, pushState) {
            if (pushState === undefined) pushState = true;

            $('#faqTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.success) {
                        $('#faqTableContainer').html(data.html);
                        $('#faqHeadingCategory').text(data.heading_category ? ' ' + data.heading_category : '');

                        $('.panel-filter-bar a').each(function () {
                            var btnCategory = $(this).attr('data-category');
                            if ((!data.category && !btnCategory) || (data.category === btnCategory)) {
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
                    Swal.fire('Error!', 'Failed to fetch FAQ data.', 'error');
                },
                complete: function () {
                    $('#faqTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        }

        // 1. Filter Tabs Click via jQuery AJAX
        $(document).on('click', '.panel-filter-bar a', function (e) {
            e.preventDefault();
            fetchFaqs($(this).attr('href'));
        });

        // 2. Pagination Links Click via jQuery AJAX
        $(document).on('click', '#faqTableContainer .pagination a', function (e) {
            e.preventDefault();
            fetchFaqs($(this).attr('href'));
        });

        // 3. Browser History Navigation
        window.addEventListener('popstate', function (e) {
            if (e.state && e.state.url) {
                fetchFaqs(e.state.url, false);
            } else {
                fetchFaqs(window.location.href, false);
            }
        });

        // 4. Form Submit for Add / Edit FAQ via jQuery AJAX with Validation
        $('#faqForm').on('submit', function (e) {
            e.preventDefault();
            clearFaqErrors();

            var hasError = false;
            var catVal = $.trim($('#faq_category').val());
            var titleVal = $.trim($('#faq_title').val());
            var descVal = $.trim($('#faq_description').val());

            if (!catVal) {
                showFaqError('category', 'Category is required.');
                hasError = true;
            }
            if (!titleVal) {
                showFaqError('title', 'Question / Title is required.');
                hasError = true;
            }
            if (!descVal) {
                showFaqError('description', 'Answer / Description is required.');
                hasError = true;
            }

            if (hasError) return;

            var faqId = $('#faq_id').val();
            var url = faqId ? "{{ url('admin/faqs') }}/" + faqId : "{{ route('admin.faqs.store') }}";
            var $btn = $('#faqSubmitBtn');
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
                        closeFaqModal();
                        fetchFaqs(window.location.href, false);
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, msgs) {
                            showFaqError(key, msgs[0]);
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
        $(document).on('click', '.edit-faq-btn', function () {
            clearFaqErrors();
            var d = $(this).data();

            $('#faq_id').val(d.id);
            $('#faq_method').val('PUT');
            $('#faqModalTitle').text('Edit FAQ');

            $('#faq_category').val(d.category || '');
            $('#faq_title').val(d.title || '');
            $('#faq_description').val(d.description || '');

            $('#faqModal').css('display', 'flex');
        });

        // 6. Delete Button Click via jQuery AJAX
        $(document).on('click', '.delete-faq-btn', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            var $row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the FAQ question permanently!",
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
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete FAQ.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
