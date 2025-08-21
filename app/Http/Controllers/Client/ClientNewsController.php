<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClientNewsController extends Controller
{
    public function index(Request $request): View
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

        $categories = Category::where('type', 'NEWS')->where('is_active', true)->orderBy('priority')->get();

        if ($request->ajax()) {
            return view('client.pages.news.partials.news_list', compact('newsItems'));
        }

        return view('client.pages.news.index', compact('newsItems', 'categories', 'selectedCategorySlug', 'searchQuery'));
    }
}
