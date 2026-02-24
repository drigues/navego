@php $isEdit = isset($guide) && $guide->exists; @endphp

<x-admin-layout :title="$isEdit ? 'Editar Guia' : 'Novo Guia'">

    <x-slot name="head">
        <script src="https://cdn.jsdelivr.net/npm/marked@9/marked.min.js"></script>
    </x-slot>

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.guias') }}"
           class="p-2 rounded-lg text-gray-400 hover:bg-gray-200 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900">{{ $isEdit ? 'Editar Guia' : 'Novo Guia' }}</h2>
    </div>

    <form action="{{ $isEdit ? route('admin.guias.update', $guide) : route('admin.guias.store') }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @if($isEdit) @method('PUT') @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="lg:col-span-3 bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                <ul class="text-sm text-red-700 list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        {{-- LEFT: Main content --}}
        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Conteúdo</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Título <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $guide->title ?? '') }}" required
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Título do guia">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Excerto</label>
                        <textarea name="excerpt" rows="2"
                                  class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Resumo breve exibido na listagem (máx. 500 caracteres)">{{ old('excerpt', $guide->excerpt ?? '') }}</textarea>
                    </div>

                    {{-- Markdown editor --}}
                    <div x-data="{
                        tab: 'write',
                        content: @js(old('content', $guide->content ?? '')),
                        preview: '',
                        updatePreview() {
                            this.preview = marked.parse(this.content);
                        }
                    }">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-medium text-gray-700">Conteúdo (Markdown) <span class="text-red-500">*</span></label>
                            <div class="flex border border-gray-200 rounded-lg overflow-hidden text-xs font-medium">
                                <button type="button" @click="tab = 'write'"
                                        :class="tab === 'write' ? 'bg-indigo-600 text-white' : 'text-gray-500 hover:bg-gray-50'"
                                        class="px-3 py-1.5 transition-colors">Escrever</button>
                                <button type="button" @click="tab = 'preview'; updatePreview()"
                                        :class="tab === 'preview' ? 'bg-indigo-600 text-white' : 'text-gray-500 hover:bg-gray-50'"
                                        class="px-3 py-1.5 transition-colors border-l border-gray-200">Pré-visualizar</button>
                            </div>
                        </div>

                        <div x-show="tab === 'write'">
                            <textarea name="content" x-model="content" rows="22" required
                                      class="w-full rounded-lg border-gray-300 shadow-sm text-sm font-mono focus:ring-indigo-500 focus:border-indigo-500 resize-y"
                                      placeholder="# Título\n\nEscreve o conteúdo em Markdown..."></textarea>
                        </div>
                        <div x-show="tab === 'preview'" x-cloak
                             class="min-h-[22rem] p-4 rounded-lg border border-gray-300 bg-white prose prose-sm max-w-none"
                             x-html="preview"></div>
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT: Meta --}}
        <div class="space-y-5">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Publicação</h3>
                </div>
                <div class="p-5 space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Estado <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="draft"     {{ old('status', $guide->status ?? 'draft') === 'draft'     ? 'selected' : '' }}>Rascunho</option>
                            <option value="published" {{ old('status', $guide->status ?? '') === 'published' ? 'selected' : '' }}>Publicado</option>
                            <option value="archived"  {{ old('status', $guide->status ?? '') === 'archived'  ? 'selected' : '' }}>Arquivado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Data de publicação</label>
                        <input type="datetime-local" name="published_at"
                               value="{{ old('published_at', isset($guide->published_at) ? $guide->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="text-xs text-gray-400 mt-1">Deixa em branco para usar a data actual ao publicar.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Idioma <span class="text-red-500">*</span></label>
                        <select name="language" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach(['pt' => 'Português', 'en' => 'Inglês', 'es' => 'Espanhol', 'fr' => 'Francês'] as $code => $name)
                                <option value="{{ $code }}" {{ old('language', $guide->language ?? 'pt') === $code ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Categoria</label>
                        <select name="category_id" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">— Sem categoria —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $guide->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tags</label>
                        <input type="text" name="tags"
                               value="{{ old('tags', is_array($guide->tags ?? null) ? implode(', ', $guide->tags) : '') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="nif, documentos, portugal">
                        <p class="text-xs text-gray-400 mt-1">Separadas por vírgula.</p>
                    </div>

                    @if($isEdit)
                        <dl class="text-xs text-gray-400 space-y-1 pt-2 border-t border-gray-100">
                            <div class="flex justify-between">
                                <dt>Vistas</dt><dd class="font-medium text-gray-600">{{ number_format($guide->views_count) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Criado</dt><dd>{{ $guide->created_at->format('d/m/Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Actualizado</dt><dd>{{ $guide->updated_at->format('d/m/Y') }}</dd>
                            </div>
                        </dl>
                    @endif

                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.guias') }}"
                   class="flex-1 text-center px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                    {{ $isEdit ? 'Guardar' : 'Criar guia' }}
                </button>
            </div>
        </div>

    </form>

</x-admin-layout>
