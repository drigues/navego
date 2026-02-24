<x-prestador-layout title="Plano">

    <div class="max-w-4xl">

        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900">O teu Plano</h2>
            <p class="text-sm text-gray-500 mt-0.5">
                Actualmente estás no plano
                <span class="font-semibold {{ $provider->plan === 'pro' ? 'text-indigo-600' : 'text-gray-700' }}">
                    {{ $plans[$provider->plan]['name'] }}
                </span>.
            </p>
        </div>

        {{-- Plan cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

            @foreach($plans as $key => $plan)
                @php $isCurrent = $provider->plan === $key; @endphp

                <div class="relative bg-white rounded-2xl border-2 shadow-sm overflow-hidden transition-shadow hover:shadow-md
                            {{ $key === 'pro' ? 'border-indigo-500' : 'border-gray-200' }}">

                    @if($key === 'pro')
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
                    @endif

                    {{-- Popular badge --}}
                    @if($key === 'pro')
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                                ★ Recomendado
                            </span>
                        </div>
                    @endif

                    <div class="p-6">
                        {{-- Plan name + price --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-bold {{ $key === 'pro' ? 'text-indigo-700' : 'text-gray-900' }}">
                                {{ $plan['name'] }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $plan['description'] }}</p>
                            <div class="mt-4 flex items-baseline gap-1">
                                @if($plan['price'] === 0)
                                    <span class="text-4xl font-extrabold text-gray-900">Grátis</span>
                                @else
                                    <span class="text-4xl font-extrabold {{ $key === 'pro' ? 'text-indigo-700' : 'text-gray-900' }}">
                                        {{ $plan['price'] }} €
                                    </span>
                                    <span class="text-gray-500 text-sm">{{ $plan['period'] }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- CTA button --}}
                        @if($isCurrent)
                            <div class="w-full py-2.5 px-4 text-center text-sm font-medium rounded-xl
                                        {{ $key === 'pro' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                                Plano actual ✓
                            </div>
                        @elseif($key === 'pro')
                            <form action="{{ route('prestador.plano.upgrade') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="pro">
                                <button type="submit"
                                        class="w-full py-2.5 px-4 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors shadow-sm">
                                    Fazer upgrade para PRO
                                </button>
                            </form>
                        @else
                            <form action="{{ route('prestador.plano.upgrade') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan" value="basic">
                                <button type="submit"
                                        onclick="return confirm('Queres mesmo voltar ao plano Básico? Perderás as funcionalidades PRO.')"
                                        class="w-full py-2.5 px-4 text-sm font-medium text-gray-500 border border-gray-300 hover:bg-gray-50 rounded-xl transition-colors">
                                    Voltar ao Básico
                                </button>
                            </form>
                        @endif

                        {{-- Features --}}
                        <div class="mt-6 space-y-2.5">
                            @foreach($plan['features'] as $feature)
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 shrink-0 {{ $key === 'pro' ? 'text-indigo-500' : 'text-emerald-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach

                            @foreach($plan['missing'] as $missing)
                                <div class="flex items-center gap-2.5 opacity-40">
                                    <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span class="text-sm text-gray-500 line-through">{{ $missing }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Feature comparison table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-900">Comparação detalhada</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left px-6 py-3 font-medium text-gray-500 w-1/2">Funcionalidade</th>
                            <th class="text-center px-6 py-3 font-semibold text-gray-700 w-1/4">Básico</th>
                            <th class="text-center px-6 py-3 font-semibold text-indigo-700 w-1/4 bg-indigo-50/50">PRO</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                        $comparison = [
                            ['feature' => 'Perfil público',              'basic' => true,     'pro' => true],
                            ['feature' => 'Serviços publicados',         'basic' => 'Até 3',  'pro' => 'Ilimitados'],
                            ['feature' => 'Pedidos de orçamento',        'basic' => true,     'pro' => true],
                            ['feature' => 'Gestão de orçamentos (CRM)',  'basic' => true,     'pro' => true],
                            ['feature' => 'Selo de verificação PRO',     'basic' => false,    'pro' => true],
                            ['feature' => 'Destaque nos resultados',     'basic' => false,    'pro' => true],
                            ['feature' => 'Estatísticas avançadas',      'basic' => false,    'pro' => true],
                            ['feature' => 'Suporte prioritário',         'basic' => false,    'pro' => true],
                            ['feature' => 'Notificações por email',      'basic' => true,     'pro' => true],
                            ['feature' => 'Funcionalidades antecipadas', 'basic' => false,    'pro' => true],
                        ];
                        @endphp
                        @foreach($comparison as $row)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-3.5 text-gray-700">{{ $row['feature'] }}</td>
                                <td class="px-6 py-3.5 text-center">
                                    @if($row['basic'] === true)
                                        <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @elseif($row['basic'] === false)
                                        <svg class="w-4 h-4 text-gray-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    @else
                                        <span class="text-sm text-gray-600">{{ $row['basic'] }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 text-center bg-indigo-50/30">
                                    @if($row['pro'] === true)
                                        <svg class="w-5 h-5 text-indigo-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @elseif($row['pro'] === false)
                                        <svg class="w-4 h-4 text-gray-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    @else
                                        <span class="text-sm font-medium text-indigo-700">{{ $row['pro'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FAQ --}}
        <div class="mt-8 space-y-3">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Perguntas Frequentes</h3>

            @foreach([
                ['q' => 'Posso cancelar o plano PRO a qualquer momento?', 'a' => 'Sim. Podes fazer downgrade para o plano Básico a qualquer momento, sem custo adicional. O acesso PRO mantém-se até ao final do período pago.'],
                ['q' => 'Como é feito o pagamento?', 'a' => 'O pagamento é processado mensalmente por cartão de crédito ou débito. A primeira cobrança ocorre imediatamente após o upgrade.'],
                ['q' => 'O que acontece aos meus serviços se fizer downgrade?', 'a' => 'Se tiveres mais de 3 serviços activos, os excedentes serão desactivados automaticamente após o downgrade. Poderás reactivar até 3 deles.'],
            ] as $faq)
                <details class="group bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <summary class="flex items-center justify-between px-5 py-4 cursor-pointer text-sm font-medium text-gray-900 list-none hover:bg-gray-50 transition-colors">
                        {{ $faq['q'] }}
                        <svg class="w-4 h-4 text-gray-400 shrink-0 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">{{ $faq['a'] }}</div>
                </details>
            @endforeach
        </div>

        {{-- Support --}}
        <div class="mt-8 bg-indigo-50 border border-indigo-100 rounded-2xl p-6 flex items-center gap-5">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-indigo-900">Tens dúvidas?</p>
                <p class="text-sm text-indigo-700 mt-0.5">Entra em contacto connosco por email — respondemos em menos de 24 horas.</p>
                <a href="mailto:suporte@navego.pt" class="text-sm font-medium text-indigo-600 hover:underline mt-1 inline-block">suporte@navego.pt</a>
            </div>
        </div>

    </div>

</x-prestador-layout>
