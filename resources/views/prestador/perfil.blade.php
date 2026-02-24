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
            @method('PATCH')

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

            {{-- Success message --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl px-5 py-4 text-sm text-green-800 font-medium">
                    {{ session('success') }}
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
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Categoria</label>
                        <select name="category_id"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                            <option value="">Sem categoria</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $provider->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
                        <textarea name="description" rows="4"
                                  class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Descreve os teus serviços, experiência e o que te diferencia...">{{ old('description', $provider->description) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Máx. 3000 caracteres.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Website</label>
                        <input type="url" name="website" value="{{ old('website', $provider->website) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="https://www.exemplo.pt">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Instagram</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-sm">@</span>
                                <input type="text" name="instagram" value="{{ old('instagram', $provider->instagram) }}"
                                       class="w-full pl-7 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="o_teu_perfil">
                            </div>
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
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Cidade</label>
                        <input type="text" name="city" value="{{ old('city', $provider->city) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Lisboa">
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
