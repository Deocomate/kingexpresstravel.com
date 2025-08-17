<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AboutUsController extends Controller
{
    public function index(Request $request): View
    {
        $query = AboutUs::query();

        $request->whenFilled('search', function ($search) use ($query) {
            $query->where('title', 'like', '%' . $search . '%');
        });

        $aboutUsPages = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.modules.about-us.index', compact('aboutUsPages'));
    }

    public function create(): View
    {
        return view('admin.modules.about-us.createOrEdit');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['title']);
        $originalSlug = $validatedData['slug'];
        $counter = 1;
        while (AboutUs::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $counter++;
        }

        AboutUs::create($validatedData);

        return redirect()->route('admin.about-us.index')->with('success', 'Tạo trang Giới thiệu thành công.');
    }

    public function edit(AboutUs $aboutU): View
    {
        return view('admin.modules.about-us.createOrEdit', ['aboutUsPage' => $aboutU]);
    }

    public function update(Request $request, AboutUs $aboutU): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['title']);
        if ($validatedData['slug'] !== $aboutU->slug) {
            $originalSlug = $validatedData['slug'];
            $counter = 1;
            while (AboutUs::where('slug', $validatedData['slug'])->where('id', '!=', $aboutU->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        $aboutU->update($validatedData);

        return redirect()->route('admin.about-us.index')->with('success', 'Cập nhật trang Giới thiệu thành công.');
    }

    public function destroy(AboutUs $aboutU): RedirectResponse
    {
        $aboutU->delete();
        return redirect()->route('admin.about-us.index')->with('success', 'Xóa trang Giới thiệu thành công.');
    }
}
