<x-admin-layout title="Categorias">

    <div x-data="{
        createModal: false,
        editModal: false,
        editData: {},
        openEdit(cat) {
            this.editData = cat;
            this.editModal = true;
        }
    }">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Categorias</h2>
            <button @click="createModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Categoria
            </button>
        </div>

        {{-- Search --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5">
            <form action="{{ route('admin.categorias') }}" method="GET" class="flex items-center gap-3 px-4 py-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Pesquisar categorias..."
                           class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm shrink-0">Pesquisar</button>
                @if(request('search'))
                    <a href="{{ route('admin.categorias') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium shrink-0">Limpar</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Nome</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Pai</th>
                            <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Subcats.</th>
                            <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Serviços</th>
                            <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Guias</th>
                            <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Ordem</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide px-5 py-3">Estado</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        @if($cat->icon)
                                            <span class="text-base leading-none">{{ $cat->icon }}</span>
                                        @endif
                                        @if($cat->color)
                                            <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $cat->color }}"></span>
                                        @endif
                                        <span class="font-medium text-gray-900">{{ $cat->name }}</span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-0.5 pl-0">{{ $cat->slug }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-gray-500 text-sm">{{ $cat->parent?->name ?? '—' }}</td>
                                <td class="px-5 py-3.5 text-center text-gray-700">{{ $cat->children_count }}</td>
                                <td class="px-5 py-3.5 text-center text-gray-700">{{ $cat->services_count }}</td>
                                <td class="px-5 py-3.5 text-center text-gray-700">{{ $cat->guides_count }}</td>
                                <td class="px-5 py-3.5 text-center text-gray-500">{{ $cat->sort_order }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                 {{ $cat->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $cat->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2 justify-end">
                                        <button @click="openEdit({{ json_encode(['id' => $cat->id, 'name' => $cat->name, 'parent_id' => $cat->parent_id, 'description' => $cat->description, 'icon' => $cat->icon, 'color' => $cat->color, 'sort_order' => $cat->sort_order, 'is_active' => $cat->is_active]) }})"
                                                class="px-2.5 py-1 text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition-colors">
                                            Editar
                                        </button>
                                        <form action="{{ route('admin.categorias.destroy', $cat) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Eliminar categoria {{ addslashes($cat->name) }}?')"
                                                    class="px-2.5 py-1 text-xs font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-sm text-gray-400">Nenhuma categoria encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($categories->hasPages())
            <div class="mt-4">{{ $categories->links() }}</div>
        @endif

        {{-- ── CREATE MODAL ── --}}
        <div x-show="createModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-black/50" @click="createModal = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">Nova Categoria</h3>
                    <button @click="createModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.categorias.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @include('admin.categorias._form', ['category' => null, 'parents' => $parents])
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="createModal = false"
                                class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                            Criar categoria
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── EDIT MODAL ── --}}
        <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-black/50" @click="editModal = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">Editar Categoria</h3>
                    <button @click="editModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form :action="`/admin/categorias/${editData.id}`" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome <span class="text-red-500">*</span></label>
                        <input type="text" name="name" :value="editData.name" required
                               class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Categoria Pai</label>
                        <select name="parent_id" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">— Nenhuma (categoria raiz) —</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}" :selected="editData.parent_id == {{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
                        <textarea name="description" rows="2" :value="editData.description"
                                  class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Ícone (emoji)</label>
                            <input type="text" name="icon" :value="editData.icon"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="🏠">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Cor</label>
                            <input type="text" name="color" :value="editData.color"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="#6366f1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Ordem</label>
                            <input type="number" name="sort_order" :value="editData.sort_order" min="0"
                                   class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                               :checked="editData.is_active"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-700">Categoria activa</span>
                    </label>
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="editModal = false"
                                class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-sm">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-admin-layout>
