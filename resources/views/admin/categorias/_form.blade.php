{{-- Shared create form fields (used in create modal) --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name') }}" required
           class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
           placeholder="Ex: Serviços Jurídicos">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Categoria Pai</label>
    <select name="parent_id" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">— Nenhuma (categoria raiz) —</option>
        @foreach($parents as $p)
            <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
    <textarea name="description" rows="2"
              class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="Breve descrição da categoria...">{{ old('description') }}</textarea>
</div>
<div class="grid grid-cols-3 gap-3">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Ícone (emoji)</label>
        <input type="text" name="icon" value="{{ old('icon') }}"
               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="⚖️">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Cor hex</label>
        <input type="text" name="color" value="{{ old('color') }}"
               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="#6366f1">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Ordem</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
    </div>
</div>
<label class="flex items-center gap-2 cursor-pointer">
    <input type="checkbox" name="is_active" value="1" checked
           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
    <span class="text-sm text-gray-700">Categoria activa</span>
</label>
