@extends('admin.layouts.app')

@section('title', $seo_title ?? 'Manage Global Features')

@section('main-content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    :root {
        --primary: #4f46e5;
        --primary-hover: #4338ca;
        --danger: #ef4444;
        --danger-hover: #dc2626;
        --surface: var(--bg-2);
        --text-main: var(--text);
        --text-muted: var(--muted-2, #94a3b8);
        --border-color: var(--line);
        --radius-lg: 12px;
        --radius-md: 8px;
    }

    .feature-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        margin-top: -8px;
    }

    .feature-table th {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        padding: 0 16px 8px;
        text-align: left;
        border-bottom: 2px solid var(--border-color);
    }

    .feature-row {
        background: var(--bg-2);
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }

    .feature-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .feature-row td {
        padding: 12px 16px;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }

    .feature-row td:first-child {
        border-left: 1px solid var(--border-color);
        border-top-left-radius: var(--radius-md);
        border-bottom-left-radius: var(--radius-md);
    }

    .feature-row td:last-child {
        border-right: 1px solid var(--border-color);
        border-top-right-radius: var(--radius-md);
        border-bottom-right-radius: var(--radius-md);
    }

    .feature-input {
        width: 100%;
        border: none;
        background: transparent;
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        font-weight: 500;
        padding: 8px 0;
        outline: none;
    }
    
    .feature-input::placeholder {
        color: var(--text);
        font-weight: 400;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        font-family: 'Inter', sans-serif;
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        padding: 8px;
        border-radius: 8px;
        width: 36px;
        height: 36px;
    }

    .btn-delete:hover {
        background: var(--danger);
        color: #ffffff;
    }

    .btn-add {
        background: var(--bg);
        color: var(--text-main);
        border: 1px dashed var(--line);
        width: 100%;
        padding: 12px;
        margin-top: 16px;
    }

    .btn-add:hover {
        background: var(--line);
        border-color: var(--line);
    }
</style>

<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.4rem; color: var(--text); margin: 0; font-family: 'Inter', sans-serif; font-weight: 700;">Manage Global Features</h2>
        </div>
    </div>
    <div class="panel-body">
        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); padding: 16px; border-radius: var(--radius-md); margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                <span style="font-weight: 500;">{{ session('success') }}</span>
            </div>
        @endif

        <form id="featuresForm" method="POST" action="{{ route('vendor.features.update') }}">
            @csrf
            
            <div style="background: var(--surface); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 24px; margin-top: 15px;">
                <table class="feature-table" id="featuresTable">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;"><i class="fas fa-hashtag"></i></th>
                            <th>Feature Title</th>
                            <th style="width: 80px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="featuresBody">
                        @php $rowIndex = 0; @endphp
                        @forelse($features as $feature)
                            <tr class="feature-row">
                                <td style="text-align: center; color: var(--text-muted); font-weight: 500;">
                                    <span class="row-num">{{ $rowIndex + 1 }}</span>
                                </td>
                                <td>
                                    <input type="text" name="features[{{ $rowIndex }}][title]" value="{{ $feature->title }}" class="feature-input" placeholder="e.g. Unlimited Kilometers" required>
                                    <input type="hidden" name="features[{{ $rowIndex }}][index_no]" value="{{ $feature->index_no > 0 ? $feature->index_no : ($rowIndex + 1) }}">
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" onclick="removeRow(this)" class="btn-action btn-delete" title="Delete Feature">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @php $rowIndex++; @endphp
                        @empty
                            <tr class="feature-row">
                                <td style="text-align: center; color: var(--text-muted); font-weight: 500;">
                                    <span class="row-num">1</span>
                                </td>
                                <td>
                                    <input type="text" name="features[0][title]" class="feature-input" placeholder="e.g. Unlimited Kilometers" required>
                                    <input type="hidden" name="features[0][index_no]" value="1">
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" onclick="removeRow(this)" class="btn-action btn-delete" title="Delete Feature">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @php $rowIndex++; @endphp
                        @endforelse
                    </tbody>
                </table>

                <button type="button" onclick="addFeatureRow()" class="btn-action btn-add">
                    <i class="fas fa-plus-circle me-1"></i> Add another feature
                </button>
            </div>

            <div class="d-flex align-items-center gap-3" style="display: flex; gap: 16px; align-items: center; margin-top: 24px;">
                <button type="submit" class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem; background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%); border: none; color: #051013; cursor: pointer;">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
let nextRowIndex = {{ isset($rowIndex) ? $rowIndex : 1 }};

function updateRowNumbers() {
    const rows = document.querySelectorAll('#featuresBody .feature-row');
    rows.forEach((row, index) => {
        row.querySelector('.row-num').textContent = index + 1;
        const hiddenInput = row.querySelector('input[type="hidden"]');
        if(hiddenInput) hiddenInput.value = index + 1;
    });
}

function removeRow(btn) {
    const tbody = document.getElementById('featuresBody');
    if(tbody.children.length > 1) {
        btn.closest('tr').remove();
        updateRowNumbers();
    } else {
        btn.closest('tr').querySelector('.feature-input').value = '';
    }
}

function addFeatureRow() {
    const tbody = document.getElementById('featuresBody');
    const tr = document.createElement('tr');
    tr.className = 'feature-row';
    const newNum = tbody.children.length + 1;

    tr.innerHTML = `
        <td style="text-align: center; color: var(--text-muted); font-weight: 500;">
            <span class="row-num">${newNum}</span>
        </td>
        <td>
            <input type="text" name="features[${nextRowIndex}][title]" class="feature-input" placeholder="e.g. New Feature" required>
            <input type="hidden" name="features[${nextRowIndex}][index_no]" value="${newNum}">
        </td>
        <td style="text-align: center;">
            <button type="button" onclick="removeRow(this)" class="btn-action btn-delete" title="Delete Feature">
                <i class="fas fa-trash-alt"></i>
            </button>
        </td>
    `;
    tbody.appendChild(tr);
    nextRowIndex++;
    updateRowNumbers();
    
    // Focus the new input
    tr.querySelector('.feature-input').focus();
}
</script>
@endsection
