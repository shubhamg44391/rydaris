
@php
    $pageTitle = $pageTitle ?? 'Add';
    $backRoute = $backRoute ?? route('demo.dashboard');
    $fields = $fields ?? [];
    $cols = $cols ?? null;
    $gridCols = $cols ? "repeat({$cols}, minmax(0, 1fr))" : 'repeat(auto-fill, minmax(230px, 1fr))';
@endphp

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">{{ $pageTitle }}</h1>
        <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">Fill in the details below and save.</p>
    </div>
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ $backRoute }}" class="xp-btn-cancel">← Back to list</a>
    </div>
</div>

<div class="glass-card">
    <form onsubmit="demoFormSubmit(event, '{{ $backRoute }}')">
        <div style="display: grid; grid-template-columns: {{ $gridCols }}; gap: 18px;">
            @foreach($fields as $field)
                <div class="xp-fg" style="{{ ($field['full'] ?? false) ? 'grid-column: 1 / -1;' : '' }} margin-bottom: 0;">
                    <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">
                        {{ $field['label'] }} @if($field['required'] ?? false)<span style="color:#ff4d4d;">*</span>@endif
                    </label>
                    @if(($field['type'] ?? 'text') === 'textarea')
                        <textarea name="{{ $field['name'] }}" rows="4" placeholder="{{ $field['placeholder'] ?? '' }}" {{ ($field['required'] ?? false) ? 'required' : '' }}
                            style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; font-size:.88rem; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box; font-family:inherit; resize:vertical;"></textarea>
                    @elseif(($field['type'] ?? 'text') === 'select')
                        <select name="{{ $field['name'] }}" {{ ($field['required'] ?? false) ? 'required' : '' }}
                            style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; font-size:.88rem; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
                            @foreach($field['options'] ?? [] as $opt)
                                <option value="{{ $opt }}" style="background:#0b1020; color:#f8fafc;">{{ $opt }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" {{ ($field['required'] ?? false) ? 'required' : '' }}
                            style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; font-size:.88rem; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
                    @endif
                </div>
            @endforeach
        </div>
        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px; padding-top:18px; border-top:1px solid rgba(255,255,255,0.05);">
            <a href="{{ $backRoute }}" class="xp-btn-cancel">Cancel</a>
            <button type="submit" class="xp-btn-save">Save</button>
        </div>
    </form>
</div>

<style>
@media (max-width: 700px) {
    form > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
}
</style>

<script>
function demoFormSubmit(e, backRoute) {
    e.preventDefault();
    window.location.href = backRoute + (backRoute.indexOf('?') === -1 ? '?' : '&') + 'saved=1';
}
</script>
