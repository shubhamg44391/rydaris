<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminTermsCondition;
use Illuminate\Http\Request;

class AdminTermsController extends Controller
{
    public function index()
    {
        $page = AdminTermsCondition::first();

        return view('admin.terms.index', compact('page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'description'      => 'required|string',
        ], [
            'title.required'       => 'Title is required.',
            'description.required' => 'Description / Content is required.',
        ]);

        $page = AdminTermsCondition::first();

        if ($page) {
            $page->update([
                'title'            => $request->title,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'description'      => $request->description,
            ]);
        } else {
            AdminTermsCondition::create([
                'title'            => $request->title,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'description'      => $request->description,
            ]);
        }

        return redirect()->route('admin.terms.index')
            ->with('success', 'Terms & Conditions saved successfully!');
    }
}
