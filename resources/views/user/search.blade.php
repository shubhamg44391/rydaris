@extends('user.layouts.app')

@section('main-content')
<div class="admin-panel" style="padding: 20px;">
    
    
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
        <div>
            <h2 style="font-weight: 700; color: #f8fafc; margin-bottom: 5px;">Discover Vendors</h2>
            <p class="text-muted" style="margin: 0;">Find the perfect vehicles from our trusted partners.</p>
        </div>
        <form action="{{ route('user.vendors.search') }}" method="GET" class="d-flex" style="max-width: 400px; width: 100%; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control-custom" placeholder="Search by company or vendor name..." style="padding-right: 45px; width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); color: white; border-radius: 8px; padding: 10px 15px;">
            <button type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--brand);">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
        </form>
    </div>

    
    <div class="row g-4">
        @forelse($vendors as $vendor)
            <div class="col-md-6 col-lg-4">
                <div class="vendor-card p-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 12px; height: 100%; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="vendor-avatar" style="width: 50px; height: 50px; background: rgba(82, 234, 210, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand); font-weight: bold; font-size: 1.2rem; overflow: hidden;">
                            @if($vendor->company_logo)
                                <img src="{{ asset('storage/' . $vendor->company_logo) }}" alt="{{ $vendor->company_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr($vendor->company_name ?? $vendor->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h5 style="margin: 0; color: #f8fafc; font-weight: 600;">{{ $vendor->company_name ?? $vendor->name }}</h5>
                            <span class="badge" style="background: rgba(82, 234, 210, 0.2); color: var(--brand); font-size: 0.75rem; font-weight: normal;">Trusted Vendor</span>
                        </div>
                    </div>
                    
                    <div class="mb-4 text-muted" style="font-size: 0.9rem; flex-grow: 1;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            {{ $vendor->country_code }} {{ $vendor->contact_number }}
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            {{ $vendor->vehicles->count() }} Available Vehicles
                        </div>
                    </div>

                    <a href="{{ route('user.vendors.show', $vendor->id) }}" class="btn btn-outline-primary w-100" style="border-color: rgba(82, 234, 210, 0.3); color: var(--brand);">View Fleet</a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted mb-3">
                    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <h5>No vendors found.</h5>
                <p class="text-muted">Try adjusting your search criteria.</p>
                @if(request('search'))
                    <a href="{{ route('user.vendors.search') }}" class="btn btn-primary mt-2">Clear Search</a>
                @endif
            </div>
        @endforelse
    </div>

</div>

<style>
    .vendor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(82, 234, 210, 0.1);
        border-color: rgba(82, 234, 210, 0.3) !important;
    }
    .form-control-custom:focus {
        border-color: var(--brand) !important;
        box-shadow: 0 0 0 2px rgba(82, 234, 210, 0.2) !important;
        outline: none;
    }
</style>
@endsection
