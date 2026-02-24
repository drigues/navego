<x-public-layout title="Guias para Imigrantes">

<section class="bg-gradient-to-b from-indigo-50 to-white border-b border-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Guias para Imigrantes</h1>
            <p class="text-gray-500 text-lg">Informação prática e atualizada sobre viver em Portugal — NIF, SNS, habitação, emprego e muito mais.</p>
        </div>

        <form method="GET" action="{{ route('guias.index') }}" class="mt-6 flex flex-col sm:flex-row gap-3 flex-wrap">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Pesquisar guias..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white"/>
            </div>
            <select name="categoria" class="py-2.5 pl-3 pr-8 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white text-gray-700">
                <option value="">Todas as categorias</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('categoria') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="lingua" class="py-2.5 pl-3 pr-8 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white text-gray-700">
                <option value="">Todos os idiomas</option>
                <option value="pt" {{ request('lingua') === 'pt' ? 'selected' : '' }}>Português</option>
                <option value="en" {{ request('lingua') === 'en' ? 'selected' : '' }}>English</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                Filtrar
            </button>
            @if(request()->hasAny(['q','categoria','lingua']))
                <a href="{{ route('guias.index') }}" class="px-5 py-2.5 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50">Limpar</a>
            @endif
        </form>
    </div>
</section>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($guides->isEmpty())
            <div class="text-center py-20">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                </div>
                <p class="text-gray-500 text-sm">Nenhum guia encontrado.</p>
                <a href="{{ route('guias.index') }}" class="text-sm font-medium text-indigo-600 mt-2 block">Ver todos os guias →</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($guides as $guide)
                    <a href="{{ route('guias.show', $guide->slug) }}"
                       class="group bg-white rounded-2xl border border-gray-100 hover:border-indigo-100 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden">
                        {{-- Color bar --}}
                        <div class="h-1.5 w-full" style="background-color: {{ $guide->category?->color ?? '#4F46E5' }}"></div>

                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                @if($guide->category)
                                    <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">{{ $guide->category->name }}</span>
                                @endif
                                <span class="text-xs text-gray-400 font-mono uppercase shrink-0">{{ strtoupper($guide->language) }}</span>
                            </div>

                            <h2 class="font-semibold text-gray-900 leading-snug mb-2 group-hover:text-indigo-600 transition-colors">{{ $guide->title }}</h2>

                            @if($guide->excerpt)
                                <p class="text-sm text-gray-500 line-clamp-2 flex-1">{{ $guide->excerpt }}</p>
                            @endif

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50 text-xs text-gray-400">
                                <span>{{ $guide->published_at->format('d M Y') }}</span>
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    {{ number_format($guide->views_count) }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($guides->hasPages())
                <div class="mt-10">{{ $guides->links() }}</div>
            @endif
        @endif
    </div>
</section>

</x-public-layout>
