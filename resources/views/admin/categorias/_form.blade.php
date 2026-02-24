{{-- Shared create form fields --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name') }}" required
           class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
           placeholder="Ex: Serviços Jurídicos">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
    <textarea name="description" rows="2"
              class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="Breve descrição...">{{ old('description') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ícone (emoji)</label>
    <input type="text" name="icon" value="{{ old('icon') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
           placeholder="⚖️">
</div>
<label class="flex items-center gap-2 cursor-pointer">
    <input type="checkbox" name="is_active" value="1" checked
           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
    <span class="text-sm text-gray-700">Categoria activa</span>
</label>
