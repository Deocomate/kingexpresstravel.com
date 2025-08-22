<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientNewsController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $query = News::with(['category'])
            ->whereHas('category', fn($q) => $q->where('is_active', true));

        $selectedCategorySlug = $request->input('category');
        $searchQuery = $request->input('search');

        if ($searchQuery) {
            $query->where('title', 'like', '%' . $searchQuery . '%');
        }

        if ($selectedCategorySlug) {
            $query->whereHas('category', fn($q) => $q->where('slug', $selectedCategorySlug));
        }

        $newsItems = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        if ($request->ajax()) {
            $html = view('client.pages.news.partials.news_list', compact('newsItems'))->render();
            return response()->json([
                'html' => $html,
                'next_page_url' => $newsItems->hasMorePages() ? $newsItems->nextPageUrl() : null,
            ]);
        }

        $categories = Category::where('type', 'NEWS')->where('is_active', true)->orderBy('priority')->get();

        return view('client.pages.news.index', compact('newsItems', 'categories', 'selectedCategorySlug', 'searchQuery'));
    }

    public function show(News $news): View
    {
        $news->load('category');
        $news->increment('view');

        $relatedNews = News::with('category')
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $latestNews = News::with('category')
            ->where('id', '!=', $news->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('client.pages.news.show', compact('news', 'relatedNews', 'latestNews'));
    }
}
