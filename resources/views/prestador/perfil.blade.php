<x-prestador-layout title="Perfil Público">

    <div class="max-w-3xl">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Editar Perfil Público</h2>
                <p class="text-sm text-gray-500 mt-0.5">As alterações ficam visíveis no teu perfil público imediatamente.</p>
            </div>
            <a href="{{ route('servicos.show', $provider->slug) }}" target="_blank"
               class="inline-flex items-center gap-1.5 text-sm text-indigo-600 hover:underline font-medium">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Ver perfil
            </a>
        </div>

        <form action="{{ route('prestador.perfil.update') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                    <p class="text-sm font-semibold text-red-800 mb-2">Corrige os seguintes erros:</p>
                    <ul class="text-sm text-red-700 list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ── Informações da Empresa ── --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Informações da Empresa</h3>
                </div>
                <div class="p-5 space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nome da empresa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="business_name"
                               value="{{ old('business_name', $provider->business_name) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                        <p class="text-xs text-gray-400 mt-1">O slug da URL será actualizado automaticamente.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
                        <textarea name="description" rows="4"
                                  class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Descreve os teus serviços, experiência e o que te diferencia...">{{ old('description', $provider->description) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Máx. 3000 caracteres.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">NIF</label>
                            <input type="text" name="nif" value="{{ old('nif', $provider->nif) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="123456789">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Website</label>
                            <input type="url" name="website" value="{{ old('website', $provider->website) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="https://www.exemplo.pt">
                        </div>
                    </div>

                    {{-- Languages --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Idiomas falados</label>
                        @php
                            $allLangs = [
                                'pt' => 'Português', 'en' => 'Inglês', 'es' => 'Espanhol',
                                'fr' => 'Francês',   'de' => 'Alemão', 'uk' => 'Ucraniano',
                                'ru' => 'Russo',     'ar' => 'Árabe',  'zh' => 'Chinês',
                                'hi' => 'Hindi',     'ur' => 'Urdu',   'kri' => 'Crioulo',
                            ];
                            $selectedLangs = old('languages', $provider->languages ?? []);
                        @endphp
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                            @foreach($allLangs as $code => $name)
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-colors text-sm">
                                    <input type="checkbox" name="languages[]" value="{{ $code }}"
                                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                           {{ in_array($code, $selectedLangs) ? 'checked' : '' }}>
                                    <span class="text-gray-700">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Remote --}}
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="serves_remote" id="serves_remote"
                               value="1"
                               class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                               {{ old('serves_remote', $provider->serves_remote) ? 'checked' : '' }}>
                        <label for="serves_remote" class="text-sm font-medium text-gray-700 cursor-pointer">
                            Atendo clientes remotamente (online / videochamada)
                        </label>
                    </div>

                </div>
            </div>

            {{-- ── Contactos ── --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Contactos</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Telefone</label>
                            <input type="text" name="phone" value="{{ old('phone', $provider->phone) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="+351 912 345 678">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $provider->whatsapp) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="+351 912 345 678">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email de contacto</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $provider->contact_email) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="geral@empresa.pt">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Localização ── --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Localização</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Morada</label>
                        <input type="text" name="address" value="{{ old('address', $provider->address) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Rua Exemplo, 123">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Cidade</label>
                            <input type="text" name="city" value="{{ old('city', $provider->city) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Lisboa">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Distrito</label>
                            <input type="text" name="district" value="{{ old('district', $provider->district) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Lisboa">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Código Postal</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $provider->postal_code) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="1000-001">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Redes Sociais ── --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Redes Sociais</h3>
                </div>
                <div class="p-5 space-y-4">
                    @php $social = $provider->social_links ?? []; @endphp
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Facebook</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-sm">facebook.com/</span>
                            <input type="url" name="facebook" value="{{ old('facebook', $social['facebook'] ?? '') }}"
                                   class="w-full pl-28 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="https://facebook.com/a-tua-pagina">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Instagram</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-sm">@</span>
                            <input type="url" name="instagram" value="{{ old('instagram', $social['instagram'] ?? '') }}"
                                   class="w-full pl-7 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="https://instagram.com/o-teu-perfil">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">LinkedIn</label>
                        <input type="url" name="linkedin" value="{{ old('linkedin', $social['linkedin'] ?? '') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="https://linkedin.com/in/o-teu-perfil">
                    </div>
                </div>
            </div>

            {{-- ── Horário de Funcionamento ── --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Horário de Funcionamento</h3>
                </div>
                <div class="p-5">
                    @php
                        $wh = $provider->working_hours ?? [];
                        $days = [
                            'seg' => 'Segunda', 'ter' => 'Terça', 'qua' => 'Quarta',
                            'qui' => 'Quinta',  'sex' => 'Sexta', 'sab' => 'Sábado', 'dom' => 'Domingo',
                        ];
                    @endphp
                    <div class="space-y-3">
                        @foreach($days as $key => $label)
                            @php
                                $dayData = is_array($wh[$key] ?? null) ? $wh[$key] : ['closed' => false, 'open' => '09:00', 'close' => '18:00'];
                                $isClosed = $dayData['closed'] ?? false;
                            @endphp
                            <div x-data="{ closed: {{ $isClosed ? 'true' : 'false' }} }"
                                 class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                                <span class="w-24 text-sm font-medium text-gray-700 shrink-0">{{ $label }}</span>
                                <label class="flex items-center gap-1.5 cursor-pointer shrink-0">
                                    <input type="checkbox" name="wh_{{ $key }}_closed" value="1"
                                           x-model="closed"
                                           class="rounded border-gray-300 text-gray-400 focus:ring-gray-300"
                                           {{ $isClosed ? 'checked' : '' }}>
                                    <span class="text-xs text-gray-500">Fechado</span>
                                </label>
                                <div class="flex items-center gap-2 flex-1" :class="closed ? 'opacity-30 pointer-events-none' : ''">
                                    <input type="time" name="wh_{{ $key }}_open"
                                           value="{{ $dayData['open'] ?? '09:00' }}"
                                           class="rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 flex-1">
                                    <span class="text-gray-400 text-sm shrink-0">até</span>
                                    <input type="time" name="wh_{{ $key }}_close"
                                           value="{{ $dayData['close'] ?? '18:00' }}"
                                           class="rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 flex-1">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('prestador.dashboard') }}"
                   class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                    Guardar alterações
                </button>
            </div>

        </form>
    </div>

</x-prestador-layout>
