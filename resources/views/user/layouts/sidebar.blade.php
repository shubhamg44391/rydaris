<nav class="admin-nav">
    <a class="{{ Request::is('user/dashboard*') && !request()->has('search') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
        <svg viewBox="0 0 24 24"><path d="M3 3h7v7H3Z"/><path d="M14 3h7v7h-7Z"/><path d="M14 14h7v7h-7Z"/><path d="M3 14h7v7H3Z"/></svg> Dashboard
    </a>
    
    @if(auth()->check() && auth()->user()->vendor_id)
        <a class="{{ Request::is('user/vendor/*') ? 'active' : '' }}" href="{{ route('user.vendors.show', auth()->user()->vendor_id) }}">
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
</nav>
