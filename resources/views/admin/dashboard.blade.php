<x-admin-layout title="Dashboard">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Visão Geral</h2>
        <span class="text-sm text-gray-400">{{ now()->format('d/m/Y H:i') }}</span>
    </div>

    {{-- ── Stats grid ── --}}
    @php
    $statCards = [
        ['label' => 'Utilizadores',      'value' => $stats['users'],              'bg' => 'bg-indigo-50',  'ic' => 'text-indigo-500',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'link' => null],
        ['label' => 'Prestadores Total', 'value' => $stats['providers_total'],    'bg' => 'bg-emerald-50', 'ic' => 'text-emerald-500', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'link' => route('admin.prestadores')],
        ['label' => 'Pendentes',         'value' => $stats['providers_pending'],  'bg' => 'bg-amber-50',   'ic' => 'text-amber-500',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',  'link' => route('admin.prestadores', ['filter' => 'pending'])],
        ['label' => 'Verificados',       'value' => $stats['providers_verified'], 'bg' => 'bg-teal-50',    'ic' => 'text-teal-500',    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'link' => route('admin.prestadores', ['filter' => 'verified'])],
        ['label' => 'Orçamentos Total',  'value' => $stats['quotes_total'],       'bg' => 'bg-blue-50',    'ic' => 'text-blue-500',    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'link' => null],
        ['label' => 'Orçamentos Pend.',  'value' => $stats['quotes_pending'],     'bg' => 'bg-orange-50',  'ic' => 'text-orange-500',  'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'link' => null],
        ['label' => 'Guias Publicados',  'value' => $stats['guides_published'],   'bg' => 'bg-violet-50',  'ic' => 'text-violet-500',  'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'link' => route('admin.guias')],
        ['label' => 'Notícias Pub.',     'value' => $stats['news_published'],     'bg' => 'bg-rose-50',    'ic' => 'text-rose-500',    'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'link' => route('admin.noticias')],
        ['label' => 'Planos PRO',        'value' => $stats['providers_pro'],      'bg' => 'bg-indigo-50',  'ic' => 'text-indigo-500',  'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'link' => route('admin.planos', ['plan' => 'pro'])],
    ];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">
        @foreach($statCards as $card)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-tight">{{ $card['label'] }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-lg {{ $card['bg'] }} flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 {{ $card['ic'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                @if($card['link'])
                    <a href="{{ $card['link'] }}" class="mt-2 text-xs text-indigo-600 hover:underline font-medium inline-block">Ver →</a>
                @endif
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Prestadores pendentes --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Prestadores Pendentes</h3>
                <a href="{{ route('admin.prestadores', ['filter' => 'pending']) }}" class="text-xs text-indigo-600 hover:underline font-medium">Ver todos</a>
            </div>
            @if($recentProviders->isEmpty())
                <div class="px-5 py-10 text-center">
                    <svg class="w-8 h-8 text-gray-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-gray-400">Nenhum prestador pendente.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($recentProviders as $prov)
                        <div class="flex items-center gap-3 px-5 py-3.5">
                            <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-bold text-sm shrink-0">
                                {{ strtoupper(substr($prov->business_name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $prov->business_name }}</p>
                                <p class="text-xs text-gray-400">{{ $prov->user->name }} · {{ $prov->city ?? '—' }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <form action="{{ route('admin.prestadores.verify', $prov) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg transition-colors">
                                        Verificar
                                    </button>
                                </form>
                                <a href="{{ route('admin.prestadores.show', $prov) }}" class="px-3 py-1 text-xs font-medium text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    Ver
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Orçamentos pendentes recentes --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Orçamentos Recentes Pendentes</h3>
            </div>
            @if($recentQuotes->isEmpty())
                <div class="px-5 py-10 text-center">
                    <p class="text-sm text-gray-400">Sem orçamentos pendentes.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($recentQuotes as $quote)
                        <div class="flex items-center gap-3 px-5 py-3.5">
                            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-sm shrink-0">
                                {{ strtoupper(substr($quote->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $quote->title }}</p>
                                <p class="text-xs text-gray-400">{{ $quote->user->name }} → {{ $quote->provider->business_name }}</p>
                            </div>
                            <span class="shrink-0 text-xs text-gray-400">{{ $quote->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Quick access grid --}}
    <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Novo Guia',     'route' => 'admin.guias.create',    'icon' => 'M12 4v16m8-8H4', 'color' => 'bg-violet-600'],
            ['label' => 'Nova Notícia',  'route' => 'admin.noticias.create', 'icon' => 'M12 4v16m8-8H4', 'color' => 'bg-rose-600'],
            ['label' => 'Prestadores',   'route' => 'admin.prestadores',     'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'bg-emerald-600'],
            ['label' => 'Categorias',    'route' => 'admin.categorias',      'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'color' => 'bg-indigo-600'],
        ] as $action)
            <a href="{{ route($action['route']) }}"
               class="flex items-center gap-3 px-4 py-3.5 {{ $action['color'] }} text-white rounded-xl font-medium text-sm hover:opacity-90 transition-opacity shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}"/>
                </svg>
                {{ $action['label'] }}
            </a>
        @endforeach
    </div>

</x-admin-layout>
