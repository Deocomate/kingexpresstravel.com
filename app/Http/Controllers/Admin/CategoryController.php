<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $selectedType = $request->input('type');
        $query = Category::query();

        if ($selectedType && in_array($selectedType, ['TOUR', 'NEWS'])) {
            $query->where('type', $selectedType);
        }

        $categories = $query->orderBy('priority')->get()->toArray();
        $categoryTree = Category::buildTree($categories);

        return view('admin.modules.categories.index', compact('categoryTree', 'selectedType'));
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
        DB::transaction(function () use ($category) {
            $childIds = $category->getAllDescendantIds();
            $childIds[] = $category->id;
            Category::whereIn('id', $childIds)->delete();
        });

        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục và các mục con thành công.');
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

    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'categoryData' => 'required|json',
        ]);

        $categoryData = json_decode($request->input('categoryData'), true);

        try {
            DB::transaction(function () use ($categoryData) {
                $this->saveOrderRecursive($categoryData);
            });
            return response()->json(['success' => true, 'message' => 'Thứ tự danh mục đã được cập nhật.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
    }

    private function saveOrderRecursive(array $categoryItems, int $parentId = null): void
    {
        foreach ($categoryItems as $index => $item) {
            if (!isset($item['id'])) continue;

            Category::where('id', $item['id'])->update([
                'priority' => $index,
                'parent_id' => $parentId,
            ]);

            if (isset($item['children']) && is_array($item['children'])) {
                $this->saveOrderRecursive($item['children'], $item['id']);
            }
        }
    }

    /**
     * Show the form for adding categories to tours.
     * @return View
     */
    public function showAddToTourForm(): View
    {
        $tourCategories = DB::table('categories')
            ->where('type', 'TOUR')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.modules.categories.add-to-tour', compact('tourCategories'));
    }

    /**
     * Handle the submission for adding categories to tours.
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleAddToTour(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_ids'   => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'tour_name'      => 'required|string|min:1',
        ], [
            'category_ids.required' => 'Vui lòng chọn ít nhất một danh mục.',
            'tour_name.required' => 'Vui lòng nhập từ khóa tên tour.',
        ]);

        $categoryIds = $validated['category_ids'];
        $tourNameKeyword = $validated['tour_name'];

        // Find tours using Query Builder as per instructions
        $toursToUpdate = DB::table('tours')
                            ->where('name', 'like', '%' . $tourNameKeyword . '%')
                            ->pluck('id');

        if ($toursToUpdate->isEmpty()) {
            return back()->withInput()->with('warning', 'Không tìm thấy tour nào có tên chứa "' . $tourNameKeyword . '".');
        }

        // Prepare data for insertion
        $dataToInsert = [];
        $existingRelations = DB::table('tour_categories')
                                ->whereIn('tour_id', $toursToUpdate)
                                ->whereIn('category_id', $categoryIds)
                                ->get(['tour_id', 'category_id'])
                                ->map(fn($item) => $item->tour_id . '-' . $item->category_id)
                                ->flip(); // Create a hash map for quick lookups

        foreach ($toursToUpdate as $tourId) {
            foreach ($categoryIds as $categoryId) {
                // Check if the relation already exists to avoid duplicates
                if (!isset($existingRelations[$tourId . '-' . $categoryId])) {
                    $dataToInsert[] = [
                        'tour_id' => $tourId,
                        'category_id' => $categoryId,
                    ];
                }
            }
        }

        // Insert new relations if any
        if (!empty($dataToInsert)) {
            DB::table('tour_categories')->insert($dataToInsert);
        }

        $countAdded = count($dataToInsert);
        $countTours = $toursToUpdate->count();
        $categoryNames = DB::table('categories')->whereIn('id', $categoryIds)->pluck('name')->implode(', ');

        return redirect()->route('admin.categories.add-to-tour.create')
                         ->with('success', "Đã thêm danh mục ({$categoryNames}) cho {$countTours} tour. Có {$countAdded} liên kết mới được tạo.");
    }
}
