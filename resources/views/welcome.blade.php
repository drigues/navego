<x-public-layout>

{{-- ========== HERO ========== --}}
<section class="relative bg-gradient-to-br from-indigo-900 via-indigo-800 to-blue-900 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
            </pattern></defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500 rounded-full opacity-10 -translate-y-1/2 translate-x-1/2 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-white/10 text-indigo-200 text-sm font-medium px-4 py-2 rounded-full mb-6 backdrop-blur-sm border border-white/10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                A plataforma para imigrantes em Portugal
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight tracking-tight mb-6">
                O teu guia<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-200 to-blue-200">em Portugal</span>
            </h1>
            <p class="text-lg sm:text-xl text-indigo-200 leading-relaxed mb-10 max-w-2xl mx-auto">
                Encontra advogados, contabilistas, tradutores e mais — prestadores que falam a tua língua e conhecem a tua situação.
            </p>

            <form action="{{ route('servicos.index') }}" method="GET"
                  class="flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto">
                <div class="flex-1 relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" placeholder="Pesquisa um serviço, prestador..."
                           class="w-full pl-12 pr-4 py-4 rounded-xl text-gray-900 bg-white shadow-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm"/>
                </div>
                <button type="submit" class="px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-xl transition-colors shadow-lg shrink-0">
                    Pesquisar
                </button>
            </form>

            <div class="flex flex-wrap justify-center gap-2 mt-6">
                @foreach($categories->take(5) as $cat)
                    <a href="{{ route('servicos.index', ['categoria' => $cat->slug]) }}"
                       class="px-3 py-1.5 bg-white/10 hover:bg-white/20 text-indigo-100 text-xs font-medium rounded-full border border-white/10 transition-colors">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ========== STATS ========== --}}
