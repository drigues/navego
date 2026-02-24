<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Guide;
use App\Models\News;
use App\Models\Provider;
use App\Models\Quote;
use App\Models\Service;
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
            'providers_verified' => Provider::where('is_verified', true)->count(),
            'providers_pending'  => Provider::where('is_verified', false)->where('is_active', true)->count(),
            'services'           => Service::count(),
            'quotes_total'       => Quote::count(),
            'quotes_pending'     => Quote::where('status', 'pending')->count(),
            'guides_published'   => Guide::where('status', 'published')->count(),
            'news_published'     => News::where('status', 'published')->count(),
            'providers_pro'      => Provider::where('plan', 'pro')->count(),
        ];

        $recentProviders = Provider::with('user')
            ->where('is_verified', false)
            ->where('is_active', true)
            ->latest()
            ->limit(5)
            ->get();

        $recentQuotes = Quote::with('user', 'provider')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProviders', 'recentQuotes'));
    }

    // ── Prestadores ────────────────────────────────────────────────────────────

    public function prestadores(Request $request): View
    {
        $query = Provider::with('user')->withCount(['services', 'quotes']);

        $filter = $request->get('filter', 'all');
        match ($filter) {
            'pending'   => $query->where('is_verified', false)->where('is_active', true),
            'verified'  => $query->where('is_verified', true)->where('is_active', true),
            'suspended' => $query->where('is_active', false),
            default     => null,
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
            'all'       => Provider::count(),
            'pending'   => Provider::where('is_verified', false)->where('is_active', true)->count(),
            'verified'  => Provider::where('is_verified', true)->where('is_active', true)->count(),
            'suspended' => Provider::where('is_active', false)->count(),
        ];

        return view('admin.prestadores.index', compact('providers', 'counts', 'filter'));
    }

    public function showPrestador(Provider $provider): View
    {
        $provider->load('user', 'services.category', 'quotes');
        return view('admin.prestadores.show', compact('provider'));
    }

    public function toggleVerification(Provider $provider): RedirectResponse
    {
        $provider->update([
            'is_verified' => ! $provider->is_verified,
            'is_active'   => true,
        ]);

        $msg = $provider->is_verified
            ? "Prestador \"{$provider->business_name}\" verificado com sucesso."
            : "Verificação de \"{$provider->business_name}\" removida.";

        return back()->with('success', $msg);
    }

    public function toggleActive(Provider $provider): RedirectResponse
    {
        $provider->update(['is_active' => ! $provider->is_active]);

        $msg = $provider->is_active
            ? "Prestador \"{$provider->business_name}\" reactivado."
            : "Prestador \"{$provider->business_name}\" suspenso.";

        return back()->with('success', $msg);
    }

    // ── Categorias ─────────────────────────────────────────────────────────────

    public function categorias(Request $request): View
    {
        $search = $request->get('search');
        $query  = Category::withCount(['services', 'guides', 'children'])
            ->with('parent');

        if ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($search) . '%']);
        }

        $categories = $query->orderBy('sort_order')->orderBy('name')->paginate(30)->withQueryString();
        $parents    = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.categorias.index', compact('categories', 'parents'));
    }

    public function storeCategoria(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'parent_id'   => ['nullable', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'color'       => ['nullable', 'string', 'max:20'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['slug']      = $this->uniqueSlug(Str::slug($data['name']), 'categories');
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order']= (int) ($data['sort_order'] ?? 0);

        Category::create($data);

        return redirect()->route('admin.categorias')
            ->with('success', "Categoria \"{$data['name']}\" criada com sucesso.");
    }

    public function updateCategoria(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'parent_id'   => ['nullable', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'color'       => ['nullable', 'string', 'max:20'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        // Prevent a category from being its own parent
        if (isset($data['parent_id']) && $data['parent_id'] == $category->id) {
            $data['parent_id'] = null;
        }

        if ($data['name'] !== $category->name) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['name']), 'categories', $category->id);
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order']= (int) ($data['sort_order'] ?? 0);

        $category->update($data);

        return redirect()->route('admin.categorias')
            ->with('success', "Categoria \"{$category->name}\" actualizada.");
    }

    public function destroyCategoria(Category $category): RedirectResponse
    {
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Não é possível eliminar uma categoria que tem subcategorias.');
        }
        if ($category->services()->count() > 0) {
            return back()->with('error', 'Não é possível eliminar uma categoria com serviços associados.');
        }

        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categorias')
            ->with('success', "Categoria \"{$name}\" eliminada.");
    }

    // ── Guias ──────────────────────────────────────────────────────────────────

    public function guias(Request $request): View
    {
        $query = Guide::with('author', 'category')->withTrashed();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('search')) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . mb_strtolower($search) . '%']);
        }

        $guides = $query->latest()->paginate(20)->withQueryString();

        $counts = [
            'all'       => Guide::withTrashed()->count(),
            'draft'     => Guide::where('status', 'draft')->count(),
            'published' => Guide::where('status', 'published')->count(),
            'archived'  => Guide::where('status', 'archived')->count(),
        ];

        $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();

        return view('admin.guias.index', compact('guides', 'counts', 'categories'));
    }

    public function createGuia(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.guias.form', compact('categories'));
    }

    public function storeGuia(Request $request): RedirectResponse
    {
        $data = $this->validateContent($request, 'guide');
        $data['author_id']   = auth()->id();
        $data['slug']        = $this->uniqueSlug(Str::slug($data['title']), 'guides');
        $data['published_at']= $data['status'] === 'published' ? ($request->published_at ? $request->published_at : now()) : null;

        Guide::create($data);

        return redirect()->route('admin.guias')
            ->with('success', "Guia \"{$data['title']}\" criado com sucesso.");
    }

    public function editGuia(Guide $guide): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.guias.form', compact('guide', 'categories'));
    }

    public function updateGuia(Request $request, Guide $guide): RedirectResponse
    {
        $data = $this->validateContent($request, 'guide');

        if ($data['title'] !== $guide->title) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['title']), 'guides', $guide->id);
        }
        if ($data['status'] === 'published' && ! $guide->published_at) {
            $data['published_at'] = $request->published_at ? $request->published_at : now();
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
        $query = News::with('author')->withTrashed();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('search')) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . mb_strtolower($search) . '%']);
        }

        $news = $query->latest()->paginate(20)->withQueryString();

        $counts = [
            'all'       => News::withTrashed()->count(),
            'draft'     => News::where('status', 'draft')->count(),
            'published' => News::where('status', 'published')->count(),
            'archived'  => News::where('status', 'archived')->count(),
        ];

        return view('admin.noticias.index', compact('news', 'counts'));
    }

    public function createNoticia(): View
    {
        return view('admin.noticias.form');
    }

    public function storeNoticia(Request $request): RedirectResponse
    {
        $data = $this->validateContent($request, 'news');
        $data['author_id']   = auth()->id();
        $data['slug']        = $this->uniqueSlug(Str::slug($data['title']), 'news');
        $data['source_url']  = $request->input('source_url');
        $data['source_name'] = $request->input('source_name');
        $data['published_at']= $data['status'] === 'published' ? ($request->published_at ? $request->published_at : now()) : null;

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
        $data = $this->validateContent($request, 'news');

        if ($data['title'] !== $noticia->title) {
            $data['slug'] = $this->uniqueSlug(Str::slug($data['title']), 'news', $noticia->id);
        }
        if ($data['status'] === 'published' && ! $noticia->published_at) {
            $data['published_at'] = $request->published_at ? $request->published_at : now();
        }

        $data['source_url']  = $request->input('source_url');
        $data['source_name'] = $request->input('source_name');

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

    private function validateContent(Request $request, string $type): array
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string'],
            'language'    => ['required', 'in:pt,en,es,fr'],
            'status'      => ['required', 'in:draft,published,archived'],
            'tags'        => ['nullable', 'string', 'max:300'],
            'category_id' => $type === 'guide' ? ['nullable', 'integer', 'exists:categories,id'] : ['nullable'],
        ]);

        // Parse comma-separated tags → array
        $validated['tags'] = $validated['tags']
            ? array_map('trim', explode(',', $validated['tags']))
            : null;

        return $validated;
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
