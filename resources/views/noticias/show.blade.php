<x-public-layout>
@php $title = $article->title @endphp

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-gray-600">Início</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('noticias.index') }}" class="hover:text-gray-600">Notícias</a>
    </nav>

    <header class="mb-10">
        <div class="flex items-center gap-2 mb-4 flex-wrap">
            <span class="text-xs font-mono font-medium bg-gray-100 text-gray-500 px-2.5 py-1 rounded uppercase">{{ $article->language }}</span>
            @if($article->source_name)
                <span class="text-xs text-gray-400">{{ $article->source_name }}</span>
            @endif
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mb-4">{{ $article->title }}</h1>
        @if($article->excerpt)
            <p class="text-xl text-gray-500 leading-relaxed">{{ $article->excerpt }}</p>
        @endif
        <div class="flex items-center gap-4 mt-6 pt-6 border-t border-gray-100 text-sm text-gray-400 flex-wrap">
            <span>{{ $article->published_at->format('d \d\e F \d\e Y') }}</span>
            <span>·</span>
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                {{ number_format($article->views_count) }} leituras
            </div>
        </div>
    </header>

    <div class="prose prose-gray prose-lg max-w-none
                prose-headings:font-bold prose-headings:text-gray-900
                prose-h2:text-xl prose-h2:mt-10 prose-h2:mb-4
                prose-p:leading-relaxed prose-p:text-gray-700
                prose-a:text-indigo-600
                prose-strong:text-gray-900
                prose-ul:text-gray-700
                prose-blockquote:border-indigo-400 prose-blockquote:bg-indigo-50 prose-blockquote:rounded-r-lg
                prose-code:bg-gray-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:text-indigo-700">
        {!! Str::markdown($article->content) !!}
    </div>

    @if($article->source_url)
        <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="text-sm text-gray-500">
                Fonte:
                <a href="{{ $article->source_url }}" target="_blank" rel="noopener"
                   class="text-indigo-600 hover:underline ml-1">
                    {{ $article->source_name ?? $article->source_url }}
                </a>
            </p>
        </div>
    @endif

    @if($article->tags)
        <div class="flex flex-wrap gap-2 mt-8 pt-8 border-t border-gray-100">
            @foreach($article->tags as $tag)
                <span class="text-xs bg-gray-100 text-gray-500 font-medium px-3 py-1.5 rounded-full">#{{ $tag }}</span>
            @endforeach
        </div>
    @endif

    {{-- Related --}}
    @if($related->isNotEmpty())
        <div class="mt-12 pt-12 border-t border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Notícias relacionadas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($related as $rel)
                    <a href="{{ route('noticias.show', $rel->slug) }}"
                       class="group p-4 rounded-xl border border-gray-100 hover:border-indigo-100 bg-white hover:shadow-sm transition-all">
                        <p class="text-xs text-gray-400 mb-2">{{ $rel->published_at->format('d M Y') }}</p>
                        <h3 class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors leading-snug line-clamp-3">
                            {{ $rel->title }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

</x-public-layout>
