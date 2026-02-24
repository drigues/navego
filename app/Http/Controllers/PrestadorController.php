<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Quote;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PrestadorController extends Controller
{
    private function getProvider(): Provider
    {
        return auth()->user()->provider ?? abort(404, 'Perfil de prestador não encontrado.');
    }

    // ── Dashboard ──────────────────────────────────────────────────────────────

    public function dashboard(): View
    {
        $provider = $this->getProvider();

        $stats = [
            'total_quotes'   => $provider->quotes()->count(),
            'new_quotes'     => $provider->quotes()->where('status', Quote::STATUS_NEW)->count(),
            'viewed_quotes'  => $provider->quotes()->where('status', Quote::STATUS_VIEWED)->count(),
            'replied_quotes' => $provider->quotes()->where('status', Quote::STATUS_REPLIED)->count(),
            'closed_quotes'  => $provider->quotes()->where('status', Quote::STATUS_CLOSED)->count(),
        ];

        $recentQuotes = $provider->quotes()
            ->latest()
            ->limit(5)
            ->get();

        return view('prestador.dashboard', compact('provider', 'stats', 'recentQuotes'));
    }

    // ── Perfil ─────────────────────────────────────────────────────────────────

    public function editPerfil(): View
    {
        $provider   = $this->getProvider();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('prestador.perfil', compact('provider', 'categories'));
    }

    public function updatePerfil(Request $request): RedirectResponse
    {
        $provider = $this->getProvider();

        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:200'],
            'description'   => ['nullable', 'string', 'max:3000'],
            'phone'         => ['nullable', 'string', 'max:30'],
            'whatsapp'      => ['nullable', 'string', 'max:30'],
            'instagram'     => ['nullable', 'string', 'max:100'],
            'website'       => ['nullable', 'url', 'max:255'],
            'address'       => ['nullable', 'string', 'max:255'],
            'city'          => ['nullable', 'string', 'max:100'],
            'category_id'   => ['nullable', 'integer', 'exists:categories,id'],
        ]);

        // Rebuild slug only if business name changed
        if ($data['business_name'] !== $provider->business_name) {
            $slug  = Str::slug($data['business_name']);
            $count = Provider::where('slug', 'like', $slug . '%')
                ->where('id', '!=', $provider->id)
                ->count();
            $data['slug'] = $count > 0 ? $slug . '-' . ($count + 1) : $slug;
        }

        $provider->update($data);

        return redirect()->route('prestador.perfil')->with('success', 'Perfil atualizado com sucesso!');
    }

    // ── Orçamentos ─────────────────────────────────────────────────────────────

    public function orcamentos(Request $request): View
    {
        $provider = $this->getProvider();

        $query = $provider->quotes();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $lower = '%' . mb_strtolower($search) . '%';
            $query->where(function ($q) use ($lower) {
                $q->whereRaw('LOWER(name) LIKE ?', [$lower])
                  ->orWhereRaw('LOWER(email) LIKE ?', [$lower])
                  ->orWhereRaw('LOWER(description) LIKE ?', [$lower]);
            });
        }

        $quotes = $query->latest()->paginate(15)->withQueryString();

        $statusCounts = [
            'all'     => $provider->quotes()->count(),
            'new'     => $provider->quotes()->where('status', Quote::STATUS_NEW)->count(),
            'viewed'  => $provider->quotes()->where('status', Quote::STATUS_VIEWED)->count(),
            'replied' => $provider->quotes()->where('status', Quote::STATUS_REPLIED)->count(),
            'closed'  => $provider->quotes()->where('status', Quote::STATUS_CLOSED)->count(),
        ];

        return view('prestador.orcamentos.index', compact('provider', 'quotes', 'statusCounts'));
    }

    public function showOrcamento(Quote $quote): View
    {
        $provider = $this->getProvider();
        abort_if($quote->provider_id !== $provider->id, 403);

        // Auto-mark as viewed when provider opens it
        if ($quote->status === Quote::STATUS_NEW) {
            $quote->update(['status' => Quote::STATUS_VIEWED]);
        }

        return view('prestador.orcamentos.show', compact('provider', 'quote'));
    }

    public function updateOrcamento(Request $request, Quote $quote): RedirectResponse
    {
        $provider = $this->getProvider();
        abort_if($quote->provider_id !== $provider->id, 403);

        $request->validate(['status' => ['required', 'in:new,viewed,replied,closed']]);

        $quote->update(['status' => $request->status]);

        $messages = [
            Quote::STATUS_REPLIED => 'Orçamento marcado como respondido.',
            Quote::STATUS_CLOSED  => 'Orçamento fechado.',
            Quote::STATUS_VIEWED  => 'Orçamento marcado como visto.',
            Quote::STATUS_NEW     => 'Estado actualizado.',
        ];

        return redirect()
            ->route('prestador.orcamentos.show', $quote)
            ->with('success', $messages[$request->status] ?? 'Estado actualizado.');
    }

    // ── Plano ──────────────────────────────────────────────────────────────────

    public function plano(): View
    {
        $provider = $this->getProvider();

        $plans = [
            'basic' => [
                'name'        => 'Básico',
                'price'       => 0,
                'period'      => '',
                'description' => 'Para começar no Navego sem compromisso.',
                'color'       => 'gray',
                'features'    => [
                    'Perfil público básico',
                    'Receber pedidos de orçamento',
                    'Suporte por email',
                ],
                'missing' => [
                    'Selos de verificação PRO',
                    'Destaque na pesquisa',
                    'Suporte prioritário',
                ],
            ],
            'pro' => [
                'name'        => 'PRO',
                'price'       => 29,
                'period'      => '/mês',
                'description' => 'Para prestadores que querem crescer mais rápido.',
                'color'       => 'indigo',
                'features'    => [
                    'Perfil completo e destacado',
                    'Receber orçamentos ilimitados',
                    'Selo de verificação PRO',
                    'Destaque nos resultados de pesquisa',
                    'Suporte prioritário via chat',
                ],
                'missing' => [],
            ],
        ];

        return view('prestador.plano', compact('provider', 'plans'));
    }

    public function upgradePlano(Request $request): RedirectResponse
    {
        $provider = $this->getProvider();

        $request->validate(['plan' => ['required', 'in:basic,pro']]);

        $provider->update(['plan' => $request->plan]);

        $message = $request->plan === 'pro'
            ? 'Bem-vindo ao plano PRO! As novas funcionalidades já estão activas.'
            : 'Voltaste ao plano Básico.';

        return redirect()->route('prestador.plano')->with('success', $message);
    }
}
