@extends('layouts.admin')

@section('title', 'Detalhes do Prestador')

@section('content')

    @php
    $statusConfig = [
        'pending'  => ['label' => 'Pendente',  'badge' => 'bg-amber-100 text-amber-700'],
        'active'   => ['label' => 'Activo',    'badge' => 'bg-emerald-100 text-emerald-700'],
        'rejected' => ['label' => 'Rejeitado', 'badge' => 'bg-red-100 text-red-700'],
    ];
    $sc = $statusConfig[$provider->status] ?? $statusConfig['pending'];
    @endphp

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.prestadores') }}"
           class="p-2 rounded-lg text-gray-400 hover:bg-gray-200 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900">{{ $provider->business_name }}</h2>
        <span class="ml-auto inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium {{ $sc['badge'] }}">
            {{ $sc['label'] }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: info --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Business info --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Informações</h3>
                </div>
                <dl class="divide-y divide-gray-50">
                    @foreach([
                        ['label' => 'Empresa',   'value' => $provider->business_name],
                        ['label' => 'Cidade',    'value' => $provider->city ?? '—'],
                        ['label' => 'Morada',    'value' => $provider->address ?? '—'],
                        ['label' => 'Telefone',  'value' => $provider->phone ?? '—'],
                        ['label' => 'WhatsApp',  'value' => $provider->whatsapp ?? '—'],
                        ['label' => 'Instagram', 'value' => $provider->instagram ? '@' . $provider->instagram : '—'],
                        ['label' => 'Website',   'value' => $provider->website ?? '—'],
                        ['label' => 'Plano',     'value' => strtoupper($provider->plan ?? 'basic')],
                    ] as $row)
                        <div class="flex gap-4 px-5 py-3">
                            <dt class="text-xs text-gray-400 w-24 shrink-0 pt-0.5">{{ $row['label'] }}</dt>
                            <dd class="text-sm text-gray-700 flex-1 break-all">{{ $row['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Description --}}
            @if($provider->description)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Descrição</h3>
                    </div>
                    <div class="px-5 py-4 text-sm text-gray-700 leading-relaxed">{{ $provider->description }}</div>
                </div>
            @endif

        </div>

        {{-- Right: actions --}}
        <div class="space-y-5">

            {{-- User --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Utilizador</h3>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                            {{ strtoupper(substr($provider->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $provider->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $provider->user->email }}</p>
                        </div>
                    </div>
                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Registado</dt>
                            <dd class="text-gray-700">{{ $provider->user->created_at->format('d/m/Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Orçamentos recebidos</dt>
                            <dd class="text-gray-700">{{ $provider->quotes->count() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Acções</h3>
                </div>
                <div class="p-4 space-y-2">
                    @if($provider->status !== 'active')
                        <form action="{{ route('admin.prestadores.aprovar', $provider) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg transition-colors shadow-sm">
                                ✓ Aprovar prestador
                            </button>
                        </form>
                    @endif
                    @if($provider->status !== 'rejected')
                        <form action="{{ route('admin.prestadores.rejeitar', $provider) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    onclick="return confirm('Rejeitar {{ addslashes($provider->business_name) }}?')"
                                    class="w-full px-4 py-2.5 text-sm font-medium text-red-600 border border-red-200 hover:bg-red-50 rounded-lg transition-colors">
                                ✗ Rejeitar / Suspender
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('servicos.show', $provider->slug) }}" target="_blank"
                       class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Ver perfil público
                    </a>
                </div>
            </div>

            {{-- Quotes summary --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Orçamentos</h3>
                </div>
                <dl class="divide-y divide-gray-50">
                    @foreach([
                        ['label' => 'Total',      'value' => $provider->quotes->count()],
                        ['label' => 'Novos',      'value' => $provider->quotes->where('status', 'new')->count()],
                        ['label' => 'Respondidos','value' => $provider->quotes->where('status', 'replied')->count()],
                        ['label' => 'Fechados',   'value' => $provider->quotes->where('status', 'closed')->count()],
                    ] as $row)
                        <div class="flex justify-between px-5 py-2.5 text-sm">
                            <dt class="text-gray-400">{{ $row['label'] }}</dt>
                            <dd class="font-medium text-gray-900">{{ $row['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

        </div>
    </div>

@endsection
