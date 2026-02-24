<x-prestador-layout title="Dashboard">

    {{-- Welcome banner --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Bem-vindo, {{ auth()->user()->name }}!</h2>
            <p class="text-sm text-gray-500 mt-0.5">Aqui tens um resumo da tua actividade.</p>
        </div>
        @if($provider->plan === 'basic')
            <a href="{{ route('prestador.plano') }}"
               class="hidden sm:inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Upgrade para PRO
            </a>
        @endif
    </div>

    {{-- Alert: profile incomplete --}}
    @if(!$provider->description || !$provider->phone)
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-xl px-5 py-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-amber-800">Perfil incompleto</p>
                <p class="text-sm text-amber-700 mt-0.5">
                    Completa o teu perfil para aumentar a visibilidade no Navego.
                    <a href="{{ route('prestador.perfil') }}" class="underline font-medium">Completar agora →</a>
                </p>
            </div>
        </div>
    @endif

    {{-- Stats grid --}}
    @php
    $cards = [
        ['label' => 'Novos Pedidos',    'value' => $stats['new_quotes'],     'bg' => 'bg-amber-50',   'icon_color' => 'text-amber-500',   'text_color' => 'text-amber-600',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                'link' => route('prestador.orcamentos', ['status' => 'new'])],
        ['label' => 'Respondidos',      'value' => $stats['replied_quotes'], 'bg' => 'bg-purple-50',  'icon_color' => 'text-purple-500',  'text_color' => 'text-purple-600',  'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',              'link' => route('prestador.orcamentos', ['status' => 'replied'])],
        ['label' => 'Fechados',         'value' => $stats['closed_quotes'],  'bg' => 'bg-gray-100',   'icon_color' => 'text-gray-400',    'text_color' => 'text-gray-600',    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                                           'link' => route('prestador.orcamentos', ['status' => 'closed'])],
        ['label' => 'Total Orçamentos', 'value' => $stats['total_quotes'],   'bg' => 'bg-indigo-50',  'icon_color' => 'text-indigo-500',  'text_color' => 'text-indigo-600',  'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'link' => route('prestador.orcamentos')],
    ];
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($cards as $card)
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $card['label'] }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg {{ $card['bg'] }} flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 {{ $card['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                @if($card['link'])
                    <a href="{{ $card['link'] }}" class="mt-3 text-xs {{ $card['text_color'] }} font-medium hover:underline inline-block">
                        Ver detalhes →
                    </a>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Recent quotes --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900">Orçamentos Recentes</h3>
            <a href="{{ route('prestador.orcamentos') }}" class="text-xs text-indigo-600 hover:underline font-medium">Ver todos</a>
        </div>

        @if($recentQuotes->isEmpty())
            <div class="px-5 py-14 text-center">
                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm text-gray-400">Ainda não recebeste nenhum pedido de orçamento.</p>
            </div>
        @else
            @php
            $statusConfig = [
                'new'     => ['label' => 'Novo',        'class' => 'bg-amber-100 text-amber-700'],
                'viewed'  => ['label' => 'Visto',       'class' => 'bg-blue-100 text-blue-700'],
                'replied' => ['label' => 'Respondido',  'class' => 'bg-purple-100 text-purple-700'],
                'closed'  => ['label' => 'Fechado',     'class' => 'bg-gray-100 text-gray-500'],
            ];
            @endphp
            <div class="divide-y divide-gray-50">
                @foreach($recentQuotes as $quote)
                    @php $sc = $statusConfig[$quote->status] ?? $statusConfig['new']; @endphp
                    <a href="{{ route('prestador.orcamentos.show', $quote) }}"
                       class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                        <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-sm shrink-0">
                            {{ strtoupper(substr($quote->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $quote->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $quote->email }} · {{ $quote->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="shrink-0 text-xs font-medium px-2.5 py-1 rounded-full {{ $sc['class'] }}">
                            {{ $sc['label'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</x-prestador-layout>
