<x-public-layout>
@php $title = $provider->business_name @endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-gray-600">Início</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('servicos.index') }}" class="hover:text-gray-600">Prestadores</a>
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
                        <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $provider->business_name }}</h1>
                        <div class="flex items-center flex-wrap gap-2 mt-2">
                            @if($provider->status === 'active')
                                <span class="inline-flex items-center gap-1 text-xs text-emerald-700 bg-emerald-50 border border-emerald-100 font-medium px-2.5 py-1 rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Activo
                                </span>
                            @endif
                            @if($provider->plan === 'pro')
                                <span class="text-xs text-indigo-600 bg-indigo-50 border border-indigo-100 px-2.5 py-1 rounded-full font-medium">PRO</span>
                            @endif
                            @if($provider->city)
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    {{ $provider->city }}
                                </span>
                            @endif
                            @if($provider->category)
                                <span class="text-xs text-indigo-600 bg-indigo-50 border border-indigo-100 px-2.5 py-1 rounded-full font-medium">
                                    {{ $provider->category->name }}
                                </span>
                            @endif
                        </div>

                        @if($provider->description)
                            <div class="mt-6 pt-6 border-t border-gray-50">
                                <p class="text-gray-600 leading-relaxed">{{ $provider->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Stats bar --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <dt class="text-xs text-gray-400 uppercase tracking-wide">Pedidos recebidos</dt>
                        <dd class="mt-1 text-2xl font-bold text-indigo-600">{{ $provider->quotes_count }}</dd>
                    </div>
                    <div class="text-center">
                        <dt class="text-xs text-gray-400 uppercase tracking-wide">Plano</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">{{ strtoupper($provider->plan) }}</dd>
                    </div>
                </dl>
            </div>

        </div>

        {{-- ===== RIGHT: Contact + Quote CTA ===== --}}
        <div class="space-y-4">

            {{-- Quote CTA card --}}
            <div x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }"
                 class="bg-white rounded-2xl border border-indigo-100 shadow-sm overflow-hidden sticky top-24">

                <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 p-6 text-white">
                    <h2 class="font-bold text-lg mb-1">Solicitar Orçamento</h2>
                    <p class="text-indigo-200 text-sm">Descreve o que precisas e {{ Str::limit($provider->business_name, 20) }} irá responder.</p>
                </div>

                <div class="p-6">

                    @if(session('success'))
                        <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 mb-5">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
                            <ul class="text-xs text-red-700 space-y-0.5 list-disc list-inside">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <button @click="open = !open"
                            class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors text-sm shadow-sm">
                        <span x-show="!open">Pedir orçamento gratuito</span>
                        <span x-show="open" x-cloak>Fechar formulário</span>
                    </button>

                    {{-- Quote form (anonymous) --}}
                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="mt-5">
                        <form method="POST" action="{{ route('orcamentos.store') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="provider_id" value="{{ $provider->id }}">

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                           placeholder="O seu nome"
                                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('name') border-red-300 @enderror">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Telefone</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                           placeholder="+351 9xx xxx xxx"
                                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       placeholder="para receber a resposta"
                                       class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('email') border-red-300 @enderror">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Descrição <span class="text-red-500">*</span></label>
                                <textarea name="description" rows="4" required
                                          placeholder="Descreve o que precisas com o máximo de detalhe..."
                                          class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Prazo</label>
                                    <input type="text" name="deadline" value="{{ old('deadline') }}"
                                           placeholder="Ex: 2 semanas"
                                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Orçamento est.</label>
                                    <input type="text" name="budget_range" value="{{ old('budget_range') }}"
                                           placeholder="Ex: €200–500"
                                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors text-sm shadow-sm">
                                Enviar pedido de orçamento
                            </button>

                            <p class="text-xs text-center text-gray-400">Sem registo necessário · Gratuito</p>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Contact info --}}
            @if($provider->phone || $provider->website || $provider->whatsapp || $provider->instagram)
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
                    @if($provider->instagram)
                        <a href="https://instagram.com/{{ ltrim($provider->instagram, '@') }}" target="_blank" rel="noopener"
                           class="flex items-center gap-3 text-sm text-gray-600 hover:text-pink-600 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            {{ $provider->instagram }}
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
