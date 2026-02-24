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
        $query = Guide::published();

        if ($request->filled('categoria')) {
            $query->where('category', $request->categoria);
        }

        if ($request->filled('q')) {
            $search = mb_strtolower($request->q);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(excerpt) LIKE ?', ["%{$search}%"]);
            });
        }

        $guides = $query->orderByDesc('published_at')->paginate(9)->withQueryString();

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('guias.index', compact('guides', 'categories'));
    }

    public function show(string $slug): View
    {
        $guide = Guide::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Guide::published()
            ->where('id', '!=', $guide->id)
            ->when($guide->category, fn ($q) => $q->where('category', $guide->category))
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('guias.show', compact('guide', 'related'));
    }
}
