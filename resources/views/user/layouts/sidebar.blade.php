<nav class="admin-nav">
    
     @if(auth()->user()->hasMenuAccess('vehicles'))
        @if(auth()->check() && auth()->user()->vendor_id)
            <a class="{{ Request::is('user/vendor/*') ? 'active' : '' }}" href="{{ route('user.vendors.show', auth()->user()->vendor_id) }}#vehicles">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg> Search Vehicle
            </a>
        @else
            <a class="{{ request()->has('search') ? 'active' : '' }}" href="{{ route('user.dashboard') }}?search=" onclick="document.querySelector('input[name=search]').focus(); return false;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg> Search Vehicle
            </a>
        @endif
    @endif
    @if(auth()->user()->hasMenuAccess('booking'))
    <a class="{{ Request::is('user/bookings*') && !Request::is('user/bookings/*/edit') && !Request::is('user/bookings/*/checkin') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg> My Bookings
    </a>

    
    <a class="{{ Request::is('user/bookings/*/checkin') || Request::is('user/checkin') ? 'active' : '' }}" href="{{ route('user.checkin.redirect') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg> Check-in
    </a>

    
    <a class="{{ Request::is('user/bookings/*/payment-page') || Request::is('user/payment') ? 'active' : '' }}" href="{{ route('user.payment.redirect') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
            <line x1="1" y1="10" x2="23" y2="10"></line>
        </svg> Payments
    </a>
    @endif

    
    @if(auth()->user()->hasMenuAccess('support_ticket'))
    <a class="{{ Request::is('user/support-tickets*') ? 'active' : '' }}" href="{{ route('user.support-tickets.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg> Support Ticket
    </a>
    @endif

    @if(Request::is('user/bookings/*/edit') && auth()->user()->hasMenuAccess('booking'))
    <a class="active" href="javascript:void(0)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg> Modify Booking
    </a>
    @endif

   
</nav>
