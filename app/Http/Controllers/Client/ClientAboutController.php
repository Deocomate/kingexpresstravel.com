<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Contracts\View\View;

class ClientAboutController extends Controller
{
    public function index(): View
    {
        $aboutPage = AboutUs::first();

        return view('client.pages.about.index', compact('aboutPage'));
    }
}
