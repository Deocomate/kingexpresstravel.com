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

        $request->whenFilled('search', function ($search) use ($query) {
            $query->where('title', 'like', '%' . $search . '%');
        });

        $request->whenFilled('category_id', function ($categoryId) use ($query) {
            $query->where('category_id', $categoryId);
        });

        $newsItems = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
        $categories = Category::where('type', 'NEWS')->where('is_active', true)->get();

        return view('client.pages.news.index', compact('newsItems', 'categories'));
    }
}
