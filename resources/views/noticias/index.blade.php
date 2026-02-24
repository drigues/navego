<x-public-layout title="Notícias">

<section class="bg-gradient-to-b from-gray-50 to-white border-b border-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Notícias para Imigrantes</h1>
            <p class="text-gray-500 text-lg">Fique a par das últimas novidades sobre leis, processos e vida em Portugal.</p>
        </div>

        <form method="GET" action="{{ route('noticias.index') }}" class="mt-6 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Pesquisar notícias..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white"/>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                Filtrar
            </button>
            @if(request()->filled('q'))
                <a href="{{ route('noticias.index') }}" class="px-5 py-2.5 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50">Limpar</a>
            @endif
        </form>
    </div>
</section>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($news->isEmpty())
            <div class="text-center py-20">
                <p class="text-gray-500">Nenhuma notícia encontrada.</p>
                <a href="{{ route('noticias.index') }}" class="text-sm font-medium text-indigo-600 mt-2 block">Ver todas as notícias →</a>
            </div>
        @else
            {{-- Featured (first article) --}}
            @php $featured = $news->first() @endphp
            <a href="{{ route('noticias.show', $featured->slug) }}"
               class="group block bg-white rounded-2xl border border-gray-100 hover:border-indigo-100 shadow-sm hover:shadow-md transition-all duration-200 mb-8 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-5">
                    <div class="md:col-span-2 bg-gradient-to-br from-indigo-600 to-indigo-800 min-h-[160px] flex items-center justify-center p-8">
                        <div class="text-center">
                            <p class="text-indigo-200 text-xs font-medium uppercase tracking-wide mb-2">Em destaque</p>
                            <svg class="w-10 h-10 text-indigo-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    </div>
                    <div class="md:col-span-3 p-6 sm:p-8">
                        <h2 class="text-xl font-bold text-gray-900 leading-tight mb-3 group-hover:text-indigo-600 transition-colors">
                            {{ $featured->title }}
                        </h2>
                        @if($featured->excerpt)
                            <p class="text-gray-500 leading-relaxed line-clamp-2 mb-4">{{ $featured->excerpt }}</p>
                        @endif
                        <div class="text-xs text-gray-400">
                            <span>{{ $featured->published_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </a>

            {{-- Rest of articles --}}
            @if($news->count() > 1)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news->skip(1) as $article)
                        <a href="{{ route('noticias.show', $article->slug) }}"
                           class="group bg-white rounded-2xl border border-gray-100 hover:border-indigo-100 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs text-gray-400">{{ $article->published_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 leading-snug mb-2 group-hover:text-indigo-600 transition-colors flex-1">
                                {{ $article->title }}
                            </h3>
                            @if($article->excerpt)
                                <p class="text-sm text-gray-500 line-clamp-2 mt-1">{{ $article->excerpt }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif

            @if($news->hasPages())
                <div class="mt-10">{{ $news->links() }}</div>
            @endif
        @endif
    </div>
</section>

</x-public-layout>
