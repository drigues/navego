@extends('layouts.admin')

@section('title', 'Prestadores')

@section('content')

    @php
    $statusConfig = [
        'pending'  => ['label' => 'Pendente',  'badge' => 'bg-amber-100 text-amber-700'],
        'active'   => ['label' => 'Activo',    'badge' => 'bg-emerald-100 text-emerald-700'],
        'rejected' => ['label' => 'Rejeitado', 'badge' => 'bg-red-100 text-red-700'],
    ];
    $statusTabs = ['all' => 'Todos', 'pending' => 'Pendentes', 'active' => 'Activos', 'rejected' => 'Rejeitados'];
    $currentStatus = request('status', 'all');
    @endphp

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Prestadores</h2>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5 overflow-hidden">
        <div class="flex overflow-x-auto border-b border-gray-100 px-4 gap-1 pt-3">
            @foreach($statusTabs as $key => $label)
                <a href="{{ route('admin.prestadores', array_merge(request()->except('status', 'page'), $key !== 'all' ? ['status' => $key] : [])) }}"
                   class="shrink-0 flex items-center gap-1.5 pb-3 px-3 text-sm font-medium border-b-2 transition-colors whitespace-nowrap
                          {{ $currentStatus === $key ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                    <span class="text-xs px-1.5 py-0.5 rounded-full {{ $currentStatus === $key ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $counts[$key] ?? 0 }}
                    </span>
                </a>
            @endforeach
        </div>
        <form action="{{ route('admin.prestadores') }}" method="GET" class="flex items-center gap-3 px-4 py-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Pesquisar por nome, email ou cidade..."
                       class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm shrink-0">Pesquisar</button>
            @if(request('search'))
                <a href="{{ route('admin.prestadores', request()->except('search')) }}" class="text-sm text-gray-500 hover:text-gray-700 shrink-0">Limpar</a>
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
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Contacto</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Cidade</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Plano</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Estado</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($providers as $prov)
                            @php $sc = $statusConfig[$prov->status] ?? $statusConfig['pending']; @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shrink-0
                                                    {{ $prov->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($prov->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600') }}">
                                            {{ strtoupper(substr($prov->business_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-900 truncate max-w-[180px]">{{ $prov->business_name }}</p>
                                            <p class="text-xs text-gray-400">{{ $prov->user->name ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-xs text-gray-500">{{ $prov->user->email ?? '—' }}</p>
                                    @if($prov->phone)
                                        <p class="text-xs text-gray-400">{{ $prov->phone }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-sm text-gray-500">{{ $prov->city ?? '—' }}</td>
                                <td class="px-5 py-3.5">
                                    @if($prov->plan === 'pro')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">PRO</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Básico</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sc['badge'] }}">
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2 justify-end flex-wrap">
                                        @if($prov->status === 'pending')
                                            <form action="{{ route('admin.prestadores.aprovar', $prov) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="px-3 py-1 text-xs font-semibold text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg transition-colors">
                                                    Aprovar
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.prestadores.rejeitar', $prov) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        onclick="return confirm('Rejeitar {{ addslashes($prov->business_name) }}?')"
                                                        class="px-3 py-1 text-xs font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                                                    Rejeitar
                                                </button>
                                            </form>
                                        @elseif($prov->status === 'active')
                                            <form action="{{ route('admin.prestadores.rejeitar', $prov) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        onclick="return confirm('Suspender {{ addslashes($prov->business_name) }}?')"
                                                        class="px-3 py-1 text-xs font-medium text-amber-700 border border-amber-300 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors">
                                                    Suspender
                                                </button>
                                            </form>
                                        @elseif($prov->status === 'rejected')
                                            <form action="{{ route('admin.prestadores.aprovar', $prov) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="px-3 py-1 text-xs font-medium text-emerald-700 border border-emerald-300 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                                                    Reactivar
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.prestadores.show', $prov) }}"
                                           class="px-3 py-1 text-xs font-medium text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
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

@endsection
