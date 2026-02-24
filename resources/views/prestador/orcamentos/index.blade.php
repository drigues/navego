<x-prestador-layout title="Orçamentos">

    @php
    $statusConfig = [
        'pending'   => ['label' => 'Pendente',   'badge' => 'bg-amber-100 text-amber-700',   'dot' => 'bg-amber-400'],
        'viewed'    => ['label' => 'Visto',      'badge' => 'bg-blue-100 text-blue-700',     'dot' => 'bg-blue-400'],
        'replied'   => ['label' => 'Respondido', 'badge' => 'bg-purple-100 text-purple-700', 'dot' => 'bg-purple-400'],
        'accepted'  => ['label' => 'Aceite',     'badge' => 'bg-green-100 text-green-700',   'dot' => 'bg-green-400'],
        'rejected'  => ['label' => 'Recusado',   'badge' => 'bg-red-100 text-red-700',       'dot' => 'bg-red-400'],
        'completed' => ['label' => 'Concluído',  'badge' => 'bg-emerald-100 text-emerald-700','dot' => 'bg-emerald-400'],
        'cancelled' => ['label' => 'Cancelado',  'badge' => 'bg-gray-100 text-gray-500',     'dot' => 'bg-gray-300'],
    ];

    $statusLabels = [
        'all'       => 'Todos',
        'pending'   => 'Pendentes',
        'viewed'    => 'Vistos',
        'replied'   => 'Respondidos',
        'accepted'  => 'Aceites',
        'completed' => 'Concluídos',
        'rejected'  => 'Recusados',
    ];

    $currentStatus = request('status', 'all');
    @endphp

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Orçamentos</h2>
        <span class="text-sm text-gray-500">{{ $statusCounts['all'] }} no total</span>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6 overflow-hidden">

        {{-- Status tabs --}}
        <div class="flex overflow-x-auto border-b border-gray-100 px-4 gap-1 pt-3 scrollbar-none">
            @foreach($statusLabels as $key => $label)
                @php
                    $count = $key === 'all' ? $statusCounts['all'] : ($statusCounts[$key] ?? 0);
                    $active = $currentStatus === $key;
                @endphp
                <a href="{{ route('prestador.orcamentos', array_merge(request()->except('status', 'page'), $key !== 'all' ? ['status' => $key] : [])) }}"
                   class="shrink-0 flex items-center gap-1.5 pb-3 px-3 text-sm font-medium border-b-2 transition-colors whitespace-nowrap
                          {{ $active ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    {{ $label }}
                    @if($count > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1 text-xs rounded-full font-medium
                                     {{ $active ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $count }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Search bar --}}
        <form action="{{ route('prestador.orcamentos') }}" method="GET" class="flex items-center gap-3 px-4 py-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Pesquisar por cliente ou título..."
                       class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm shrink-0">
                Pesquisar
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('prestador.orcamentos') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium shrink-0">
                    Limpar
                </a>
            @endif
        </form>
    </div>

    {{-- Quotes table --}}
    @if($quotes->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-16 text-center">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-gray-500 text-sm font-medium">Nenhum orçamento encontrado</p>
            <p class="text-gray-400 text-xs mt-1">
                @if(request('search'))
                    Tenta uma pesquisa diferente.
                @else
                    Os pedidos de orçamento aparecerão aqui assim que chegarem.
                @endif
            </p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Desktop table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Cliente</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Pedido</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Orçamento</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Estado</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Data</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($quotes as $quote)
                            @php $sc = $statusConfig[$quote->status] ?? $statusConfig['pending']; @endphp
                            <tr class="hover:bg-gray-50 transition-colors {{ $quote->status === 'pending' ? 'font-medium' : '' }}">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-xs shrink-0">
                                            {{ strtoupper(substr($quote->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-gray-900 font-medium">{{ $quote->user->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $quote->user->nationality ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-gray-900 max-w-[200px] truncate">{{ $quote->title }}</p>
                                    @if($quote->service)
                                        <p class="text-xs text-indigo-500 mt-0.5">{{ $quote->service->name }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-gray-500">
                                    @if($quote->budget_min || $quote->budget_max)
                                        @if($quote->budget_min && $quote->budget_max)
                                            {{ number_format($quote->budget_min, 0) }}–{{ number_format($quote->budget_max, 0) }} €
                                        @elseif($quote->budget_min)
                                            Mín. {{ number_format($quote->budget_min, 0) }} €
                                        @else
                                            Máx. {{ number_format($quote->budget_max, 0) }} €
                                        @endif
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $sc['badge'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-400 whitespace-nowrap">
                                    {{ $quote->created_at->format('d/m/Y') }}<br>
                                    {{ $quote->created_at->diffForHumans() }}
                                </td>
                                <td class="px-5 py-4">
                                    <a href="{{ route('prestador.orcamentos.show', $quote) }}"
                                       class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 hover:text-indigo-800 hover:underline whitespace-nowrap">
                                        Ver detalhes
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile list --}}
            <div class="md:hidden divide-y divide-gray-50">
                @foreach($quotes as $quote)
                    @php $sc = $statusConfig[$quote->status] ?? $statusConfig['pending']; @endphp
                    <a href="{{ route('prestador.orcamentos.show', $quote) }}"
                       class="flex items-start gap-3 px-4 py-4 hover:bg-gray-50 transition-colors">
                        <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-sm shrink-0 mt-0.5">
                            {{ strtoupper(substr($quote->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $quote->title }}</p>
                                <span class="shrink-0 text-xs font-medium px-2 py-0.5 rounded-full {{ $sc['badge'] }}">{{ $sc['label'] }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $quote->user->name }} · {{ $quote->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Pagination --}}
        @if($quotes->hasPages())
            <div class="mt-4">
                {{ $quotes->links() }}
            </div>
        @endif
    @endif

</x-prestador-layout>
