<x-public-layout title="Sobre o Navego">

{{-- Hero --}}
<section class="bg-gradient-to-br from-indigo-900 to-indigo-700 py-20 text-white text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-6 backdrop-blur-sm border border-white/10">
            <svg class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">Sobre o Navego</h1>
        <p class="text-xl text-indigo-200 leading-relaxed">
            Nascemos para tornar a vida dos imigrantes em Portugal mais simples, mais segura e mais conectada.
        </p>
    </div>
</section>

{{-- Mission --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 px-3 py-1.5 rounded-full uppercase tracking-wide">A nossa missão</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-4 mb-6 leading-tight">
                    Um guia de confiança<br>para cada imigrante
                </h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>
                        Chegar a Portugal é apenas o início. Navegar pelos sistemas de saúde, jurídico, fiscal e educacional de um novo país pode ser desafiante — especialmente sem conhecer as pessoas certas.
                    </p>
                    <p>
                        O <strong class="text-gray-900">Navego</strong> é uma plataforma que liga imigrantes a prestadores de serviços verificados: advogados de imigração, contabilistas, tradutores, médicos, professores de português e muito mais.
                    </p>
                    <p>
                        Acreditamos que cada imigrante merece ter acesso fácil a profissionais de confiança que conhecem a sua realidade e falam a sua língua.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Prestadores Verificados', 'desc' => 'Todos os profissionais passam por um processo de verificação de credenciais.'],
                    ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title' => 'Na Tua Língua', 'desc' => 'Encontra profissionais que falam português, inglês, espanhol, francês e mais.'],
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13', 'title' => 'Guias Práticos', 'desc' => 'Conteúdo editorial sobre como navegar os sistemas portugueses.'],
                    ['icon' => 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z', 'title' => 'Orçamentos Diretos', 'desc' => 'Pede orçamentos diretamente a prestadores sem intermediários.'],
                ] as $feat)
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feat['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-sm mb-1">{{ $feat['title'] }}</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $feat['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Os nossos valores</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Guiamo-nos por princípios que colocam os imigrantes e os prestadores em primeiro lugar.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['emoji' => '🤝', 'title' => 'Confiança', 'desc' => 'Verificamos os prestadores e promovemos transparência em todos os processos.'],
                ['emoji' => '🌍', 'title' => 'Inclusão', 'desc' => 'Servimos imigrantes de todas as origens, idiomas e culturas.'],
                ['emoji' => '⚡', 'title' => 'Simplicidade', 'desc' => 'Tornamos processos complexos simples e acessíveis a todos.'],
                ['emoji' => '🔒', 'title' => 'Privacidade', 'desc' => 'Os teus dados pessoais são protegidos e nunca partilhados sem consentimento.'],
                ['emoji' => '💬', 'title' => 'Comunicação', 'desc' => 'Facilitamos conversas diretas entre imigrantes e prestadores.'],
                ['emoji' => '🌱', 'title' => 'Impacto Social', 'desc' => 'Acreditamos que a integração bem-sucedida beneficia toda a sociedade portuguesa.'],
            ] as $val)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="text-3xl mb-3">{{ $val['emoji'] }}</div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $val['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $val['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- For providers CTA --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-3xl p-10 sm:p-16 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Junta-te ao Navego</h2>
            <p class="text-indigo-200 text-lg mb-8 max-w-xl mx-auto">
                Seja imigrante à procura de serviços ou prestador à procura de novos clientes — há um lugar para ti no Navego.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                   class="px-8 py-4 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-indigo-50 transition-colors shadow-md">
                    Criar conta gratuita
                </a>
                <a href="{{ route('servicos.index') }}"
                   class="px-8 py-4 border-2 border-white/40 text-white font-semibold rounded-xl hover:bg-white/10 transition-colors">
                    Explorar serviços
                </a>
            </div>
        </div>
    </div>
</section>

</x-public-layout>
