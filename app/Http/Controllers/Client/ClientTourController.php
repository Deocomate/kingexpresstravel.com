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

        $selectedCategorySlug = $request->input('category');
        $selectedDestinationSlug = $request->input('destination');
        $selectedCategory = null;

        $request->whenFilled('search', function ($search) use ($query) {
            $query->where('name', 'like', '%' . $search . '%');
        });

        if ($selectedCategorySlug) {
            $selectedCategory = Category::where('slug', $selectedCategorySlug)->with('children')->first();
            if ($selectedCategory) {
                $categoryIds = $selectedCategory->getAllDescendantIds();
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            }
        }

        if ($selectedDestinationSlug) {
            $query->whereHas('destinations', fn($q) => $q->where('destinations.slug', $selectedDestinationSlug));
        }

        $request->whenFilled('price_from', function ($priceFrom) use ($query) {
            if ($priceFrom > 0) {
                $query->where('price_adult', '>=', $priceFrom);
            }
        });

        $request->whenFilled('price_to', function ($priceTo) use ($query) {
            if ($priceTo > 0) {
                $query->where('price_adult', '<=', $priceTo);
            }
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

        return view('client.pages.tours.index', compact('tours', 'categories', 'destinations', 'selectedCategorySlug', 'selectedDestinationSlug', 'selectedCategory'));
    }

    public function show(Tour $tour): View
    {
        $tour->load(['categories', 'destinations']);

        $relatedTours = Tour::with('destinations')
            ->where('id', '!=', $tour->id)
            ->whereHas('categories', function ($query) use ($tour) {
                $query->whereIn('id', $tour->categories->pluck('id'));
            })
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view('client.pages.tours.show', compact('tour', 'relatedTours'));
    }
}
