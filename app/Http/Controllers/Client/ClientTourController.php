<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientTourController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $query = Tour::with(['destinations'])
            ->whereHas('categories', fn($q) => $q->where('is_active', true));

        $request->whenFilled('search', function ($search) use ($query) {
            $query->where('name', 'like', '%' . $search . '%');
        });

        $request->whenFilled('category_id', function ($categoryId) use ($query) {
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
        });

        $request->whenFilled('destination_id', function ($destinationId) use ($query) {
            $query->whereHas('destinations', fn($q) => $q->where('destinations.id', $destinationId));
        });

        $request->whenFilled('price_from', function ($priceFrom) use ($query) {
            $query->where('price_adult', '>=', $priceFrom);
        });

        $request->whenFilled('price_to', function ($priceTo) use ($query) {
            $query->where('price_adult', '<=', $priceTo);
        });

        $request->whenFilled('sort', function ($sort) use ($query) {
            match ($sort) {
                'price_asc' => $query->orderBy('price_adult', 'asc'),
                'price_desc' => $query->orderBy('price_adult', 'desc'),
                'name_asc' => $query->orderBy('name', 'asc'),
                default => $query->orderByDesc('created_at'),
            };
        });

        $tours = $query->orderBy('priority')->paginate(12)->withQueryString();

        if ($request->ajax()) {
            $html = view('client.pages.tours.partials.tour_list', compact('tours'))->render();
            return response()->json([
                'html' => $html,
                'next_page_url' => $tours->hasMorePages() ? $tours->nextPageUrl() : null,
            ]);
        }

        $categories = Category::where('type', 'TOUR')->where('is_active', true)->get();
        $destinations = Destination::all();

        return view('client.pages.tours.index', compact('tours', 'categories', 'destinations'));
    }
}
