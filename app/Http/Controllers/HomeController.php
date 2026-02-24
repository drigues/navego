<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Guide;
use App\Models\News;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->withCount(['services' => fn ($q) => $q->where('is_active', true)])
            ->get();

        $featuredProviders = Provider::with(['user', 'activeServices.category'])
            ->where('is_active', true)
            ->where('is_verified', true)
            ->orderByDesc('rating')
            ->limit(6)
            ->get();

        $recentGuides = Guide::with('category')
            ->published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        $recentNews = News::published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        $stats = [
            'providers' => Provider::where('is_active', true)->count(),
            'services'  => Service::where('is_active', true)->count(),
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
