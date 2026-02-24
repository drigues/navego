@props(["title" => null, "description" => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — Navego' : 'Navego — O teu guia em Portugal' }}</title>
    <meta name="description" content="{{ $description ?? 'Encontra prestadores de serviços de confiança para imigrantes em Portugal.' }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased bg-white text-gray-900">

{{-- ===================== NAVBAR ===================== --}}
<header x-data="{ open: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 10"
        :class="scrolled ? 'shadow-md' : 'shadow-sm'"
        class="sticky top-0 z-50 bg-white border-b border-gray-100 transition-shadow duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-indigo-600 tracking-tight">Navego</span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-1">
                @foreach([
                    ['route' => 'servicos.index', 'label' => 'Serviços'],
                    ['route' => 'guias.index',    'label' => 'Guias'],
                    ['route' => 'noticias.index', 'label' => 'Notícias'],
                    ['route' => 'sobre',          'label' => 'Sobre'],
                ] as $link)
                    <a href="{{ route($link['route']) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                              {{ request()->routeIs(explode('.', $link['route'])[0].'*')
                                 ? 'text-indigo-600 bg-indigo-50'
                                 : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Auth buttons (desktop) --}}
            <div class="hidden md:flex items-center gap-2">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @if(auth()->user()->hasRole('admin'))
                                <x-dropdown-link href="{{ route('admin.dashboard') }}">Painel Admin</x-dropdown-link>
                            @elseif(auth()->user()->hasRole('provider'))
                                <x-dropdown-link href="{{ route('prestador.dashboard') }}">Painel Prestador</x-dropdown-link>
                            @endif
                            <x-dropdown-link href="{{ route('profile.edit') }}">Perfil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Sair
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                        Registar
                    </a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open = !open"
                    class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            @foreach([
                ['route' => 'servicos.index', 'label' => 'Serviços'],
                ['route' => 'guias.index',    'label' => 'Guias'],
                ['route' => 'noticias.index', 'label' => 'Notícias'],
                ['route' => 'sobre',          'label' => 'Sobre'],
            ] as $link)
                <a href="{{ route($link['route']) }}" @click="open = false"
                   class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
        <div class="px-4 py-3 border-t border-gray-100 flex gap-2">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg">Dashboard</a>
                @elseif(auth()->user()->hasRole('provider'))
                    <a href="{{ route('prestador.dashboard') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Sair</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Entrar</a>
                <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg">Registar</a>
            @endauth
        </div>
    </div>
</header>

{{-- Flash messages --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-20 right-4 z-50 max-w-sm bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 shadow-lg flex items-start gap-3"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full">
        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
        <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

{{-- Page content --}}
<main>{{ $slot }}</main>

{{-- ===================== FOOTER ===================== --}}
<footer class="bg-gray-900 text-gray-300 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Navego</span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed">
                    A plataforma que liga imigrantes a prestadores de serviços de confiança em Portugal.
                </p>
                <p class="mt-4 text-xs text-gray-500">🇵🇹 Feito com orgulho em Portugal</p>
            </div>

            {{-- Plataforma --}}
            <div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Plataforma</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['route' => 'servicos.index', 'label' => 'Encontrar Serviços'],
                        ['route' => 'guias.index',    'label' => 'Guias para Imigrantes'],
                        ['route' => 'noticias.index', 'label' => 'Notícias'],
                        ['route' => 'sobre',          'label' => 'Sobre o Navego'],
                    ] as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="text-sm text-gray-400 hover:text-white transition-colors">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Para Prestadores --}}
            <div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Para Prestadores</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['route' => 'register', 'label' => 'Registar como Prestador'],
                        ['route' => 'login',    'label' => 'Área do Prestador'],
                    ] as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="text-sm text-gray-400 hover:text-white transition-colors">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Apoio --}}
            <div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Apoio</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Centro de Ajuda</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Política de Privacidade</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Termos de Utilização</a></li>
                    <li><a href="mailto:suporte@navego.pt" class="hover:text-white transition-colors">suporte@navego.pt</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
            <p>© {{ date('Y') }} Navego. Todos os direitos reservados.</p>
            <p>Construído para imigrantes, por pessoas que conhecem o caminho.</p>
        </div>
    </div>
</footer>

</body>
</html>
