@extends('admin.layouts.app')

@section('title', 'Manage Page SEO | Rydaris Admin')

@section('main-content')
    
    <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div>
            <h4 style="margin: 0; color: #fff; font-weight: 700; font-size: 1.4rem;">SEO Page Metadata</h4>
            <p style="margin: 4px 0 0; color: var(--muted); font-size: 0.85rem;">
                <a href="{{ route('dashboard') }}" style="color: var(--brand); text-decoration: none;">Dashboard</a> /
                SEO Settings
            </p>
        </div>
    </div>

    <div class="admin-panel" style="border: 1px solid var(--line); border-radius: var(--radius); background: var(--panel); padding: 20px;">
        <div class="panel-head" style="margin-bottom: 20px;">
            <h3 style="margin: 0; color: #fff; font-size: 1.15rem; font-weight: 600; text-transform: capitalize;">
                {{ $type === 'frontend' ? 'Frontend Website Pages' : ($type === 'vendor' ? 'Vendor Portal Pages' : 'User/Customer Portal Pages') }}
            </h3>
        </div>

        @if($type === 'vendor' && $grouped)

            
            @foreach($grouped as $groupName => $items)
                <div style="margin-bottom: 28px;">
                    
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid var(--line);">
                        <div style="width: 4px; height: 20px; background: linear-gradient(180deg, var(--brand-2), var(--brand)); border-radius: 2px; flex-shrink: 0;"></div>
                        <h5 style="margin: 0; color: var(--brand); font-size: 0.88rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;">{{ $groupName }}</h5>
                        <span style="font-size: 0.72rem; color: var(--muted); background: rgba(255,255,255,0.05); padding: 2px 8px; border-radius: 12px; border: 1px solid var(--line);">
                            {{ $items->count() }} {{ Str::plural('page', $items->count()) }}
                        </span>
                    </div>

                    
                    <div class="admin-table-wrap" style="overflow-x: auto;">
                        <table class="admin-table" style="margin-bottom: 0;">
                            <thead>
                                <tr>
                                    <th style="width: 180px;">Page</th>
                                    <th>Path (URL)</th>
                                    <th>Meta Title</th>
                                    <th>Keywords</th>
                                    <th style="width: 80px; text-align: center;">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $data)
                                    @php
                                        $parts = explode(' - ', $data->page_name, 2);
                                        $subLabel = count($parts) > 1 ? $parts[1] : $parts[0];
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong style="color: #fff; font-size: 0.88rem;">{{ $subLabel }}</strong>
                                        </td>
                                        <td>
                                            <code style="color: var(--brand); font-family: monospace; font-size: 0.8rem;">{{ $data->url_path }}</code>
                                        </td>
                                        <td>
                                            <span style="color: #cbd5e1; font-size: 0.87rem;">{{ Str::limit($data->meta_title, 45) ?: '-' }}</span>
                                        </td>
                                        <td>
                                            <span style="color: #94a3b8; font-size: 0.82rem;">{{ Str::limit($data->keyword, 35) ?: '-' }}</span>
                                        </td>
                                        <td>
                                            <div style="display: flex; justify-content: center;">
                                                <a href="{{ route('admin.seo-settings.edit', $data->id) }}"
                                                   class="icon-button" title="Edit Meta Tags"
                                                   style="color: var(--brand); display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; background: rgba(255,255,255,0.03); transition: all 0.2s; text-decoration: none;">
                                                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;">
                                                        <path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

        @else

            
            <div class="panel-body admin-table-wrap" style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">S.No</th>
                            <th>Page Name</th>
                            <th>Path (URL)</th>
                            <th>Meta Title</th>
                            <th>Keywords</th>
                            <th style="width: 100px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startingNumber = ($metadatas->currentPage() - 1) * $metadatas->perPage() + 1;
                        @endphp
                        @forelse ($metadatas as $data)
                            <tr>
                                <td>{{ $startingNumber++ }}</td>
                                <td><strong style="color: #fff;">{{ $data->page_name }}</strong></td>
                                <td><code style="color: var(--brand); font-family: monospace; font-size: 0.85rem;">{{ $data->url_path }}</code></td>
                                <td><span style="color: #cbd5e1; font-size: 0.9rem;">{{ Str::limit($data->meta_title, 45) ?: '-' }}</span></td>
                                <td><span style="color: #94a3b8; font-size: 0.82rem;">{{ Str::limit($data->keyword, 35) ?: '-' }}</span></td>
                                <td>
                                    <div style="display: flex; justify-content: center;">
                                        <a href="{{ route('admin.seo-settings.edit', $data->id) }}"
                                           class="icon-button" title="Edit Meta Tags"
                                           style="color: var(--brand); display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; background: rgba(255,255,255,0.03); transition: all 0.2s; text-decoration: none;">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;">
                                                <path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color: #64748b; font-style: italic; text-align: center;">No metadata records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($metadatas->hasPages())
                <div style="padding-top: 15px; display: flex; justify-content: flex-end;">
                    {{ $metadatas->appends(['type' => $type])->links() }}
                </div>
            @endif

        @endif
    </div>
@endsection

