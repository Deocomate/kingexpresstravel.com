<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::with('category');

        $request->whenFilled('search', function ($search) use ($query) {
            $query->where('title', 'like', '%' . $search . '%');
        });

        $request->whenFilled('category_id', function ($categoryId) use ($query) {
            $query->where('category_id', $categoryId);
        });

        $request->whenFilled('date_range', function ($dateRange) use ($query) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) === 2) {
                try {
                    $startDate = Carbon::createFromFormat('d/m/Y', $dates[0])->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', $dates[1])->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (Exception) {
                    // Bỏ qua nếu định dạng ngày không hợp lệ
                }
            }
        });

        $newsItems = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $categories = Category::where('type', 'NEWS')->get();

        return view('admin.modules.news.index', compact('newsItems', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'NEWS')->get();
        return view('admin.modules.news.createOrEdit', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateRequest($request);
        $validatedData['slug'] = $this->generateUniqueSlug($validatedData['title']);

        News::create($validatedData);

        return redirect()->route('admin.news.index')->with('success', 'Tạo mới tin tức thành công.');
    }

    public function edit(News $news): View
    {
        $categories = Category::where('type', 'NEWS')->get();
        return view('admin.modules.news.createOrEdit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $validatedData = $this->validateRequest($request);
        if ($validatedData['title'] !== $news->title) {
            $validatedData['slug'] = $this->generateUniqueSlug($validatedData['title'], $news->id);
        }

        $news->update($validatedData);

        return redirect()->route('admin.news.index')->with('success', 'Cập nhật tin tức thành công.');
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Xóa tin tức thành công.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('type', 'NEWS')
            ],
            'thumbnail' => 'nullable|string',
            'priority' => 'nullable|integer',
            'short_description' => 'nullable|string',
            'contents' => 'nullable|string',
        ], [
            'category_id.exists' => 'Danh mục được chọn không hợp lệ hoặc không phải là danh mục tin tức.'
        ]);
    }

    private function generateUniqueSlug(string $title, ?int $exceptId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        $query = News::where('slug', $slug);
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter++;
            $query = News::where('slug', $slug);
            if ($exceptId) {
                $query->where('id', '!=', $exceptId);
            }
        }

        return $slug;
    }
}
