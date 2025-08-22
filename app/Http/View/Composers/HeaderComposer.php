<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view): void
    {
        $tourCategories = Category::query()
            ->where('type', 'TOUR')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with([
                'children' => function ($query) {
                    $query->where('is_active', true)->orderBy('priority');
                },
                'children.children' => function ($query) {
                    $query->where('is_active', true)->orderBy('priority');
                }
            ])
            ->orderBy('priority')
            ->get();

        $view->with('tourCategoriesForMenu', $tourCategories);
    }
}
