<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoMetadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SeoMetadataController extends Controller
{
    

    public function index()
    {
        $type = request('type', 'frontend');
        if (!in_array($type, ['frontend', 'vendor', 'user'], true)) {
            $type = 'frontend';
        }

        
        if ($type === 'vendor') {
            
            $groupOrder = [
                'Dashboard', 'Booking', 'Vehicles', 'Locations',
                'Customers', 'Fleet Management', 'Extras',
                'Coupons', 'Support Ticket', 'Subscription',
                'Terms & Conditions', 'Settings',
            ];

            $all = SeoMetadata::where('portal_type', $type)->get();

            $grouped = $all->groupBy(function ($item) {
                
                $parts = explode(' - ', $item->page_name, 2);
                return trim($parts[0]);
            });

            
            $grouped = collect($groupOrder)
                ->mapWithKeys(fn($g) => [$g => $grouped->get($g, collect())])
                ->filter(fn($items) => $items->isNotEmpty());

            $metadatas = null; 
            return view('admin.seo.index', compact('metadatas', 'type', 'grouped'));
        }

        $grouped = null;
        $metadatas = SeoMetadata::where('portal_type', $type)
            ->orderBy('page_name', 'asc')
            ->paginate(20);

        return view('admin.seo.index', compact('metadatas', 'type', 'grouped'));
    }

    

    public function edit(SeoMetadata $seoMetadata)
    {
        return view('admin.seo.edit', compact('seoMetadata'));
    }

    

    public function update(Request $request, SeoMetadata $seoMetadata)
    {
        $request->validate([
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string'],
            'keyword' => ['nullable', 'string'],
        ]);

        $seoMetadata->update([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'keyword' => $request->keyword,
        ]);

        
        Cache::forget('seo_' . md5($seoMetadata->url_path));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'SEO metadata updated successfully.',
                'redirect_url' => route('admin.seo-settings.index', ['type' => $seoMetadata->portal_type])
            ]);
        }

        return redirect()->route('admin.seo-settings.index', ['type' => $seoMetadata->portal_type])->with('success', 'SEO metadata updated successfully.');
    }
}
