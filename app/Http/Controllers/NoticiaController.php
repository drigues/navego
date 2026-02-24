<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoticiaController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::published();

        if ($request->filled('q')) {
            $search = mb_strtolower($request->q);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(excerpt) LIKE ?', ["%{$search}%"]);
            });
        }

        $news = $query->orderByDesc('published_at')->paginate(9)->withQueryString();

        return view('noticias.index', compact('news'));
    }

    public function show(string $slug): View
    {
        $article = News::published()->where('slug', $slug)->firstOrFail();

        $related = News::published()
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('noticias.show', compact('article', 'related'));
    }
}
