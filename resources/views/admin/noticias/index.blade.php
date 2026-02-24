@extends('layouts.admin')

@section('title', 'Notícias')

@section('content')

    @php
    $statusTabs = ['all' => 'Todas', 'published' => 'Publicadas', 'draft' => 'Rascunhos'];
    $currentStatus = request('status', 'all');
    @endphp

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Notícias</h2>
        <a href="{{ route('admin.noticias.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Notícia
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5 overflow-hidden">
        <div class="flex overflow-x-auto border-b border-gray-100 px-4 gap-1 pt-3">
            @foreach($statusTabs as $key => $label)
                <a href="{{ route('admin.noticias', array_merge(request()->except('status', 'page'), $key !== 'all' ? ['status' => $key] : [])) }}"
                   class="shrink-0 flex items-center gap-1.5 pb-3 px-3 text-sm font-medium border-b-2 transition-colors whitespace-nowrap
                          {{ $currentStatus === $key ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                    <span class="text-xs px-1.5 py-0.5 rounded-full {{ $currentStatus === $key ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $counts[$key] ?? 0 }}
                    </span>
                </a>
            @endforeach
        </div>
        <form action="{{ route('admin.noticias') }}" method="GET" class="flex items-center gap-3 px-4 py-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Pesquisar notícias..."
                       class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm shrink-0">Pesquisar</button>
            @if(request('search'))
                <a href="{{ route('admin.noticias', request()->except('search')) }}" class="text-sm text-gray-500 hover:text-gray-700 shrink-0">Limpar</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    @if($news->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-14 text-center">
            <p class="text-sm text-gray-400">Nenhuma notícia encontrada.</p>
            <a href="{{ route('admin.noticias.create') }}" class="mt-3 inline-block text-sm text-indigo-600 hover:underline font-medium">Criar a primeira notícia →</a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Título</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Estado</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Publicada</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($news as $item)
                            <tr class="hover:bg-gray-50 transition-colors {{ $item->trashed() ? 'opacity-50' : '' }}">
                                <td class="px-5 py-3.5">
                                    <p class="font-medium text-gray-900 max-w-sm truncate">{{ $item->title }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $item->slug }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($item->is_published)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                            Publicada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            Rascunho
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-xs text-gray-400">
                                    {{ $item->published_at?->format('d/m/Y') ?? '—' }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2 justify-end">
                                        @if(!$item->trashed())
                                            <a href="{{ route('admin.noticias.edit', $item) }}"
                                               class="px-2.5 py-1 text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition-colors">
                                                Editar
                                            </a>
                                            @if($item->is_published)
                                                <a href="{{ route('noticias.show', $item->slug) }}" target="_blank"
                                                   class="px-2.5 py-1 text-xs font-medium text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                                    Ver
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.noticias.destroy', $item) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Eliminar esta notícia?')"
                                                        class="px-2.5 py-1 text-xs font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Eliminada</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($news->hasPages())
            <div class="mt-4">{{ $news->links() }}</div>
        @endif
    @endif

@endsection
