<x-prestador-layout title="Detalhe do Orçamento">

    @php
    $statusConfig = [
        'pending'   => ['label' => 'Pendente',   'badge' => 'bg-amber-100 text-amber-700',    'dot' => 'bg-amber-400'],
        'viewed'    => ['label' => 'Visto',      'badge' => 'bg-blue-100 text-blue-700',      'dot' => 'bg-blue-400'],
        'replied'   => ['label' => 'Respondido', 'badge' => 'bg-purple-100 text-purple-700',  'dot' => 'bg-purple-400'],
        'accepted'  => ['label' => 'Aceite',     'badge' => 'bg-green-100 text-green-700',    'dot' => 'bg-green-400'],
        'rejected'  => ['label' => 'Recusado',   'badge' => 'bg-red-100 text-red-700',        'dot' => 'bg-red-400'],
        'completed' => ['label' => 'Concluído',  'badge' => 'bg-emerald-100 text-emerald-700','dot' => 'bg-emerald-400'],
        'cancelled' => ['label' => 'Cancelado',  'badge' => 'bg-gray-100 text-gray-500',      'dot' => 'bg-gray-300'],
    ];
    $sc = $statusConfig[$quote->status] ?? $statusConfig['pending'];

    $canReply    = in_array($quote->status, ['viewed', 'pending']);
    $canAccept   = in_array($quote->status, ['replied', 'viewed']);
    $canReject   = in_array($quote->status, ['pending', 'viewed', 'replied', 'accepted']);
    $canComplete = in_array($quote->status, ['accepted', 'replied']);
    @endphp

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('prestador.orcamentos') }}"
           class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1 min-w-0">
            <h2 class="text-xl font-bold text-gray-900 truncate">{{ $quote->title }}</h2>
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
                            {{ strtoupper(substr($quote->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $quote->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $quote->user->email }}</p>
                            @if($quote->user->nationality)
                                <p class="text-sm text-gray-400">{{ $quote->user->nationality }}</p>
                            @endif
                        </div>
                    </div>
                    @if($quote->user->phone)
                        <div class="mt-4 flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $quote->user->phone }}
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

                    @if($quote->service)
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Serviço solicitado</p>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-700 text-sm font-medium">
                                {{ $quote->service->name }}
                                @if($quote->service->category)
                                    <span class="text-indigo-400">·</span>
                                    <span class="text-indigo-500">{{ $quote->service->category->name }}</span>
                                @endif
                            </span>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1.5">Descrição</p>
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $quote->description }}</p>
                    </div>

                    @if($quote->budget_min || $quote->budget_max)
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Orçamento previsto</p>
                            <p class="text-lg font-bold text-gray-900">
                                @if($quote->budget_min && $quote->budget_max)
                                    {{ number_format($quote->budget_min, 0) }} € – {{ number_format($quote->budget_max, 0) }} €
                                @elseif($quote->budget_min)
                                    A partir de {{ number_format($quote->budget_min, 0) }} €
                                @else
                                    Até {{ number_format($quote->budget_max, 0) }} €
                                @endif
                            </p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Provider response (if exists) --}}
            @if($quote->provider_response)
                <div class="bg-indigo-50 border border-indigo-100 rounded-xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-indigo-100 bg-indigo-100/60 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-indigo-900">A tua resposta</h3>
                        @if($quote->proposed_price)
                            <span class="text-sm font-bold text-indigo-700">
                                Preço proposto: {{ number_format($quote->proposed_price, 2) }} €
                            </span>
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-sm text-indigo-800 leading-relaxed whitespace-pre-wrap">{{ $quote->provider_response }}</p>
                        @if($quote->responded_at)
                            <p class="text-xs text-indigo-400 mt-3">Respondido {{ $quote->responded_at->diffForHumans() }}</p>
                        @endif
                    </div>
                </div>
            @endif

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

                        @if(!in_array($quote->status, ['pending']))
                            <div class="relative">
                                <div class="absolute -left-4 top-1 w-3 h-3 rounded-full bg-blue-400 border-2 border-white shadow"></div>
                                <p class="text-sm font-medium text-gray-900">Visto pelo prestador</p>
                                <p class="text-xs text-gray-400">{{ $quote->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif

                        @if($quote->responded_at)
                            <div class="relative">
                                <div class="absolute -left-4 top-1 w-3 h-3 rounded-full bg-purple-400 border-2 border-white shadow"></div>
                                <p class="text-sm font-medium text-gray-900">Resposta enviada</p>
                                <p class="text-xs text-gray-400">{{ $quote->responded_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif

                        @if($quote->completed_at)
                            <div class="relative">
                                <div class="absolute -left-4 top-1 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white shadow"></div>
                                <p class="text-sm font-medium text-gray-900">Trabalho concluído</p>
                                <p class="text-xs text-gray-400">{{ $quote->completed_at->format('d/m/Y H:i') }}</p>
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
                    <h3 class="text-sm font-semibold text-gray-900">Acções Rápidas</h3>
                </div>
                <div class="p-4 space-y-2">

                    @if($canComplete)
                        <form action="{{ route('prestador.orcamentos.update', $quote) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="complete">
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Marcar como Concluído
                            </button>
                        </form>
                    @endif

                    @if($canAccept)
                        <form action="{{ route('prestador.orcamentos.update', $quote) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="accept">
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Aceitar Proposta
                            </button>
                        </form>
                    @endif

                    @if($canReject)
                        <form action="{{ route('prestador.orcamentos.update', $quote) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button type="submit"
                                    onclick="return confirm('Tens a certeza que queres recusar este pedido?')"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Recusar Pedido
                            </button>
                        </form>
                    @endif

                    @if(in_array($quote->status, ['completed', 'rejected', 'cancelled']))
                        <p class="text-center text-sm text-gray-400 py-2">
                            Este orçamento está fechado.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Reply form --}}
            @if($canReply)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ open: true }">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900">Responder ao Cliente</h3>
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                    <div x-show="open" x-cloak>
                        <form action="{{ route('prestador.orcamentos.update', $quote) }}" method="POST" class="p-5 space-y-4">
                            @csrf
                            <input type="hidden" name="action" value="reply">

                            @error('provider_response')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Mensagem <span class="text-red-500">*</span>
                                </label>
                                <textarea name="provider_response" rows="5"
                                          class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Olá! Analisámos o teu pedido e..."
                                          required>{{ old('provider_response') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Preço proposto (€)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-sm font-medium">€</span>
                                    <input type="number" name="proposed_price" step="0.01" min="0"
                                           value="{{ old('proposed_price') }}"
                                           class="w-full pl-7 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                           placeholder="0.00">
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Opcional. Indica o valor que propões.</p>
                            </div>

                            <button type="submit"
                                    class="w-full px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                                Enviar resposta
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($quote->provider_response && !in_array($quote->status, ['completed', 'rejected', 'cancelled']))
                {{-- Re-reply allowed if already replied --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-5 py-4 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        <span>Editar resposta</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="border-t border-gray-100">
                        <form action="{{ route('prestador.orcamentos.update', $quote) }}" method="POST" class="p-5 space-y-4">
                            @csrf
                            <input type="hidden" name="action" value="reply">
                            <textarea name="provider_response" rows="5"
                                      class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                      required>{{ old('provider_response', $quote->provider_response) }}</textarea>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-sm">€</span>
                                <input type="number" name="proposed_price" step="0.01" min="0"
                                       value="{{ old('proposed_price', $quote->proposed_price) }}"
                                       class="w-full pl-7 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <button type="submit" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                                Actualizar resposta
                            </button>
                        </form>
                    </div>
                </div>
            @endif

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
                        <dt class="text-xs text-gray-500">Criado em</dt>
                        <dd class="text-xs text-gray-700">{{ $quote->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if($quote->proposed_price)
                        <div class="flex justify-between items-center px-5 py-3">
                            <dt class="text-xs text-gray-500">Preço proposto</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ number_format($quote->proposed_price, 2) }} €</dd>
                        </div>
                    @endif
                </dl>
            </div>

        </div>
    </div>

</x-prestador-layout>
