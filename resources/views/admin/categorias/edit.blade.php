@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categorias') }}"
           class="p-2 rounded-lg text-gray-400 hover:bg-gray-200 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900">Editar Categoria</h2>
    </div>

    <div class="max-w-lg">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-900">{{ $category->name }}</h3>
            </div>
            <form action="{{ route('admin.categorias.update', $category) }}" method="POST" class="p-5 space-y-4">
                @csrf @method('PATCH')

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                        <ul class="text-sm text-red-700 list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
                    <textarea name="description" rows="2"
                              class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $category->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ícone (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="⚖️">
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-gray-700">Categoria activa</span>
                </label>
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('admin.categorias') }}"
                       class="flex-1 text-center px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                        Guardar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
