<x-public-layout>
@php $title = $guide->title @endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- ===== ARTICLE ===== --}}
        <article class="lg:col-span-3">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-gray-600">Início</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('guias.index') }}" class="hover:text-gray-600">Guias</a>
                @if($guide->category)
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('guias.index', ['categoria' => $guide->category->slug]) }}" class="hover:text-gray-600">{{ $guide->category->name }}</a>
                @endif
            </nav>

            {{-- Header --}}
            <header class="mb-8">
                <div class="flex items-center gap-2 mb-4 flex-wrap">
                    @if($guide->category)
                        <span class="text-xs font-medium text-indigo-600 bg-indigo-50 border border-indigo-100 px-3 py-1 rounded-full">
                            {{ $guide->category->name }}
                        </span>
                    @endif
                    <span class="text-xs font-mono font-medium bg-gray-100 text-gray-500 px-2.5 py-1 rounded uppercase">{{ $guide->language }}</span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mb-4">{{ $guide->title }}</h1>

                @if($guide->excerpt)
                    <p class="text-xl text-gray-500 leading-relaxed">{{ $guide->excerpt }}</p>
                @endif

                <div class="flex items-center gap-4 mt-6 pt-6 border-t border-gray-100 text-sm text-gray-400 flex-wrap">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-xs">
                            {{ strtoupper(substr($guide->author->name, 0, 1)) }}
                        </div>
                        <span>{{ $guide->author->name }}</span>
                    </div>
                    <span>·</span>
                    <span>{{ $guide->published_at->format('d \d\e F \d\e Y') }}</span>
                    <span>·</span>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ number_format($guide->views_count) }} leituras
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <div class="prose prose-gray prose-lg max-w-none
                        prose-headings:font-bold prose-headings:text-gray-900
                        prose-h1:text-2xl prose-h2:text-xl prose-h2:mt-10 prose-h2:mb-4
                        prose-h3:text-lg prose-h3:mt-8
                        prose-p:leading-relaxed prose-p:text-gray-700
                        prose-a:text-indigo-600 prose-a:no-underline hover:prose-a:underline
                        prose-strong:text-gray-900
                        prose-ul:text-gray-700 prose-li:my-1
                        prose-blockquote:border-indigo-400 prose-blockquote:bg-indigo-50 prose-blockquote:rounded-r-lg prose-blockquote:py-1
                        prose-code:bg-gray-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:text-indigo-700 prose-code:text-sm
                        ">
                {!! Str::markdown($guide->content) !!}
            </div>

            {{-- Tags --}}
            @if($guide->tags)
                <div class="flex flex-wrap gap-2 mt-8 pt-8 border-t border-gray-100">
                    @foreach($guide->tags as $tag)
                        <span class="text-xs bg-gray-100 hover:bg-indigo-50 hover:text-indigo-600 text-gray-500 font-medium px-3 py-1.5 rounded-full transition-colors cursor-default">
                            #{{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif
        </article>

        {{-- ===== SIDEBAR ===== --}}
        <aside class="space-y-6 lg:pt-[92px]">

            {{-- CTA find services --}}
            <div class="bg-indigo-600 rounded-2xl p-6 text-white">
                <h3 class="font-bold mb-2">Precisas de ajuda?</h3>
                <p class="text-indigo-200 text-sm mb-4">Encontra prestadores especializados que falam a tua língua.</p>
                <a href="{{ route('servicos.index') }}"
                   class="block w-full text-center py-2.5 bg-white text-indigo-700 font-semibold rounded-xl text-sm hover:bg-indigo-50 transition-colors">
                    Ver Serviços
                </a>
            </div>

            {{-- Related guides --}}
            @if($related->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Guias Relacionados</h3>
                    <div class="space-y-4">
                        @foreach($related as $rel)
                            <a href="{{ route('guias.show', $rel->slug) }}"
                               class="block group">
                                @if($rel->category)
                                    <span class="text-xs text-indigo-500 font-medium">{{ $rel->category->name }}</span>
                                @endif
                                <p class="text-sm font-medium text-gray-800 group-hover:text-indigo-600 transition-colors leading-snug mt-0.5">
                                    {{ $rel->title }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $rel->published_at->format('d M Y') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>
</div>

</x-public-layout>
