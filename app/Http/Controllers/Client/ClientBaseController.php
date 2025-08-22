<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\Tour;
use Illuminate\Contracts\View\View;

class ClientBaseController extends Controller
{
    public function index(): View
    {
        $banners = [
            '/userfiles/files/banners/chau-au-du-lich-viet.jpg', '/userfiles/files/banners/du-lich-bac-du-lich-viet.jpg', '/userfiles/files/banners/du-lich-chau-au-du-lich-viet(1).jpg',
        ];

        $tourCategories = Category::where('type', 'TOUR')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->whereHas('tours')
            ->with(['tours' => function ($query) {
                $query->orderBy('priority')->limit(10);
            }, 'tours.destinations'])
            ->orderBy('priority')
            ->limit(3)
            ->get();

        $newsCategories = Category::where('type', 'NEWS')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->whereHas('news')
            ->with(['news' => function ($query) {
                $query->orderBy('priority')->limit(10);
            }, 'news.category'])
            ->orderBy('priority')
            ->limit(2)
            ->get();


        return view('client.pages.home', compact(
            'banners',
            'tourCategories',
            'newsCategories'
        ));
    }
}
