@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>
                    FAQ Management 
                    @if($category === 'product_basics')
                        - Product Basics
                    @elseif($category === 'onboarding')
                        - Onboarding
                    @elseif($category === 'reporting')
                        - Reporting
                    @endif
                </h2>
            </div>
            <div>
                <a href="{{ route('admin.faqs.create', ['category' => $category]) }}" class="admin-action" style="background: var(--brand); color: #061218; font-weight: bold; border-radius: var(--radius); padding: 8px 16px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add FAQ
                </a>
            </div>
        </div>

        <!-- Filter Tab Buttons -->
        <div class="panel-filter-bar">
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm {{ !$category ? 'active' : '' }}">
                All Categories
            </a>
            <a href="{{ route('admin.faqs.index', ['category' => 'product_basics']) }}" class="btn btn-sm {{ $category === 'product_basics' ? 'active' : '' }}">
                Product Basics
            </a>
            <a href="{{ route('admin.faqs.index', ['category' => 'onboarding']) }}" class="btn btn-sm {{ $category === 'onboarding' ? 'active' : '' }}">
                Onboarding
            </a>
            <a href="{{ route('admin.faqs.index', ['category' => 'reporting']) }}" class="btn btn-sm {{ $category === 'reporting' ? 'active' : '' }}">
                Reporting
            </a>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No</th>
                        <th style="width: 150px;">Category</th>
                        <th>Question / Title</th>
                        <th>Answer / Description</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($faqs->currentPage() - 1) * $faqs->perPage() + 1;
                    @endphp
                    @forelse ($faqs as $faq)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td >
                                @if($faq->category === 'product_basics')
                                    Product Basics
                                @elseif($faq->category === 'onboarding')
                                    Onboarding
                                @elseif($faq->category === 'reporting')
                                    Reporting
                                @else
                                    {{ ucwords(str_replace('_', ' ', $faq->category)) }}
                                @endif
                            </td>
                            <td>
                                {{ $faq->title }}
                            </td>
                            <td>
                                <div >
                                    {{ $faq->description }}
                                </div>
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="icon-button" title="Edit">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4" style="color: #64748b; font-style: italic;">No FAQs found in this category.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Controls -->
        @if($faqs->hasPages())
            <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line);">
                <div class="text-muted small">
                    Showing {{ $faqs->firstItem() ?? 0 }} to {{ $faqs->lastItem() ?? 0 }} of {{ $faqs->total() }} results
                </div>
                <div>
                    {{ $faqs->appends(['category' => $category])->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the FAQ question permanently.",
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
