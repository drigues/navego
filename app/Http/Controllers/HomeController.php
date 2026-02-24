<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Guide;
use App\Models\News;
use App\Models\Provider;
use App\Models\Quote;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->withCount('providers')
            ->get();

        $featuredProviders = Provider::with(['user', 'category'])
            ->where('status', Provider::STATUS_ACTIVE)
            ->orderByDesc('quotes_count')
            ->limit(6)
            ->get();

        $recentGuides = Guide::published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        $recentNews = News::published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        $stats = [
            'providers' => Provider::where('status', Provider::STATUS_ACTIVE)->count(),
            'services'  => Quote::count(),
            'guides'    => Guide::published()->count(),
            'countries' => User::whereNotNull('nationality')->distinct('nationality')->count('nationality'),
        ];

        return view('welcome', compact(
            'categories',
            'featuredProviders',
            'recentGuides',
            'recentNews',
            'stats',
        ));
    }
}
