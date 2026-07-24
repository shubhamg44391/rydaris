
@php
    $pageTitle = $pageTitle ?? 'List';
    $pageSubtitle = $pageSubtitle ?? null;
    $actionLabel = $actionLabel ?? null;
    $actionRoute = $actionRoute ?? null;
    $actionOnclick = $actionOnclick ?? null;
    $columns = $columns ?? [];
    $rows = $rows ?? $items ?? [];
    $addFields = $addFields ?? null;
    $modalId = 'demoList_' . \Illuminate\Support\Str::random(6);
@endphp

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">{{ $pageTitle }}</h1>
        @if($pageSubtitle)
            <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">{{ $pageSubtitle }}</p>
        @endif
    </div>
    <div style="display: flex; align-items: center; gap: 12px;">
        @if($actionLabel)
            @if($actionRoute)
                <a href="{{ $actionRoute }}" style="background: var(--brand); color: var(--bg-1); border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-plus"></i> {{ $actionLabel }}
                </a>
            @else
                <button type="button" onclick="{{ $actionOnclick ?? "demoOpenAdd('{$modalId}')" }}" style="background: var(--brand); color: var(--bg-1); border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-plus"></i> {{ $actionLabel }}
                </button>
            @endif
        @endif
    </div>
</div>

<div class="glass-card">
    <div class="demo-table-wrap" style="margin-top: 0;">
        <table class="demo-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    @foreach($columns as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $i => $row)
                    @php
                        $viewPairs = [];
                        $vals = array_values($row);
                        foreach ($columns as $ci => $colLabel) {
                            $viewPairs[$colLabel] = $vals[$ci] ?? '';
                        }
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        @foreach($row as $key => $cell)
                            @if($key === 'status')
                                @php
                                    $active = in_array(strtolower((string) $cell), ['active', 'confirmed', 'ongoing', 'available', 'paid', 'accepted', 'resolved'], true);
                                @endphp
                                <td><span class="badge-status {{ $active ? 'badge-active' : 'badge-inactive' }}">{{ $cell }}</span></td>
                            @else
                                <td>{{ $cell }}</td>
                            @endif
                        @endforeach
                        <td style="white-space: nowrap;">
                            <div style="display: inline-flex; align-items: center; gap: 8px;">
                                <button type="button"
                                    data-view='@json($viewPairs)'
                                    onclick="demoOpenView(this, '{{ $pageTitle }}')"
                                    title="Edit / View Details"
                                    class="btn-action-edit"
                                    style="width: 32px; height: 32px; border-radius: 8px; background: rgba(128, 167, 255, 0.08); border: 1px solid rgba(128, 167, 255, 0.25); color: #80a7ff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; outline: none;"
                                    onmouseover="this.style.background='rgba(128, 167, 255, 0.22)';this.style.transform='translateY(-1px)';"
                                    onmouseout="this.style.background='rgba(128, 167, 255, 0.08)';this.style.transform='translateY(0)';"
                                >
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>

                                <button type="button"
                                    onclick="if(confirm('Are you sure you want to delete this item?')) Swal.fire({title:'Deleted!', text:'Record removed successfully.', icon:'success', timer:2000, showConfirmButton:false});"
                                    title="Delete"
                                    class="btn-action-delete"
                                    style="width: 32px; height: 32px; border-radius: 8px; background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); color: #ef4444; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; outline: none;"
                                    onmouseover="this.style.background='rgba(239, 68, 68, 0.22)';this.style.transform='translateY(-1px)';"
                                    onmouseout="this.style.background='rgba(239, 68, 68, 0.08)';this.style.transform='translateY(0)';"
                                >
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 2 }}" style="text-align: center; color: var(--text-muted); padding: 40px;">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="table-scroll-hint" style="display: none; align-items: center; gap: 6px; color: var(--brand, #52ead2); font-size: 0.75rem; font-weight: 700; margin-top: 10px; justify-content: flex-end; opacity: 0.85;">
        <span>Swipe right to view more</span> <i class="fa-solid fa-angles-right" style="animation: swipeRight 1.5s infinite ease-in-out;"></i>
    </div>
</div>

<div id="{{ $modalId }}" class="xp-overlay">
    <div class="xp-modal" style="{{ $addFields ? 'width: 640px;' : '' }}">
        <div class="xp-modal-head">
            <span class="xp-modal-title">{{ $actionLabel ?? ('Add ' . \Illuminate\Support\Str::singular($pageTitle)) }}</span>
            <button class="xp-modal-x" onclick="xpClose('{{ $modalId }}')">&times;</button>
        </div>
        <form onsubmit="demoAddSubmit(event, '{{ $modalId }}')">
            <div class="xp-modal-body">
                @if($addFields)
                    <div class="xp-modal-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        @foreach($addFields as $f)
                            @php $t = $f['type'] ?? 'text'; @endphp
                            <div class="xp-fg" style="margin-bottom:0; {{ ($f['full'] ?? false) ? 'grid-column:1 / -1;' : '' }}">
                                <label>{{ $f['label'] }} @if($f['required'] ?? false)<span style="color:#ff4d4d;">*</span>@endif</label>
                                @if($t === 'textarea')
                                    <textarea rows="3" placeholder="{{ $f['placeholder'] ?? '' }}" {{ ($f['required'] ?? false) ? 'required' : '' }}
                                        style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; font-size:.88rem; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box; font-family:inherit; resize:vertical;"></textarea>
                                @elseif($t === 'select')
                                    <select {{ ($f['required'] ?? false) ? 'required' : '' }}>
                                        @foreach($f['options'] ?? [] as $opt)
                                            <option>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="{{ $t }}" placeholder="{{ $f['placeholder'] ?? '' }}" {{ ($f['required'] ?? false) ? 'required' : '' }}>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    @foreach($columns as $col)
                        @php $isStatus = strtolower($col) === 'status'; @endphp
                        <div class="xp-fg">
                            <label>{{ $col }}</label>
                            @if($isStatus)
                                <select>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                            @else
                                <input type="text" placeholder="Enter {{ strtolower($col) }}">
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="xp-modal-foot">
                <button type="button" class="xp-btn-cancel" onclick="xpClose('{{ $modalId }}')">Cancel</button>
                <button type="submit" class="xp-btn-save">Save</button>
            </div>
        </form>
    </div>
</div>

@once

<div id="demoViewModal" class="xp-overlay">
    <div class="xp-modal">
        <div class="xp-modal-head">
            <span class="xp-modal-title" id="demoViewTitle">Details</span>
            <button class="xp-modal-x" onclick="xpClose('demoViewModal')">&times;</button>
        </div>
        <div class="xp-modal-body" id="demoViewBody"></div>
        <div class="xp-modal-foot">
            <button type="button" class="xp-btn-cancel" onclick="xpClose('demoViewModal')">Close</button>
        </div>
    </div>
</div>

<script>
    function demoOpenAdd(id) { xpOpen(id); }

    function demoAddSubmit(e, id) {
        e.preventDefault();
        xpClose(id);
        Swal.fire({
            icon: 'success',
            title: 'Saved successfully!',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1800
        });
    }

    function demoOpenView(btn, title) {
        const data = JSON.parse(btn.getAttribute('data-view') || '{}');
        document.getElementById('demoViewTitle').innerText = title + ' — Details';
        let html = '';
        Object.keys(data).forEach(k => {
            html += `<div class="xp-fg">
                <label>${k}</label>
                <div style="padding:12px; border:1px solid rgba(255,255,255,0.12); border-radius:8px; background:rgba(255,255,255,0.03); font-size:.88rem; color:#f8fafc; word-break:break-word;">${data[k] !== '' && data[k] !== null ? data[k] : '—'}</div>
            </div>`;
        });
        document.getElementById('demoViewBody').innerHTML = html;
        xpOpen('demoViewModal');
    }

    
    function demoOnlyAction() {}
</script>
@endonce
