<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TourController extends Controller
{
    public function index(Request $request): View
    {
        $query = Tour::with(['categories', 'destinations']);

        $request->whenFilled('search', function ($search) use ($query) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('tour_code', 'like', '%' . $search . '%');
            });
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

        $tours = $query->orderByDesc('created_at')->orderBy('priority')->paginate(10)->withQueryString();
        $categories = Category::where('type', 'TOUR')->get();
        $destinations = Destination::all();

        return view('admin.modules.tours.index', compact('tours', 'categories', 'destinations'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'TOUR')->get();
        $destinations = Destination::all();
        return view('admin.modules.tours.createOrEdit', compact('categories', 'destinations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateRequest($request);
        $validatedData['slug'] = $this->generateUniqueSlug($validatedData['name']);

        $tour = Tour::create($validatedData);
        $tour->categories()->sync($request->input('category_ids', []));

        $destinationsData = [];
        if ($request->has('destination_ids')) {
            foreach ($request->input('destination_ids') as $index => $destinationId) {
                $destinationsData[$destinationId] = ['position' => $index + 1];
            }
        }
        $tour->destinations()->sync($destinationsData);


        return redirect()->route('admin.tours.index')->with('success', 'Tạo mới tour thành công.');
    }

    public function edit(Tour $tour): View
    {
        $categories = Category::where('type', 'TOUR')->get();
        $destinations = Destination::all();
        $tour->load(['categories', 'destinations']);
        return view('admin.modules.tours.createOrEdit', compact('tour', 'categories', 'destinations'));
    }

    public function update(Request $request, Tour $tour): RedirectResponse
    {
        $validatedData = $this->validateRequest($request, $tour->id);
        if ($validatedData['name'] !== $tour->name) {
            $validatedData['slug'] = $this->generateUniqueSlug($validatedData['name'], $tour->id);
        }

        $tour->update($validatedData);
        $tour->categories()->sync($request->input('category_ids', []));

        $destinationsData = [];
        if ($request->has('destination_ids')) {
            foreach ($request->input('destination_ids') as $index => $destinationId) {
                $destinationsData[$destinationId] = ['position' => $index + 1];
            }
        }
        $tour->destinations()->sync($destinationsData);

        return redirect()->route('admin.tours.index')->with('success', 'Cập nhật tour thành công.');
    }

    public function destroy(Tour $tour): RedirectResponse
    {
        $tour->delete();
        return redirect()->route('admin.tours.index')->with('success', 'Xóa tour thành công.');
    }

    private function validateRequest(Request $request, int $exceptId = null): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'tour_code' => 'required|string|max:50|unique:tours,tour_code' . ($exceptId ? ',' . $exceptId : ''),
            'duration' => 'nullable|string|max:2000',
            'departure_point' => 'nullable|string|max:2000',
            'remaining_slots' => 'nullable|integer|min:0',
            'price_adult' => 'nullable|integer|min:0',
            'price_child' => 'nullable|integer|min:0',
            'price_toddler' => 'nullable|integer|min:0',
            'price_infant' => 'nullable|integer|min:0',
            'transport_mode' => 'nullable|string|max:2000',
            'thumbnail' => 'nullable|string|max:2000',
            'priority' => 'nullable|integer',
            'short_description' => 'nullable|string',
            'tour_description' => 'nullable|string',
            'tour_schedule' => 'nullable|array',
            'tour_schedule.*.title' => 'nullable|string|max:2000',
            'tour_schedule.*.content' => 'nullable|string',
            'images' => 'nullable|array',
            'services_note' => 'nullable|string',
            'note' => 'nullable|string',
            'characteristic' => 'nullable|string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'destination_ids' => 'nullable|array',
            'destination_ids.*' => 'exists:destinations,id',
        ];

        return $request->validate($rules);
    }

    private function generateUniqueSlug(string $name, ?int $exceptId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        $query = Tour::where('slug', $slug);
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter++;
            $query = Tour::where('slug', $slug);
            if ($exceptId) {
                $query->where('id', '!=', $exceptId);
            }
        }

        return $slug;
    }
}
