<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorPage;

class PageController extends Controller
{
    /**
     * Show Terms & Conditions form — load existing record if any.
     */
    public function index()
    {
        // Each vendor has at most ONE Terms & Conditions record
        $page = VendorPage::where('vendor_id', auth()->id())->first();

        return view('vendor.pages.index', compact('page'));
    }

    /**
     * Save (create or update) the Terms & Conditions.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'title.required'       => 'Title is required.',
            'description.required' => 'Description / Content is required.',
        ]);

        // Update existing or create new — one record per vendor
        VendorPage::updateOrCreate(
            ['vendor_id' => auth()->id()],
            [
                'title'       => $request->title,
                'description' => $request->description,
            ]
        );

        return redirect()->route('vendor.pages.index')
            ->with('success', 'Terms & Conditions saved successfully!');
    }

    // ── These are kept for route compatibility but redirect to index ──
    public function edit($id)
    {
        return redirect()->route('vendor.pages.index');
    }

    public function update(Request $request, $id)
    {
        return $this->store($request);
    }

    public function destroy($id)
    {
        VendorPage::where('vendor_id', auth()->id())->delete();
        return redirect()->route('vendor.pages.index')
            ->with('success', 'Terms & Conditions cleared successfully!');
    }
}
