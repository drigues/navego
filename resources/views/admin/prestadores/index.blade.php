<x-admin-layout title="Prestadores">

    @php
    $filters = [
        'all'       => ['label' => 'Todos',      'count' => $counts['all']],
        'pending'   => ['label' => 'Pendentes',  'count' => $counts['pending']],
        'verified'  => ['label' => 'Verificados','count' => $counts['verified']],
        'suspended' => ['label' => 'Suspensos',  'count' => $counts['suspended']],
    ];
    @endphp

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Prestadores</h2>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5 overflow-hidden">
        <div class="flex overflow-x-auto border-b border-gray-100 px-4 gap-1 pt-3">
            @foreach($filters as $key => $f)
                <a href="{{ route('admin.prestadores', array_merge(request()->except('filter', 'page'), $key !== 'all' ? ['filter' => $key] : [])) }}"
                   class="shrink-0 flex items-center gap-1.5 pb-3 px-3 text-sm font-medium border-b-2 transition-colors whitespace-nowrap
                          {{ $filter === $key ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    {{ $f['label'] }}
                    <span class="text-xs px-1.5 py-0.5 rounded-full font-medium
                                 {{ $filter === $key ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $f['count'] }}
                    </span>
                </a>
            @endforeach
        </div>
        <form action="{{ route('admin.prestadores') }}" method="GET" class="flex items-center gap-3 px-4 py-3">
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Pesquisar por empresa, nome ou email..."
                       class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm shrink-0">
                Pesquisar
            </button>
            @if(request('search') || request('filter'))
                <a href="{{ route('admin.prestadores') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium shrink-0">Limpar</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    @if($providers->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-14 text-center">
            <p class="text-sm text-gray-400">Nenhum prestador encontrado.</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Prestador</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Cidade</th>
                            <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Serviços</th>
                            <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Orçamentos</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Plano</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Estado</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($providers as $prov)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($prov->business_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $prov->business_name }}</p>
                                            <p class="text-xs text-gray-400">{{ $prov->user->name }} · {{ $prov->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-500">{{ $prov->city ?? '—' }}</td>
                                <td class="px-5 py-4 text-center text-gray-700 font-medium">{{ $prov->services_count }}</td>
                                <td class="px-5 py-4 text-center text-gray-700 font-medium">{{ $prov->quotes_count }}</td>
                                <td class="px-5 py-4">
                                    @if($prov->plan === 'pro')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-indigo-100 text-indigo-700">★ PRO</span>
                                    @else
                                        <span class="text-xs text-gray-400">Básico</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-1.5">
                                        @if($prov->is_verified)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">✓ Verificado</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Pendente</span>
                                        @endif
                                        @if(!$prov->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-600">Suspenso</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2 justify-end">
                                        <form action="{{ route('admin.prestadores.verify', $prov) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="px-2.5 py-1 text-xs font-medium rounded-lg transition-colors
                                                           {{ $prov->is_verified ? 'text-gray-500 border border-gray-200 hover:bg-gray-50' : 'text-white bg-emerald-500 hover:bg-emerald-600' }}">
                                                {{ $prov->is_verified ? 'Remover verificação' : 'Verificar' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.prestadores.toggle-active', $prov) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    onclick="{{ ! $prov->is_active ?: "return confirm('Suspender " . addslashes($prov->business_name) . "?')" }}"
                                                    class="px-2.5 py-1 text-xs font-medium rounded-lg transition-colors
                                                           {{ $prov->is_active ? 'text-red-600 border border-red-200 hover:bg-red-50' : 'text-emerald-600 border border-emerald-200 hover:bg-emerald-50' }}">
                                                {{ $prov->is_active ? 'Suspender' : 'Reactivar' }}
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.prestadores.show', $prov) }}"
                                           class="px-2.5 py-1 text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition-colors">
                                            Ver
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($providers->hasPages())
            <div class="mt-4">{{ $providers->links() }}</div>
        @endif
    @endif

</x-admin-layout>
