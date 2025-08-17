<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('recursiveChildren', 'parent')
            ->whereNull('parent_id')
            ->orderBy('priority')
            ->paginate(5);

        return view('admin.modules.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parentCategories = Category::all();
        return view('admin.modules.categories.createOrEdit', compact('parentCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateRequest($request);
        $validatedData['slug'] = Str::slug($validatedData['name']);

        $originalSlug = $validatedData['slug'];
        $counter = 1;
        while (Category::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $counter++;
        }

        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Tạo mới danh mục thành công.');
    }

    public function edit(Category $category): View
    {
        $parentCategories = Category::where('id', '!=', $category->id)->get();
        return view('admin.modules.categories.createOrEdit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validatedData = $this->validateRequest($request);
        $validatedData['slug'] = Str::slug($validatedData['name']);

        if ($validatedData['slug'] !== $category->slug) {
            $originalSlug = $validatedData['slug'];
            $counter = 1;
            while (Category::where('slug', $validatedData['slug'])->where('id', '!=', $category->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        $category->update($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'thumbnail' => 'nullable|string',
            'priority' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'parent_id' => 'nullable|exists:categories,id',
            'type' => [
                'required',
                Rule::in(['TOUR', 'NEWS']),
                function ($attribute, $value, $fail) use ($request) {
                    $parentId = $request->input('parent_id');
                    if ($parentId) {
                        $parent = Category::find($parentId);
                        if ($parent && $parent->type !== $value) {
                            $fail('Loại danh mục phải trùng với loại của danh mục cha.');
                        }
                    }
                },
            ],
        ]);
    }
}