<section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-gray-100">
            @foreach([
                ['value' => $stats['providers'], 'label' => 'Prestadores'],
                ['value' => $stats['services'],  'label' => 'Serviços'],
                ['value' => $stats['guides'],    'label' => 'Guias'],
                ['value' => $stats['countries'], 'label' => 'Nacionalidades'],
            ] as $stat)
                <div class="py-8 px-4 text-center">
                    <p class="text-3xl font-bold text-indigo-600">{{ number_format($stat['value']) }}</p>
                    <p class="text-xs text-gray-500 mt-1 font-medium uppercase tracking-wide">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== CATEGORIES ========== --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">O que precisas?</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Navega por categoria e encontra o serviço certo para a tua situação.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('servicos.index', ['categoria' => $category->slug]) }}"
                   class="group bg-white rounded-2xl p-5 shadow-sm hover:shadow-md border border-gray-100 hover:border-indigo-100 transition-all duration-200 flex flex-col items-start gap-3">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-bold text-lg shrink-0 transition-transform group-hover:scale-110"
                         style="background-color: {{ $category->color ?? '#4F46E5' }}">
                        {{ strtoupper(substr($category->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm leading-snug group-hover:text-indigo-600 transition-colors">{{ $category->name }}</h3>
                        @if($category->services_count > 0)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $category->services_count }} {{ Str::plural('serviço', $category->services_count) }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== FEATURED PROVIDERS ========== --}}
@if($featuredProviders->isNotEmpty())
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Prestadores em Destaque</h2>
                <p class="text-gray-500">Profissionais verificados com excelentes avaliações.</p>
            </div>
            <a href="{{ route('servicos.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-700">
                Ver todos <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredProviders as $provider)
                <a href="{{ route('servicos.show', $provider->slug) }}"
                   class="group bg-white rounded-2xl border border-gray-100 hover:border-indigo-100 shadow-sm hover:shadow-md p-6 transition-all duration-200 flex flex-col">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            {{ strtoupper(substr($provider->business_name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors leading-snug truncate">{{ $provider->business_name }}</h3>
                            <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                @if($provider->is_verified)
                                    <span class="text-xs text-emerald-600 font-medium">✓ Verificado</span>
                                @endif
                                @if($provider->city)
                                    <span class="text-xs text-gray-400">{{ $provider->city }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($provider->description)
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4 flex-1">{{ $provider->description }}</p>
                    @endif

                    @if($provider->activeServices->isNotEmpty())
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach($provider->activeServices->take(3) as $service)
                                <span class="text-xs bg-indigo-50 text-indigo-600 font-medium px-2.5 py-1 rounded-lg">{{ Str::limit($service->name, 22) }}</span>
                            @endforeach
                            @if($provider->activeServices->count() > 3)
                                <span class="text-xs bg-gray-100 text-gray-500 font-medium px-2.5 py-1 rounded-lg">+{{ $provider->activeServices->count() - 3 }}</span>
                            @endif
                        </div>
                    @endif

                    <div class="flex items-center justify-between pt-4 border-t border-gray-50 mt-auto">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= round($provider->rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="text-xs text-gray-500 ml-1">{{ number_format($provider->rating, 1) }}</span>
                        </div>
                        @if($provider->languages)
                            <div class="flex gap-1">
                                @foreach(array_slice($provider->languages, 0, 3) as $lang)
                                    <span class="text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded font-mono uppercase">{{ $lang }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ========== GUIDES TEASER ========== --}}
@if($recentGuides->isNotEmpty())
<section class="py-20 bg-indigo-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Informação que precisas</h2>
                <p class="text-indigo-300">Guias práticos sobre vida em Portugal — escritos para imigrantes.</p>
            </div>
            <a href="{{ route('guias.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-medium text-indigo-300 hover:text-white">
                Ver todos <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentGuides as $guide)
                <a href="{{ route('guias.show', $guide->slug) }}"
                   class="group bg-indigo-900/50 hover:bg-indigo-800/60 border border-indigo-800 hover:border-indigo-600 rounded-2xl p-6 transition-all duration-200">
                    @if($guide->category)
                        <span class="inline-block text-xs font-medium text-indigo-300 bg-indigo-800 px-2.5 py-1 rounded-lg mb-3">{{ $guide->category->name }}</span>
                    @endif
                    <h3 class="font-semibold text-white leading-snug mb-2 group-hover:text-indigo-200 transition-colors">{{ $guide->title }}</h3>
                    @if($guide->excerpt)
                        <p class="text-sm text-indigo-300 line-clamp-2 mb-4">{{ $guide->excerpt }}</p>
                    @endif
                    <div class="flex items-center justify-between text-xs text-indigo-400">
                        <span>{{ $guide->published_at->diffForHumans() }}</span>
                        <span>{{ number_format($guide->views_count) }} leituras</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ========== NEWS ========== --}}
@if($recentNews->isNotEmpty())
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Notícias para Imigrantes</h2>
                <p class="text-gray-500">Atualizações sobre leis, processos e vida em Portugal.</p>
            </div>
            <a href="{{ route('noticias.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-700">
                Ver todas <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentNews as $article)
                <a href="{{ route('noticias.show', $article->slug) }}"
                   class="group flex flex-col border border-gray-100 hover:border-indigo-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 h-36 flex items-center justify-center p-6">
                        <h3 class="font-semibold text-gray-900 text-sm text-center group-hover:text-indigo-600 transition-colors line-clamp-3">{{ $article->title }}</h3>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        @if($article->excerpt)
                            <p class="text-sm text-gray-500 line-clamp-2 flex-1">{{ $article->excerpt }}</p>
                        @endif
                        <div class="flex items-center justify-between mt-4 text-xs text-gray-400">
                            <span>{{ $article->published_at->format('d M Y') }}</span>
                            @if($article->source_name)<span>{{ $article->source_name }}</span>@endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ========== CTA PROVIDER ========== --}}
<section class="py-20 bg-gradient-to-r from-emerald-600 to-teal-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-2xl mx-auto">
        <h2 class="text-3xl font-bold text-white mb-4">És prestador de serviços?</h2>
        <p class="text-emerald-100 text-lg mb-8 leading-relaxed">
            Regista-te no Navego e alcança imigrantes que precisam dos teus serviços em Portugal.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-emerald-700 font-semibold rounded-xl hover:bg-emerald-50 transition-colors shadow-md">
                Criar perfil gratuito
            </a>
            <a href="{{ route('sobre') }}" class="px-8 py-4 border-2 border-white/40 text-white font-semibold rounded-xl hover:bg-white/10 transition-colors">
                Saber mais
            </a>
        </div>
    </div>
</section>

</x-public-layout>
