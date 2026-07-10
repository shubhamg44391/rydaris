@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2>Coupons</h2>
        </div>
        <div>
            @if(Auth::user()->canAddCoupon())
                <a href="{{ route('vendor.coupons.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Coupon
                </a>
            @else
                <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 8px 12px; font-size: 0.85rem;">Limit Reached</span>
            @endif
        </div>
    </div>

    <div class="panel-body admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Discount</th>
                    <th>Valid To</th>
                    <th>Usage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    <tr>
                        <td style="font-weight: 700; color: #fff;">{{ $coupon->code }}</td>
                        <td>{{ ucfirst($coupon->type) }}</td>
                        <td>
                            @if($coupon->type === 'percentage')
                                {{ $coupon->discount }}%
                            @else
                                ₹{{ number_format($coupon->discount, 2) }}
                            @endif
                        </td>
                        <td>
                            {{ $coupon->valid_to ? \Carbon\Carbon::parse($coupon->valid_to)->format('d M Y') : 'No Expiry' }}
                        </td>
                        <td>
                            {{ $coupon->used_count }} / {{ $coupon->availability_count ?? '∞' }}
                        </td>
                        <td>
                            <div class="table-actions" style="display: flex; gap: 8px;">
                                <a href="{{ route('vendor.coupons.edit', $coupon->id) }}" class="icon-button" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius, 8px); color: #0f766e; background: #ffffff;">
                                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                </a>
                                <form action="{{ route('vendor.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this coupon?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-button delete-btn" title="Delete" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #fee2e2; border-radius: var(--radius, 8px); color: #ef4444; background: #ffffff; cursor: pointer; padding: 0;">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 30px; color: #94a3b8;">
                            No coupons found. Create your first coupon to offer discounts!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
