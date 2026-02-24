<x-prestador-layout title="Detalhe do Orçamento">

    @php
    $statusConfig = [
        'new'     => ['label' => 'Novo',        'badge' => 'bg-amber-100 text-amber-700',   'dot' => 'bg-amber-400'],
        'viewed'  => ['label' => 'Visto',        'badge' => 'bg-blue-100 text-blue-700',     'dot' => 'bg-blue-400'],
        'replied' => ['label' => 'Respondido',   'badge' => 'bg-purple-100 text-purple-700', 'dot' => 'bg-purple-400'],
        'closed'  => ['label' => 'Fechado',      'badge' => 'bg-gray-100 text-gray-500',     'dot' => 'bg-gray-300'],
    ];
    $sc = $statusConfig[$quote->status] ?? $statusConfig['new'];

    $canMarkReplied = in_array($quote->status, ['new', 'viewed']);
    $canClose       = in_array($quote->status, ['new', 'viewed', 'replied']);
    $isClosed       = $quote->status === 'closed';
    @endphp

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl px-5 py-4 text-sm text-green-800 font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('prestador.orcamentos') }}"
           class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1 min-w-0">
            <h2 class="text-xl font-bold text-gray-900 truncate">Pedido de {{ $quote->name }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Pedido #{{ $quote->id }} · recebido {{ $quote->created_at->diffForHumans() }}</p>
        </div>
        <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium {{ $sc['badge'] }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
            {{ $sc['label'] }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- LEFT: Quote details --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Client info --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Informações do Cliente</h3>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg shrink-0">
                            {{ strtoupper(substr($quote->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $quote->name }}</p>
                            <p class="text-sm text-gray-500">{{ $quote->email }}</p>
                        </div>
                    </div>
                    @if($quote->phone)
                        <div class="mt-4 flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $quote->phone }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quote details --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Detalhes do Pedido</h3>
                </div>
                <div class="p-5 space-y-4">

                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1.5">Descrição</p>
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $quote->description }}</p>
                    </div>

                    @if($quote->budget_range)
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Orçamento previsto</p>
                            <p class="text-lg font-bold text-gray-900">{{ $quote->budget_range }}</p>
                        </div>
                    @endif

                    @if($quote->deadline)
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Prazo</p>
                            <p class="text-sm text-gray-700">{{ $quote->deadline }}</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Timeline --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Histórico</h3>
                </div>
                <div class="p-5">
                    <div class="relative pl-5 space-y-4">
                        <div class="absolute left-1.5 top-1 bottom-0 w-px bg-gray-200"></div>

                        <div class="relative">
                            <div class="absolute -left-4 top-1 w-3 h-3 rounded-full bg-indigo-500 border-2 border-white shadow"></div>
                            <p class="text-sm font-medium text-gray-900">Pedido recebido</p>
                            <p class="text-xs text-gray-400">{{ $quote->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        @if($quote->status !== 'new')
                            <div class="relative">
                                <div class="absolute -left-4 top-1 w-3 h-3 rounded-full bg-blue-400 border-2 border-white shadow"></div>
                                <p class="text-sm font-medium text-gray-900">Visto pelo prestador</p>
                                <p class="text-xs text-gray-400">{{ $quote->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif

                        @if(in_array($quote->status, ['replied', 'closed']))
                            <div class="relative">
                                <div class="absolute -left-4 top-1 w-3 h-3 rounded-full bg-purple-400 border-2 border-white shadow"></div>
                                <p class="text-sm font-medium text-gray-900">Marcado como respondido</p>
                            </div>
                        @endif

                        @if($quote->status === 'closed')
                            <div class="relative">
                                <div class="absolute -left-4 top-1 w-3 h-3 rounded-full bg-gray-400 border-2 border-white shadow"></div>
                                <p class="text-sm font-medium text-gray-900">Fechado</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT: Actions --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Quick actions --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Acções</h3>
                </div>
                <div class="p-4 space-y-2">

                    @if($canMarkReplied)
                        <form action="{{ route('prestador.orcamentos.update', $quote) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="replied">
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                Marcar como Respondido
                            </button>
                        </form>
                    @endif

                    @if($canClose)
                        <form action="{{ route('prestador.orcamentos.update', $quote) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="closed">
                            <button type="submit"
                                    onclick="return confirm('Fechar este pedido de orçamento?')"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Fechar Pedido
                            </button>
                        </form>
                    @endif

                    @if($isClosed)
                        <p class="text-center text-sm text-gray-400 py-2">
                            Este pedido está fechado.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Quote meta --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Resumo</h3>
                </div>
                <dl class="divide-y divide-gray-50">
                    <div class="flex justify-between items-center px-5 py-3">
                        <dt class="text-xs text-gray-500">ID do pedido</dt>
                        <dd class="text-xs font-mono text-gray-700">#{{ $quote->id }}</dd>
                    </div>
                    <div class="flex justify-between items-center px-5 py-3">
                        <dt class="text-xs text-gray-500">Estado</dt>
                        <dd><span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $sc['badge'] }}">{{ $sc['label'] }}</span></dd>
                    </div>
                    <div class="flex justify-between items-center px-5 py-3">
                        <dt class="text-xs text-gray-500">Recebido em</dt>
                        <dd class="text-xs text-gray-700">{{ $quote->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if($quote->budget_range)
                        <div class="flex justify-between items-center px-5 py-3">
                            <dt class="text-xs text-gray-500">Orçamento</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $quote->budget_range }}</dd>
                        </div>
                    @endif
                    @if($quote->deadline)
                        <div class="flex justify-between items-center px-5 py-3">
                            <dt class="text-xs text-gray-500">Prazo</dt>
                            <dd class="text-xs text-gray-700">{{ $quote->deadline }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Contact client --}}
            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5">
                <h3 class="text-sm font-semibold text-indigo-900 mb-3">Contactar Cliente</h3>
                <div class="space-y-2">
                    <a href="mailto:{{ $quote->email }}"
                       class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900 hover:underline">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $quote->email }}
                    </a>
                    @if($quote->phone)
                        <a href="tel:{{ $quote->phone }}"
                           class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900 hover:underline">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $quote->phone }}
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>

</x-prestador-layout>
