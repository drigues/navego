<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Navego</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
    @yield('head')
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">

@php
    $pendingCount = \App\Models\Provider::where('status', \App\Models\Provider::STATUS_PENDING)->count();
    $navLinks = [
        [
            'route' => 'admin.dashboard',
            'label' => 'Dashboard',
            'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
        [
            'route' => 'admin.prestadores',
            'label' => 'Prestadores',
            'badge' => $pendingCount,
            'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
        ],
        [
            'route' => 'admin.categorias',
            'label' => 'Categorias',
            'icon'  => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
        ],
        [
            'route' => 'admin.guias',
            'label' => 'Guias',
            'icon'  => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        ],
        [
            'route' => 'admin.noticias',
            'label' => 'Notícias',
            'icon'  => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
        ],
        [
            'route' => 'admin.planos',
            'label' => 'Planos',
            'icon'  => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
        ],
    ];
@endphp

<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-black/60 lg:hidden"
         x-transition:enter="transition-opacity duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    {{-- ======= SIDEBAR ======= --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-30 w-64 flex flex-col
                  transform transition-transform duration-200 ease-in-out
                  lg:static lg:translate-x-0 lg:transition-none shrink-0"
           style="background-color: #7c3aed">

        {{-- Logo --}}
        <div class="h-16 flex items-center gap-3 px-5 shrink-0" style="border-bottom: 1px solid rgba(255,255,255,0.08)">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                 style="background-color: rgba(139,92,246,0.4)">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <div class="leading-tight">
                <span class="text-sm font-bold text-white tracking-wide">Navego</span>
                <span class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-bold tracking-widest"
                      style="background-color: rgba(167,139,250,0.2); color: #c4b5fd">ADMIN</span>
            </div>
        </div>

        {{-- User avatar --}}
        <div class="px-4 py-3.5 shrink-0" style="border-bottom: 1px solid rgba(255,255,255,0.08)">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                     style="background-color: rgba(139,92,246,0.5)">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs" style="color: rgba(196,181,253,0.7)">Administrador</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-0.5">
            @foreach($navLinks as $link)
                @php $active = request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*'); @endphp
                <a href="{{ route($link['route']) }}"
                   class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                          {{ $active ? 'text-white' : 'text-white/50 hover:text-white' }}"
                   style="{{ $active ? 'background-color: rgba(139,92,246,0.35)' : '' }}"
                   @if(!$active)
                       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.06)'"
                       onmouseout="this.style.backgroundColor=''"
                   @endif>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0 {{ $active ? 'text-violet-300' : '' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/>
                        </svg>
                        {{ $link['label'] }}
                    </div>
                    @if(isset($link['badge']) && $link['badge'] > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold rounded-full"
                              style="background-color: #fbbf24; color: #78350f">
                            {{ $link['badge'] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- Bottom --}}
        <div class="px-3 py-3 space-y-0.5 shrink-0" style="border-top: 1px solid rgba(255,255,255,0.08)">
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/50 hover:text-white transition-colors"
               onmouseover="this.style.backgroundColor='rgba(255,255,255,0.06)'"
               onmouseout="this.style.backgroundColor=''">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Ver site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/50 hover:text-white transition-colors text-left"
                        onmouseover="this.style.backgroundColor='rgba(255,255,255,0.06)'"
                        onmouseout="this.style.backgroundColor=''">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sair
                </button>
            </form>
        </div>
    </aside>

    {{-- ======= MAIN ======= --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-auto">

        {{-- Topbar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <p class="text-base font-bold text-gray-900">Admin Master</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:block text-sm font-medium text-gray-600">{{ auth()->user()->name }}</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Admin
                </span>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-cloak
                 x-init="setTimeout(() => show = false, 5000)"
                 class="mx-4 sm:mx-6 mt-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-3 flex items-center gap-3"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="text-sm font-medium flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-cloak
                 x-init="setTimeout(() => show = false, 6000)"
                 class="mx-4 sm:mx-6 mt-4 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-3 flex items-center gap-3"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium flex-1">{{ session('error') }}</p>
                <button @click="show = false" class="text-red-400 hover:text-red-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
