@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Visão Geral</h2>
            <p class="text-sm text-gray-400 mt-0.5">{{ now()->format('d \d\e F \d\e Y') }}</p>
        </div>
    </div>

    {{-- 5 stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

        {{-- 1. Total Prestadores --}}
        <a href="{{ route('admin.prestadores') }}"
           class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['providers_total'] }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Total Prestadores</p>
        </a>

        {{-- 2. Pendentes — destaque vermelho --}}
        <a href="{{ route('admin.prestadores', ['status' => 'pending']) }}"
           class="bg-white rounded-xl border-2 border-red-200 shadow-sm p-5 hover:shadow-md transition-shadow group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-red-50 rounded-bl-full opacity-50"></div>
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                @if($stats['providers_pending'] > 0)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        Urgente
                    </span>
                @endif
            </div>
            <p class="text-3xl font-bold text-red-600">{{ $stats['providers_pending'] }}</p>
            <p class="text-sm text-red-500 font-medium mt-0.5">Pendentes de Aprovação</p>
        </a>

        {{-- 3. Orçamentos Hoje --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['quotes_today'] }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Orçamentos Hoje</p>
        </div>

        {{-- 4. Utilizadores --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['users'] }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Utilizadores</p>
        </div>

        {{-- 5. Guias Publicados --}}
        <a href="{{ route('admin.guias', ['status' => 'published']) }}"
           class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['guides_published'] }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Guias Publicados</p>
        </a>

    </div>

    {{-- Two-col: pending providers + recent quotes --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Prestadores pendentes --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Prestadores Pendentes</h3>
                <a href="{{ route('admin.prestadores', ['status' => 'pending']) }}"
                   class="text-xs text-indigo-600 hover:underline font-medium">Ver todos →</a>
            </div>
            @if($recentProviders->isEmpty())
                <div class="px-5 py-10 text-center">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400">Nenhum prestador pendente.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($recentProviders as $prov)
                        <div class="flex items-center gap-3 px-5 py-3.5">
                            <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-bold text-sm shrink-0">
                                {{ strtoupper(substr($prov->business_name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $prov->business_name }}</p>
                                <p class="text-xs text-gray-400">{{ $prov->user->name }} · {{ $prov->city ?? '—' }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <form action="{{ route('admin.prestadores.aprovar', $prov) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="px-3 py-1 text-xs font-semibold text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg transition-colors">
                                        Aprovar
                                    </button>
                                </form>
                                <a href="{{ route('admin.prestadores.show', $prov) }}"
                                   class="px-3 py-1 text-xs font-medium text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    Ver
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Orçamentos recentes --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Orçamentos Recentes</h3>
            </div>
            @if($recentQuotes->isEmpty())
                <div class="px-5 py-10 text-center">
                    <p class="text-sm text-gray-400">Sem orçamentos novos.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($recentQuotes as $quote)
                        <div class="flex items-center gap-3 px-5 py-3.5">
                            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-sm shrink-0">
                                {{ strtoupper(substr($quote->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $quote->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $quote->email }} → {{ $quote->provider->business_name ?? '—' }}</p>
                            </div>
                            <span class="shrink-0 text-xs text-gray-400 whitespace-nowrap">{{ $quote->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- Quick access --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Novo Guia',    'route' => 'admin.guias.create',    'color' => '#7C3AED', 'icon' => 'M12 4v16m8-8H4'],
            ['label' => 'Nova Notícia', 'route' => 'admin.noticias.create', 'color' => '#DC2626', 'icon' => 'M12 4v16m8-8H4'],
            ['label' => 'Prestadores',  'route' => 'admin.prestadores',     'color' => '#059669', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['label' => 'Categorias',   'route' => 'admin.categorias',      'color' => '#1E3A5F', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
        ] as $action)
            <a href="{{ route($action['route']) }}"
               class="flex items-center gap-3 px-4 py-3.5 text-white rounded-xl font-medium text-sm hover:opacity-90 transition-opacity shadow-sm"
               style="background-color: {{ $action['color'] }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}"/>
                </svg>
                {{ $action['label'] }}
            </a>
        @endforeach
    </div>

@endsection
