<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuiaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Guide::with(['author', 'category'])
            ->published();

        if ($request->filled('lingua')) {
            $query->where('language', $request->lingua);
        }

        if ($request->filled('categoria')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->categoria));
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%'.mb_strtolower($search).'%'])
                  ->orWhereRaw('LOWER(excerpt) LIKE ?', ['%'.mb_strtolower($search).'%']);
            });
        }

        $guides = $query->orderByDesc('published_at')->paginate(9)->withQueryString();

        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('guias.index', compact('guides', 'categories'));
    }

    public function show(string $slug): View
    {
        $guide = Guide::with(['author', 'category'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $guide->increment('views_count');

        $related = Guide::with('category')
            ->published()
            ->where('id', '!=', $guide->id)
            ->when($guide->category_id, fn ($q) => $q->where('category_id', $guide->category_id))
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('guias.show', compact('guide', 'related'));
    }
}
