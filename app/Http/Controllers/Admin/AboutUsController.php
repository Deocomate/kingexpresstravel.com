<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function edit(): View
    {
        $aboutUsPage = AboutUs::firstOrCreate(
            ['id' => 1],
            ['content' => '']
        );

        return view('admin.modules.about-us.edit', compact('aboutUsPage'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'content' => 'nullable|string',
        ]);

        $aboutUsPage = AboutUs::find(1);
        $aboutUsPage->update($validatedData);

        return redirect()->route('admin.about-us.edit')->with('success', 'Cập nhật trang Giới thiệu thành công.');
    }
}
