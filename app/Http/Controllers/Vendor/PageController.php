<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorPage;

class PageController extends Controller
{
    public function index()
    {
        $page = VendorPage::where('vendor_id', auth()->id())->first();

        return view('vendor.pages.index', compact('page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'required|string',
            'agreement_title'       => 'nullable|string|max:255',
            'agreement_description' => 'nullable|string',
        ], [
            'title.required'       => 'Terms title is required.',
            'description.required' => 'Terms content / description is required.',
        ]);

        $page = VendorPage::updateOrCreate(
            ['vendor_id' => auth()->id()],
            [
                'title'                 => $request->title,
                'description'           => $request->description,
                'agreement_title'       => $request->agreement_title,
                'agreement_description' => $request->agreement_description,
            ]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Terms & Conditions & Agreement saved successfully!',
                'last_updated' => $page->updated_at ? $page->updated_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A')
            ]);
        }

        return redirect()->route('vendor.pages.index')
            ->with('success', 'Terms & Conditions & Agreement saved successfully!');
    }

    public function edit($id)
    {
        return redirect()->route('vendor.pages.index');
    }

    public function update(Request $request, $id)
    {
        return $this->store($request);
    }

    public function destroy(Request $request, $id)
    {
        VendorPage::where('vendor_id', auth()->id())->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Terms & Conditions & Agreement cleared successfully!'
            ]);
        }

        return redirect()->route('vendor.pages.index')
            ->with('success', 'Terms & Conditions & Agreement cleared successfully!');
    }
}
