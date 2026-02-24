<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Provider::with(['user', 'category'])
            ->where('status', Provider::STATUS_ACTIVE);

        if ($request->filled('categoria')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->categoria));
        }

        if ($request->filled('q')) {
            $search = mb_strtolower($request->q);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(business_name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('cidade')) {
            $query->where('city', $request->cidade);
        }

        $providers = $query->orderByDesc('quotes_count')->paginate(12)->withQueryString();

        $categories = Category::where('is_active', true)->get();

        $cities = Provider::where('status', Provider::STATUS_ACTIVE)
            ->whereNotNull('city')
            ->distinct('city')
            ->orderBy('city')
            ->pluck('city');

        return view('servicos.index', compact('providers', 'categories', 'cities'));
    }

    public function show(string $slug): View
    {
        $provider = Provider::with(['user', 'category'])
            ->where('slug', $slug)
            ->where('status', Provider::STATUS_ACTIVE)
            ->firstOrFail();

        return view('servicos.show', compact('provider'));
    }
}
