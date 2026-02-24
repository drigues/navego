<x-admin-layout title="Planos">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Gestão de Planos</h2>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        @foreach([
            ['label' => 'Total Prestadores', 'value' => $planCounts['all'],   'bg' => 'bg-gray-100',   'ic' => 'text-gray-500'],
            ['label' => 'Plano Básico',      'value' => $planCounts['basic'], 'bg' => 'bg-slate-100',  'ic' => 'text-slate-500'],
            ['label' => 'Plano PRO',         'value' => $planCounts['pro'],   'bg' => 'bg-indigo-50',  'ic' => 'text-indigo-600'],
        ] as $card)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 text-center">
                <p class="text-3xl font-bold {{ $card['ic'] }}">{{ $card['value'] }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $card['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5 overflow-hidden">
        <div class="flex overflow-x-auto border-b border-gray-100 px-4 gap-1 pt-3">
            @foreach(['all' => 'Todos', 'basic' => 'Básico', 'pro' => 'PRO'] as $key => $label)
                <a href="{{ route('admin.planos', array_merge(request()->except('plan', 'page'), $key !== 'all' ? ['plan' => $key] : [])) }}"
                   class="shrink-0 flex items-center gap-1.5 pb-3 px-3 text-sm font-medium border-b-2 transition-colors whitespace-nowrap
                          {{ request('plan', 'all') === $key ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                    <span class="text-xs px-1.5 py-0.5 rounded-full {{ request('plan', 'all') === $key ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $planCounts[$key] ?? $planCounts['all'] }}
                    </span>
                </a>
            @endforeach
        </div>
        <form action="{{ route('admin.planos') }}" method="GET" class="flex items-center gap-3 px-4 py-3">
            @if(request('plan'))
                <input type="hidden" name="plan" value="{{ request('plan') }}">
            @endif
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Pesquisar prestadores..."
                       class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm shrink-0">Pesquisar</button>
            @if(request('search'))
                <a href="{{ route('admin.planos', request()->except('search')) }}" class="text-sm text-gray-500 hover:text-gray-700 shrink-0">Limpar</a>
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
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Utilizador</th>
                            <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Verificado</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Plano actual</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Alterar plano</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($providers as $prov)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($prov->business_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $prov->business_name }}</p>
                                            <p class="text-xs text-gray-400">{{ $prov->city ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-gray-700">{{ $prov->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $prov->user->email }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($prov->is_verified)
                                        <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($prov->plan === 'pro')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">★ PRO</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Básico</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <form action="{{ route('admin.planos.update', $prov) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="plan" class="rounded-lg border-gray-300 shadow-sm text-xs focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                                            <option value="basic" {{ $prov->plan === 'basic' ? 'selected' : '' }}>Básico</option>
                                            <option value="pro"   {{ $prov->plan === 'pro'   ? 'selected' : '' }}>PRO</option>
                                        </select>
                                        <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm whitespace-nowrap">
                                            Aplicar
                                        </button>
                                    </form>
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
