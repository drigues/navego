<x-public-layout title="Serviços">

{{-- Page header --}}
<section class="bg-gradient-to-b from-indigo-50 to-white border-b border-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Encontrar Prestadores</h1>
        <p class="text-gray-500">Profissionais de confiança para imigrantes em Portugal.</p>

        <form method="GET" action="{{ route('servicos.index') }}"
              class="mt-6 flex flex-col sm:flex-row gap-3 flex-wrap">

            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Pesquisar prestadores..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white"/>
            </div>

            <select name="categoria"
                    class="py-2.5 pl-3 pr-8 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white text-gray-700 min-w-[160px]">
                <option value="">Todas as categorias</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('categoria') === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            @if($cities->isNotEmpty())
                <select name="cidade"
                        class="py-2.5 pl-3 pr-8 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white text-gray-700 min-w-[140px]">
                    <option value="">Todas as cidades</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('cidade') === $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            @endif

            <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shrink-0">
                Filtrar
            </button>

            @if(request()->hasAny(['q','categoria','cidade']))
                <a href="{{ route('servicos.index') }}"
                   class="px-5 py-2.5 text-sm text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shrink-0">
                    Limpar
                </a>
            @endif
        </form>
    </div>
</section>

{{-- Results --}}
<section class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-gray-500">
                @if($providers->total() > 0)
                    <span class="font-medium text-gray-900">{{ number_format($providers->total()) }}</span>
                    {{ $providers->total() === 1 ? 'prestador encontrado' : 'prestadores encontrados' }}
                    @if(request('q'))
                        para <span class="font-medium">"{{ request('q') }}"</span>
                    @endif
                @else
                    Nenhum prestador encontrado
                @endif
            </p>
        </div>

        @if($providers->isEmpty())
            <div class="text-center py-20">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Nenhum resultado</h3>
                <p class="text-gray-500 text-sm mb-6">Tenta pesquisar com outros termos ou remove os filtros.</p>
                <a href="{{ route('servicos.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                    Ver todos os prestadores →
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($providers as $provider)
                    <a href="{{ route('servicos.show', $provider->slug) }}"
                       class="group bg-white rounded-2xl border border-gray-100 hover:border-indigo-100 shadow-sm hover:shadow-md p-6 transition-all duration-200 flex flex-col">

                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                {{ strtoupper(substr($provider->business_name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate group-hover:text-indigo-600 transition-colors">
                                    {{ $provider->business_name }}
                                </p>
                                <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                    @if($provider->plan === 'pro')
                                        <span class="text-xs text-indigo-600 font-medium bg-indigo-50 px-1.5 py-0.5 rounded">PRO</span>
                                    @endif
                                    @if($provider->city)
                                        <span class="text-xs text-gray-400">{{ $provider->city }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($provider->category)
                            <span class="inline-block text-xs font-medium text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg mb-2 self-start">
                                {{ $provider->category->name }}
                            </span>
                        @endif

                        @if($provider->description)
                            <p class="text-sm text-gray-500 line-clamp-2 flex-1">{{ $provider->description }}</p>
                        @endif

                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
                            <span class="text-xs text-gray-400">
                                {{ $provider->quotes_count }} {{ $provider->quotes_count === 1 ? 'pedido' : 'pedidos' }}
                            </span>
                            <span class="text-xs text-indigo-600 font-medium group-hover:underline">Ver perfil →</span>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($providers->hasPages())
                <div class="mt-10">
                    {{ $providers->links() }}
                </div>
            @endif
        @endif
    </div>
</section>

</x-public-layout>
