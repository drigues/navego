<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel de Administração — Navego
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                        Bem-vindo, {{ auth()->user()->name }}!
                    </h3>
                    <p class="text-sm text-gray-500">
                        Estás a aceder como <span class="font-medium text-indigo-600">Administrador</span>.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label' => 'Utilizadores', 'model' => \App\Models\User::class, 'color' => 'indigo'],
                    ['label' => 'Prestadores', 'model' => \App\Models\Provider::class, 'color' => 'emerald'],
                    ['label' => 'Serviços', 'model' => \App\Models\Service::class, 'color' => 'amber'],
                    ['label' => 'Orçamentos', 'model' => \App\Models\Quote::class, 'color' => 'rose'],
                ] as $card)
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                        <p class="text-3xl font-bold text-{{ $card['color'] }}-600">
                            {{ $card['model']::count() }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">{{ $card['label'] }}</p>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
