<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    

    public function index(Request $request)
    {
        $category = $request->query('category');
        $query = Faq::query();

        if ($category && in_array($category, ['product_basics', 'onboarding', 'reporting'])) {
            $query->where('category', $category);
        }

        $faqs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.faqs.index', compact('faqs', 'category'));
    }

    

    public function create(Request $request)
    {
        $category = $request->query('category');
        return view('admin.faqs.create', compact('category'));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required', 'string', 'in:product_basics,onboarding,reporting'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        Faq::create([
            'category' => $request->category,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.faqs.index', ['category' => $request->category])
            ->with('success', 'FAQ created successfully.');
    }

    

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'category' => ['required', 'string', 'in:product_basics,onboarding,reporting'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $faq->update([
            'category' => $request->category,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.faqs.index', ['category' => $request->category])
            ->with('success', 'FAQ updated successfully.');
    }

    

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $category = $faq->category;
        $faq->delete();

        return redirect()->route('admin.faqs.index', ['category' => $category])
            ->with('success', 'FAQ deleted successfully.');
    }
}
