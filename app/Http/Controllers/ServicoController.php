<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Provider;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Service::with(['provider', 'category'])
            ->where('is_active', true)
            ->whereHas('provider', fn ($q) => $q->where('is_active', true));

        if ($request->filled('categoria')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->categoria)
                  ->orWhereHas('parent', fn ($pq) => $pq->where('slug', $request->categoria));
            });
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(services.name) LIKE ?', ['%'.mb_strtolower($search).'%'])
                  ->orWhereRaw('LOWER(services.description) LIKE ?', ['%'.mb_strtolower($search).'%'])
                  ->orWhereHas('provider', fn ($pq) => $pq->whereRaw('LOWER(business_name) LIKE ?', ['%'.mb_strtolower($search).'%']));
            });
        }

        if ($request->filled('cidade')) {
            $query->whereHas('provider', fn ($q) => $q->where('city', $request->cidade));
        }

        $services = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $cities = Provider::where('is_active', true)
            ->whereNotNull('city')
            ->distinct('city')
            ->orderBy('city')
            ->pluck('city');

        return view('servicos.index', compact('services', 'categories', 'cities'));
    }

    public function show(string $slug): View
    {
        $provider = Provider::with(['user', 'services.category', 'services' => fn ($q) => $q->where('is_active', true)->orderBy('name')])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $provider->loadCount(['quotes']);

        return view('servicos.show', compact('provider'));
    }
}
