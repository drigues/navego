<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel do Prestador — Navego
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @php $provider = auth()->user()->provider; @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                        Bem-vindo, {{ auth()->user()->name }}!
                    </h3>
                    @if($provider)
                        <p class="text-sm text-gray-500">
                            A gerir: <span class="font-medium text-emerald-600">{{ $provider->business_name }}</span>
                            @if($provider->is_verified)
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700">
                                    Verificado ✓
                                </span>
                            @endif
                        </p>
                    @else
                        <p class="text-sm text-amber-600 font-medium">
                            O teu perfil de prestador ainda não está configurado.
                        </p>
                    @endif
                </div>
            </div>

            @if($provider)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach([
                        ['label' => 'Serviços Ativos', 'value' => $provider->activeServices()->count(), 'color' => 'emerald'],
                        ['label' => 'Orçamentos Pendentes', 'value' => $provider->quotes()->where('status','pending')->count(), 'color' => 'amber'],
                        ['label' => 'Orçamentos Concluídos', 'value' => $provider->quotes()->where('status','completed')->count(), 'color' => 'indigo'],
                    ] as $card)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                            <p class="text-3xl font-bold text-{{ $card['color'] }}-600">{{ $card['value'] }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $card['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
