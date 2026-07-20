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
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'title.required'       => 'Title is required.',
            'description.required' => 'Description / Content is required.',
        ]);

        
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
