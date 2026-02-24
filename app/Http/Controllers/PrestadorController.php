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
            'total_quotes'     => $provider->quotes()->count(),
            'pending_quotes'   => $provider->quotes()->where('status', Quote::STATUS_PENDING)->count(),
            'replied_quotes'   => $provider->quotes()->where('status', Quote::STATUS_REPLIED)->count(),
            'completed_quotes' => $provider->quotes()->where('status', Quote::STATUS_COMPLETED)->count(),
            'active_services'  => $provider->activeServices()->count(),
            'total_services'   => $provider->services()->count(),
        ];

        $recentQuotes = $provider->quotes()
            ->with('user', 'service')
            ->latest()
            ->limit(5)
            ->get();

        return view('prestador.dashboard', compact('provider', 'stats', 'recentQuotes'));
    }

    // ── Perfil ─────────────────────────────────────────────────────────────────

    public function editPerfil(): View
    {
        $provider = $this->getProvider();

        return view('prestador.perfil', compact('provider'));
    }

    public function updatePerfil(Request $request): RedirectResponse
    {
        $provider = $this->getProvider();

        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:200'],
            'description'   => ['nullable', 'string', 'max:3000'],
            'website'       => ['nullable', 'url', 'max:255'],
            'nif'           => ['nullable', 'string', 'max:20'],
            'phone'         => ['nullable', 'string', 'max:30'],
            'whatsapp'      => ['nullable', 'string', 'max:30'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'address'       => ['nullable', 'string', 'max:255'],
            'city'          => ['nullable', 'string', 'max:100'],
            'district'      => ['nullable', 'string', 'max:100'],
            'postal_code'   => ['nullable', 'string', 'max:10'],
            'languages'     => ['nullable', 'array'],
            'languages.*'   => ['string', 'max:5'],
            'facebook'      => ['nullable', 'url', 'max:255'],
            'instagram'     => ['nullable', 'url', 'max:255'],
            'linkedin'      => ['nullable', 'url', 'max:255'],
        ]);

        // Rebuild slug only if business name changed
        if ($data['business_name'] !== $provider->business_name) {
            $slug  = Str::slug($data['business_name']);
            $count = Provider::where('slug', 'like', $slug . '%')
                ->where('id', '!=', $provider->id)
                ->count();
            $data['slug'] = $count > 0 ? $slug . '-' . ($count + 1) : $slug;
        }

        $social = array_filter([
            'facebook'  => $request->input('facebook'),
            'instagram' => $request->input('instagram'),
            'linkedin'  => $request->input('linkedin'),
        ]);

        // Parse working hours from form fields
        $days         = ['seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom'];
        $workingHours = [];
        foreach ($days as $day) {
            $workingHours[$day] = [
                'closed' => (bool) $request->input("wh_{$day}_closed", false),
                'open'   => $request->input("wh_{$day}_open", '09:00'),
                'close'  => $request->input("wh_{$day}_close", '18:00'),
            ];
        }

        $provider->update(array_merge($data, [
            'social_links'  => $social ?: null,
            'working_hours' => $workingHours,
            'serves_remote' => $request->boolean('serves_remote'),
            'languages'     => $request->input('languages', []),
        ]));

        return redirect()->route('prestador.perfil')->with('success', 'Perfil atualizado com sucesso!');
    }

    // ── Orçamentos ─────────────────────────────────────────────────────────────

    public function orcamentos(Request $request): View
    {
        $provider = $this->getProvider();

        $query = $provider->quotes()->with('user', 'service');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $lower = '%' . mb_strtolower($search) . '%';
            $query->where(function ($q) use ($lower) {
                $q->whereRaw('LOWER(title) LIKE ?', [$lower])
                  ->orWhereHas('user', fn ($u) => $u->whereRaw('LOWER(name) LIKE ?', [$lower]));
            });
        }

        $quotes = $query->latest()->paginate(15)->withQueryString();

        $statusCounts = [
            'all'       => $provider->quotes()->count(),
            'pending'   => $provider->quotes()->where('status', 'pending')->count(),
            'viewed'    => $provider->quotes()->where('status', 'viewed')->count(),
            'replied'   => $provider->quotes()->where('status', 'replied')->count(),
            'accepted'  => $provider->quotes()->where('status', 'accepted')->count(),
            'completed' => $provider->quotes()->where('status', 'completed')->count(),
            'rejected'  => $provider->quotes()->where('status', 'rejected')->count(),
        ];

        return view('prestador.orcamentos.index', compact('provider', 'quotes', 'statusCounts'));
    }

    public function showOrcamento(Quote $quote): View
    {
        $provider = $this->getProvider();
        abort_if($quote->provider_id !== $provider->id, 403);

        // Auto-mark as viewed when provider opens it
        if ($quote->status === Quote::STATUS_PENDING) {
            $quote->update(['status' => Quote::STATUS_VIEWED]);
        }

        $quote->load('user', 'service.category');

        return view('prestador.orcamentos.show', compact('provider', 'quote'));
    }

    public function updateOrcamento(Request $request, Quote $quote): RedirectResponse
    {
        $provider = $this->getProvider();
        abort_if($quote->provider_id !== $provider->id, 403);

        $action = $request->input('action');

        match ($action) {
            'reply'    => $this->handleReply($request, $quote),
            'accept'   => $quote->update(['status' => Quote::STATUS_ACCEPTED]),
            'reject'   => $quote->update(['status' => Quote::STATUS_REJECTED]),
            'complete' => $quote->update(['status' => Quote::STATUS_COMPLETED, 'completed_at' => now()]),
            default    => null,
        };

        $messages = [
            'reply'    => 'Resposta enviada com sucesso!',
            'accept'   => 'Orçamento aceite!',
            'reject'   => 'Orçamento recusado.',
            'complete' => 'Trabalho marcado como concluído!',
        ];

        return redirect()
            ->route('prestador.orcamentos.show', $quote)
            ->with('success', $messages[$action] ?? 'Estado atualizado.');
    }

    private function handleReply(Request $request, Quote $quote): void
    {
        $request->validate([
            'provider_response' => ['required', 'string', 'max:3000'],
            'proposed_price'    => ['nullable', 'numeric', 'min:0'],
        ]);

        $quote->update([
            'provider_response' => $request->provider_response,
            'proposed_price'    => $request->proposed_price ?: null,
            'status'            => Quote::STATUS_REPLIED,
            'responded_at'      => now(),
        ]);
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
                    'Até 3 serviços publicados',
                    'Perfil público básico',
                    'Receber pedidos de orçamento',
                    'Suporte por email',
                ],
                'missing' => [
                    'Selos de verificação PRO',
                    'Destaque na pesquisa',
                    'Serviços ilimitados',
                    'Estatísticas detalhadas',
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
                    'Serviços ilimitados publicados',
                    'Perfil completo com portfólio',
                    'Receber orçamentos ilimitados',
                    'Selo de verificação PRO',
                    'Destaque nos resultados de pesquisa',
                    'Estatísticas e relatórios avançados',
                    'Suporte prioritário via chat',
                    'Acesso antecipado a novas funcionalidades',
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
