<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Guide;
use App\Models\News;
use App\Models\Provider;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    // ── Dashboard ──────────────────────────────────────────────────────────────

    public function dashboard(): View
    {
        $stats = [
            'users'              => User::count(),
            'providers_total'    => Provider::count(),
            'providers_active'   => Provider::where('status', Provider::STATUS_ACTIVE)->count(),
            'providers_pending'  => Provider::where('status', Provider::STATUS_PENDING)->count(),
            'quotes_total'       => Quote::count(),
            'quotes_new'         => Quote::where('status', Quote::STATUS_NEW)->count(),
            'guides_published'   => Guide::where('is_published', true)->count(),
            'news_published'     => News::where('is_published', true)->count(),
            'providers_pro'      => Provider::where('plan', 'pro')->count(),
        ];

        $recentProviders = Provider::with('user')
            ->where('status', Provider::STATUS_PENDING)
            ->latest()
            ->limit(5)
            ->get();

        $recentQuotes = Quote::with('provider')
            ->where('status', Quote::STATUS_NEW)
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProviders', 'recentQuotes'));
    }

    // ── Prestadores ────────────────────────────────────────────────────────────

    public function prestadores(Request $request): View
    {
        $query = Provider::with('user')->withCount('quotes');

        $filter = $request->get('filter', 'all');
        match ($filter) {
            'pending'  => $query->where('status', Provider::STATUS_PENDING),
            'active'   => $query->where('status', Provider::STATUS_ACTIVE),
            'rejected' => $query->where('status', Provider::STATUS_REJECTED),
            default    => null,
        };

        if ($search = $request->get('search')) {
            $lower = '%' . mb_strtolower($search) . '%';
            $query->where(function ($q) use ($lower) {
                $q->whereRaw('LOWER(business_name) LIKE ?', [$lower])
                  ->orWhereHas('user', fn ($u) => $u->whereRaw('LOWER(name) LIKE ?', [$lower])
                      ->orWhereRaw('LOWER(email) LIKE ?', [$lower]));
            });
        }

        $providers = $query->latest()->paginate(20)->withQueryString();

        $counts = [
            'all'      => Provider::count(),
            'pending'  => Provider::where('status', Provider::STATUS_PENDING)->count(),
            'active'   => Provider::where('status', Provider::STATUS_ACTIVE)->count(),
            'rejected' => Provider::where('status', Provider::STATUS_REJECTED)->count(),
        ];

        return view('admin.prestadores.index', compact('providers', 'counts', 'filter'));
    }

    public function showPrestador(Provider $provider): View
    {
        $provider->load('user', 'category', 'quotes');
        return view('admin.prestadores.show', compact('provider'));
    }

    public function updateStatus(Request $request, Provider $provider): RedirectResponse
    {
        $request->validate(['status' => ['required', 'in:pending,active,rejected']]);

        $provider->update(['status' => $request->status]);

        $labels = [
            Provider::STATUS_ACTIVE   => 'activado',
            Provider::STATUS_REJECTED => 'rejeitado',
            Provider::STATUS_PENDING  => 'colocado como pendente',
        ];

        return back()->with('success', "Prestador \"{$provider->business_name}\" " . ($labels[$request->status] ?? 'actualizado') . '.');
    }

    // ── Categorias ─────────────────────────────────────────────────────────────

    public function categorias(Request $request): View
    {
        $search = $request->get('search');
        $query  = Category::withCount('providers');

        if ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($search) . '%']);
        }

        $categories = $query->orderBy('name')->paginate(30)->withQueryString();

        return view('admin.categorias.index', compact('categories'));
    }

    public function storeCategoria(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['slug']      = $this->uniqueSlug(Str::slug($data['name']), 'categories');
        $data['is_active'] = $request->boolean('is_active', true);

        Category::create($data);

        return redirect()->route('admin.categorias')
            ->with('success', "Categoria \"{$data['name']}\" criada com sucesso.");
    }

    public function updateCategoria(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        if ($data['name'] !== $category->name) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['name']), 'categories', $category->id);
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $category->update($data);

        return redirect()->route('admin.categorias')
            ->with('success', "Categoria \"{$category->name}\" actualizada.");
    }

    public function destroyCategoria(Category $category): RedirectResponse
    {
        if ($category->providers()->count() > 0) {
            return back()->with('error', 'Não é possível eliminar uma categoria com prestadores associados.');
        }

        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categorias')
            ->with('success', "Categoria \"{$name}\" eliminada.");
    }

    // ── Guias ──────────────────────────────────────────────────────────────────

    public function guias(Request $request): View
    {
        $query = Guide::withTrashed();

        if ($status = $request->get('status')) {
            $query->where('is_published', $status === 'published');
        }
        if ($search = $request->get('search')) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . mb_strtolower($search) . '%']);
        }

        $guides = $query->latest()->paginate(20)->withQueryString();

        $counts = [
            'all'       => Guide::withTrashed()->count(),
            'published' => Guide::where('is_published', true)->count(),
            'draft'     => Guide::where('is_published', false)->count(),
        ];

        $categories = Category::orderBy('name')->pluck('name');

        return view('admin.guias.index', compact('guides', 'counts', 'categories'));
    }

    public function createGuia(): View
    {
        $categories = Category::orderBy('name')->pluck('name');
        return view('admin.guias.form', compact('categories'));
    }

    public function storeGuia(Request $request): RedirectResponse
    {
        $data = $this->validateGuia($request);
        $data['slug'] = $this->uniqueSlug(Str::slug($data['title']), 'guides');

        if ($data['is_published']) {
            $data['published_at'] = $request->filled('published_at') ? $request->published_at : now();
        }

        Guide::create($data);

        return redirect()->route('admin.guias')
            ->with('success', "Guia \"{$data['title']}\" criado com sucesso.");
    }

    public function editGuia(Guide $guide): View
    {
        $categories = Category::orderBy('name')->pluck('name');
        return view('admin.guias.form', compact('guide', 'categories'));
    }

    public function updateGuia(Request $request, Guide $guide): RedirectResponse
    {
        $data = $this->validateGuia($request);

        if ($data['title'] !== $guide->title) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['title']), 'guides', $guide->id);
        }
        if ($data['is_published'] && ! $guide->published_at) {
            $data['published_at'] = $request->filled('published_at') ? $request->published_at : now();
        }
        if (! $data['is_published']) {
            $data['published_at'] = null;
        }

        $guide->update($data);

        return redirect()->route('admin.guias')
            ->with('success', "Guia \"{$guide->title}\" actualizado.");
    }

    public function destroyGuia(Guide $guide): RedirectResponse
    {
        $title = $guide->title;
        $guide->delete();

        return redirect()->route('admin.guias')
            ->with('success', "Guia \"{$title}\" eliminado.");
    }

    // ── Notícias ───────────────────────────────────────────────────────────────

    public function noticias(Request $request): View
    {
        $query = News::withTrashed();

        if ($status = $request->get('status')) {
            $query->where('is_published', $status === 'published');
        }
        if ($search = $request->get('search')) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . mb_strtolower($search) . '%']);
        }

        $news = $query->latest()->paginate(20)->withQueryString();

        $counts = [
            'all'       => News::withTrashed()->count(),
            'published' => News::where('is_published', true)->count(),
            'draft'     => News::where('is_published', false)->count(),
        ];

        return view('admin.noticias.index', compact('news', 'counts'));
    }

    public function createNoticia(): View
    {
        return view('admin.noticias.form');
    }

    public function storeNoticia(Request $request): RedirectResponse
    {
        $data = $this->validateNews($request);
        $data['slug'] = $this->uniqueSlug(Str::slug($data['title']), 'news');

        if ($data['is_published']) {
            $data['published_at'] = $request->filled('published_at') ? $request->published_at : now();
        }

        News::create($data);

        return redirect()->route('admin.noticias')
            ->with('success', "Notícia \"{$data['title']}\" criada com sucesso.");
    }

    public function editNoticia(News $noticia): View
    {
        return view('admin.noticias.form', ['news' => $noticia]);
    }

    public function updateNoticia(Request $request, News $noticia): RedirectResponse
    {
        $data = $this->validateNews($request);

        if ($data['title'] !== $noticia->title) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['title']), 'news', $noticia->id);
        }
        if ($data['is_published'] && ! $noticia->published_at) {
            $data['published_at'] = $request->filled('published_at') ? $request->published_at : now();
        }
        if (! $data['is_published']) {
            $data['published_at'] = null;
        }

        $noticia->update($data);

        return redirect()->route('admin.noticias')
            ->with('success', "Notícia \"{$noticia->title}\" actualizada.");
    }

    public function destroyNoticia(News $noticia): RedirectResponse
    {
        $title = $noticia->title;
        $noticia->delete();

        return redirect()->route('admin.noticias')
            ->with('success', "Notícia \"{$title}\" eliminada.");
    }

    // ── Planos ─────────────────────────────────────────────────────────────────

    public function planos(Request $request): View
    {
        $query = Provider::with('user');

        if ($plan = $request->get('plan')) {
            $query->where('plan', $plan);
        }
        if ($search = $request->get('search')) {
            $lower = '%' . mb_strtolower($search) . '%';
            $query->where(function ($q) use ($lower) {
                $q->whereRaw('LOWER(business_name) LIKE ?', [$lower])
                  ->orWhereHas('user', fn ($u) => $u->whereRaw('LOWER(name) LIKE ?', [$lower]));
            });
        }

        $providers = $query->orderBy('plan')->latest()->paginate(25)->withQueryString();

        $planCounts = [
            'all'   => Provider::count(),
            'basic' => Provider::where('plan', 'basic')->count(),
            'pro'   => Provider::where('plan', 'pro')->count(),
        ];

        return view('admin.planos.index', compact('providers', 'planCounts'));
    }

    public function updatePlano(Request $request, Provider $provider): RedirectResponse
    {
        $request->validate(['plan' => ['required', 'in:basic,pro']]);

        $provider->update(['plan' => $request->plan]);

        return back()->with('success', "Plano de \"{$provider->business_name}\" actualizado para " . strtoupper($request->plan) . '.');
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    private function validateGuia(Request $request): array
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string'],
            'category'    => ['nullable', 'string', 'max:100'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published', false);

        return $data;
    }

    private function validateNews(Request $request): array
    {
        $data = $request->validate([
            'title'          => ['required', 'string', 'max:200'],
            'excerpt'        => ['nullable', 'string', 'max:500'],
            'content'        => ['required', 'string'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'is_published'   => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published', false);

        return $data;
    }

    private function uniqueSlug(string $base, string $table, ?int $ignoreId = null): string
    {
        $slug  = $base;
        $count = 1;
        while (true) {
            $query = \DB::table($table)->where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if (! $query->exists()) {
                break;
            }
            $slug = $base . '-' . $count++;
        }
        return $slug;
    }
}
