<x-public-layout>
@php $title = $provider->business_name @endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-gray-600">Início</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('servicos.index') }}" class="hover:text-gray-600">Serviços</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 truncate max-w-[200px]">{{ $provider->business_name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ===== LEFT: Provider info ===== --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Provider header --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-start gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl shrink-0">
                        {{ strtoupper(substr($provider->business_name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $provider->business_name }}</h1>
                                <div class="flex items-center flex-wrap gap-2 mt-2">
                                    @if($provider->is_verified)
                                        <span class="inline-flex items-center gap-1 text-xs text-emerald-700 bg-emerald-50 border border-emerald-100 font-medium px-2.5 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Verificado
                                        </span>
                                    @endif
                                    @if($provider->city)
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-500 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                            {{ $provider->city }}{{ $provider->district ? ', '.$provider->district : '' }}
                                        </span>
                                    @endif
                                    @if($provider->serves_remote)
                                        <span class="text-xs text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-full font-medium">Atendimento remoto</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Rating --}}
                            @if($provider->reviews_count > 0)
                                <div class="text-right shrink-0">
                                    <div class="flex items-center gap-1 justify-end">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($provider->rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-sm font-bold text-gray-900 mt-1">{{ number_format($provider->rating, 1) }}</p>
                                    <p class="text-xs text-gray-400">{{ $provider->reviews_count }} avaliações</p>
                                </div>
                            @endif
                        </div>

                        {{-- Languages --}}
                        @if($provider->languages)
                            <div class="flex items-center gap-2 mt-3 flex-wrap">
                                <span class="text-xs text-gray-400">Idiomas:</span>
                                @foreach($provider->languages as $lang)
                                    <span class="text-xs font-mono font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded uppercase">{{ $lang }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                @if($provider->description)
                    <div class="mt-6 pt-6 border-t border-gray-50">
                        <p class="text-gray-600 leading-relaxed">{{ $provider->description }}</p>
                    </div>
                @endif
            </div>

            {{-- Services list --}}
            @if($provider->services->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-5">Serviços disponíveis</h2>
                    <div class="space-y-4">
                        @foreach($provider->services as $service)
                            <div class="flex items-start justify-between gap-4 p-4 rounded-xl bg-gray-50 hover:bg-indigo-50 transition-colors border border-transparent hover:border-indigo-100 group">
                                <div class="flex-1 min-w-0">
                                    @if($service->category)
                                        <span class="text-xs text-indigo-600 font-medium bg-indigo-100 px-2 py-0.5 rounded mb-1 inline-block">{{ $service->category->name }}</span>
                                    @endif
                                    <h3 class="font-semibold text-gray-900 leading-snug">{{ $service->name }}</h3>
                                    @if($service->description)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $service->description }}</p>
                                    @endif
                                    @if($service->tags)
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            @foreach(array_slice($service->tags, 0, 4) as $tag)
                                                <span class="text-xs text-gray-400 bg-gray-200 px-2 py-0.5 rounded">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right shrink-0">
                                    @if($service->price_unit === 'negotiable')
                                        <span class="text-sm font-medium text-gray-600">Negociável</span>
                                    @elseif($service->price_min)
                                        <span class="text-sm font-bold text-gray-900">
                                            €{{ number_format($service->price_min, 0) }}@if($service->price_max && $service->price_max != $service->price_min)–{{ number_format($service->price_max, 0) }}@endif
                                        </span>
                                        <p class="text-xs text-gray-400">
                                            {{ match($service->price_unit) {
                                                'hour'  => '/ hora',
                                                'day'   => '/ dia',
                                                'month' => '/ mês',
                                                'page'  => '/ página',
                                                default => ''
                                            } }}
                                        </p>
                                    @else
                                        <span class="text-sm text-gray-400">A consultar</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Working hours --}}
            @if($provider->working_hours)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">Horário de Funcionamento</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($provider->working_hours as $day => $hours)
                            <div class="flex justify-between text-sm bg-gray-50 rounded-lg px-3 py-2">
                                <span class="text-gray-500 font-medium capitalize">{{ $day }}</span>
                                <span class="text-gray-900 font-semibold">{{ $hours }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- ===== RIGHT: Contact + Quote CTA ===== --}}
        <div class="space-y-4">

            {{-- Quote CTA card --}}
            <div x-data="{ open: false }" class="bg-white rounded-2xl border border-indigo-100 shadow-sm overflow-hidden sticky top-24">
                <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 p-6 text-white">
                    <h2 class="font-bold text-lg mb-1">Solicitar Orçamento</h2>
                    <p class="text-indigo-200 text-sm">Descreve o que precisas e {{ Str::limit($provider->business_name, 20) }} irá responder.</p>
                </div>

                <div class="p-6">
                    @auth
                        <button @click="open = !open"
                                class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors text-sm shadow-sm">
                            <span x-show="!open">Pedir orçamento gratuito</span>
                            <span x-show="open" x-cloak>Fechar formulário</span>
                        </button>

                        {{-- Quote form --}}
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="mt-5">
                            <form method="POST" action="{{ route('orcamentos.store') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="provider_id" value="{{ $provider->id }}">

                                @if($provider->services->isNotEmpty())
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Serviço (opcional)</label>
                                        <select name="service_id"
                                                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                                            <option value="">Sem preferência</option>
                                            @foreach($provider->services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Título do pedido *</label>
                                    <input type="text" name="title" value="{{ old('title') }}" required
                                           placeholder="Ex: Renovação da minha AR"
                                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('title') border-red-300 @enderror"/>
                                    @error('title')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Descreve o que precisas *</label>
                                    <textarea name="description" rows="4" required
                                              placeholder="Descreve a tua situação com o máximo de detalhe possível..."
                                              class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                                    @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Orçamento mín. (€)</label>
                                        <input type="number" name="budget_min" value="{{ old('budget_min') }}" min="0" step="10"
                                               placeholder="0"
                                               class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Orçamento máx. (€)</label>
                                        <input type="number" name="budget_max" value="{{ old('budget_max') }}" min="0" step="10"
                                               placeholder="500"
                                               class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
                                    </div>
                                </div>

                                <button type="submit"
                                        class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors text-sm">
                                    Enviar pedido
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mb-4">Para solicitar um orçamento precisas de ter uma conta Navego.</p>
                        <a href="{{ route('login') }}"
                           class="block w-full py-3 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors text-sm">
                            Entrar para pedir orçamento
                        </a>
                        <a href="{{ route('register') }}"
                           class="block w-full py-3 text-center mt-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 border border-indigo-200 hover:bg-indigo-50 rounded-xl transition-colors">
                            Criar conta gratuita
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Contact info --}}
            @if($provider->phone || $provider->contact_email || $provider->website || $provider->whatsapp)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-3">
                    <h3 class="text-sm font-semibold text-gray-900">Contactos</h3>
                    @if($provider->phone)
                        <a href="tel:{{ $provider->phone }}" class="flex items-center gap-3 text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $provider->phone }}
                        </a>
                    @endif
                    @if($provider->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $provider->whatsapp) }}" target="_blank" rel="noopener"
                           class="flex items-center gap-3 text-sm text-gray-600 hover:text-emerald-600 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp
                        </a>
                    @endif
                    @if($provider->contact_email)
                        <a href="mailto:{{ $provider->contact_email }}" class="flex items-center gap-3 text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $provider->contact_email }}
                        </a>
                    @endif
                    @if($provider->website)
                        <a href="{{ $provider->website }}" target="_blank" rel="noopener"
                           class="flex items-center gap-3 text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                            Website
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

</x-public-layout>
