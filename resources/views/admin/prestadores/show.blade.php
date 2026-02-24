<x-admin-layout title="Detalhes do Prestador">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.prestadores') }}"
           class="p-2 rounded-lg text-gray-400 hover:bg-gray-200 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900">{{ $provider->business_name }}</h2>
        <div class="flex items-center gap-2 ml-auto">
            @if($provider->is_verified)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">✓ Verificado</span>
            @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Pendente verificação</span>
            @endif
            @if(!$provider->is_active)
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">Suspenso</span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: info --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Business info --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Informações</h3>
                </div>
                <dl class="divide-y divide-gray-50">
                    @foreach([
                        ['label' => 'Empresa',   'value' => $provider->business_name],
                        ['label' => 'NIF',       'value' => $provider->nif ?? '—'],
                        ['label' => 'Cidade',    'value' => ($provider->city ?? '') . ($provider->district ? ', ' . $provider->district : '') ?: '—'],
                        ['label' => 'Morada',    'value' => $provider->address ?? '—'],
                        ['label' => 'Telefone',  'value' => $provider->phone ?? '—'],
                        ['label' => 'WhatsApp',  'value' => $provider->whatsapp ?? '—'],
                        ['label' => 'Email',     'value' => $provider->contact_email ?? '—'],
                        ['label' => 'Website',   'value' => $provider->website ?? '—'],
                        ['label' => 'Plano',     'value' => strtoupper($provider->plan ?? 'basic')],
                        ['label' => 'Remoto',    'value' => $provider->serves_remote ? 'Sim' : 'Não'],
                        ['label' => 'Idiomas',   'value' => implode(', ', $provider->languages ?? [])?: '—'],
                        ['label' => 'Rating',    'value' => $provider->rating . ' (' . $provider->reviews_count . ' avaliações)'],
                    ] as $row)
                        <div class="flex gap-4 px-5 py-3">
                            <dt class="text-xs text-gray-400 w-24 shrink-0 pt-0.5">{{ $row['label'] }}</dt>
                            <dd class="text-sm text-gray-700 flex-1 break-all">{{ $row['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Description --}}
            @if($provider->description)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Descrição</h3>
                    </div>
                    <div class="px-5 py-4 text-sm text-gray-700 leading-relaxed">{{ $provider->description }}</div>
                </div>
            @endif

            {{-- Services --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">Serviços ({{ $provider->services->count() }})</h3>
                </div>
                @if($provider->services->isEmpty())
                    <p class="px-5 py-6 text-sm text-gray-400 text-center">Sem serviços registados.</p>
                @else
                    <div class="divide-y divide-gray-50">
                        @foreach($provider->services as $svc)
                            <div class="flex items-center justify-between px-5 py-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $svc->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $svc->category?->name ?? '—' }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($svc->price_min)
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ number_format($svc->price_min, 0) }}{{ $svc->price_max ? '–' . number_format($svc->price_max, 0) : '' }} €
                                        </span>
                                    @endif
                                    <span class="text-xs px-2 py-0.5 rounded-full {{ $svc->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $svc->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        {{-- Right: actions --}}
        <div class="space-y-5">

            {{-- User --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Utilizador</h3>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                            {{ strtoupper(substr($provider->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $provider->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $provider->user->email }}</p>
                            @if($provider->user->nationality)
                                <p class="text-xs text-gray-400">{{ $provider->user->nationality }}</p>
                            @endif
                        </div>
                    </div>
                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Registado</dt>
                            <dd class="text-gray-700">{{ $provider->user->created_at->format('d/m/Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Orçamentos enviados</dt>
                            <dd class="text-gray-700">{{ $provider->quotes->count() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Acções</h3>
                </div>
                <div class="p-4 space-y-2">
                    <form action="{{ route('admin.prestadores.verify', $provider) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-2.5 text-sm font-medium rounded-lg transition-colors
                                       {{ $provider->is_verified ? 'text-gray-600 border border-gray-200 hover:bg-gray-50' : 'text-white bg-emerald-500 hover:bg-emerald-600 shadow-sm' }}">
                            {{ $provider->is_verified ? '✗ Remover verificação' : '✓ Verificar prestador' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.prestadores.toggle-active', $provider) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="{{ $provider->is_active ? "return confirm('Suspender " . addslashes($provider->business_name) . "? O perfil ficará invisível.')" : "return true" }}"
                                class="w-full px-4 py-2.5 text-sm font-medium rounded-lg transition-colors
                                       {{ $provider->is_active ? 'text-red-600 border border-red-200 hover:bg-red-50' : 'text-emerald-600 border border-emerald-200 hover:bg-emerald-50' }}">
                            {{ $provider->is_active ? 'Suspender prestador' : 'Reactivar prestador' }}
                        </button>
                    </form>
                    <a href="{{ route('servicos.show', $provider->slug) }}" target="_blank"
                       class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Ver perfil público
                    </a>
                </div>
            </div>

            {{-- Quotes summary --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Orçamentos</h3>
                </div>
                <dl class="divide-y divide-gray-50">
                    @foreach([
                        ['label' => 'Total',     'value' => $provider->quotes->count()],
                        ['label' => 'Pendentes', 'value' => $provider->quotes->where('status', 'pending')->count()],
                        ['label' => 'Concluídos','value' => $provider->quotes->where('status', 'completed')->count()],
                    ] as $row)
                        <div class="flex justify-between px-5 py-2.5 text-sm">
                            <dt class="text-gray-400">{{ $row['label'] }}</dt>
                            <dd class="font-medium text-gray-900">{{ $row['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

        </div>
    </div>

</x-admin-layout>
