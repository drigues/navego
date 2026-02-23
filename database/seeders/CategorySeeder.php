<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Serviços Jurídicos',
                'icon' => 'scale',
                'color' => '#4F46E5',
                'description' => 'Advogados, solicitadores e consultores jurídicos especializados em imigração.',
                'children' => [
                    ['name' => 'Advogados de Imigração', 'icon' => 'briefcase'],
                    ['name' => 'Renovação de Vistos', 'icon' => 'document-check'],
                    ['name' => 'Reunificação Familiar', 'icon' => 'users'],
                    ['name' => 'Naturalização / Cidadania', 'icon' => 'identification'],
                ],
            ],
            [
                'name' => 'Saúde',
                'icon' => 'heart',
                'color' => '#EF4444',
                'description' => 'Médicos, psicólogos e outros profissionais de saúde.',
                'children' => [
                    ['name' => 'Médicos Generalistas', 'icon' => 'user-md'],
                    ['name' => 'Saúde Mental / Psicólogos', 'icon' => 'brain'],
                    ['name' => 'Dentistas', 'icon' => 'tooth'],
                    ['name' => 'Farmácias', 'icon' => 'pill'],
                ],
            ],
            [
                'name' => 'Finanças e Contabilidade',
                'icon' => 'currency-euro',
                'color' => '#10B981',
                'description' => 'Contabilistas, consultores fiscais e serviços financeiros.',
                'children' => [
                    ['name' => 'Contabilistas', 'icon' => 'calculator'],
                    ['name' => 'Declaração de IRS', 'icon' => 'document-text'],
                    ['name' => 'NIF e Serviços Fiscais', 'icon' => 'receipt-tax'],
                    ['name' => 'Abertura de Empresa', 'icon' => 'office-building'],
                ],
            ],
            [
                'name' => 'Educação e Idiomas',
                'icon' => 'academic-cap',
                'color' => '#F59E0B',
                'description' => 'Professores de português, cursos de integração e equivalências.',
                'children' => [
                    ['name' => 'Aulas de Português', 'icon' => 'chat'],
                    ['name' => 'Equivalência de Diplomas', 'icon' => 'badge-check'],
                    ['name' => 'Cursos de Integração', 'icon' => 'globe'],
                    ['name' => 'Explicações / Tutoria', 'icon' => 'pencil'],
                ],
            ],
            [
                'name' => 'Habitação e Imóveis',
                'icon' => 'home',
                'color' => '#8B5CF6',
                'description' => 'Arrendamento, compra e venda de imóveis.',
                'children' => [
                    ['name' => 'Arrendamento', 'icon' => 'key'],
                    ['name' => 'Compra de Casa', 'icon' => 'home'],
                    ['name' => 'Obras e Remodelações', 'icon' => 'wrench'],
                ],
            ],
            [
                'name' => 'Tradução e Interpretação',
                'icon' => 'language',
                'color' => '#06B6D4',
                'description' => 'Tradutores e intérpretes certificados.',
                'children' => [
                    ['name' => 'Tradução de Documentos', 'icon' => 'document-duplicate'],
                    ['name' => 'Tradução Juramentada', 'icon' => 'badge-check'],
                    ['name' => 'Interpretação Presencial', 'icon' => 'microphone'],
                ],
            ],
            [
                'name' => 'Emprego e Carreira',
                'icon' => 'briefcase',
                'color' => '#F97316',
                'description' => 'Apoio na procura de emprego e desenvolvimento de carreira.',
                'children' => [
                    ['name' => 'Curriculum Vitae', 'icon' => 'document'],
                    ['name' => 'Coaching de Carreira', 'icon' => 'chart-bar'],
                    ['name' => 'Agências de Recrutamento', 'icon' => 'users'],
                ],
            ],
            [
                'name' => 'Apoio Social e Integração',
                'icon' => 'heart',
                'color' => '#EC4899',
                'description' => 'Associações e serviços de apoio à integração.',
                'children' => [
                    ['name' => 'Associações de Imigrantes', 'icon' => 'users-group'],
                    ['name' => 'Assistência Social', 'icon' => 'support'],
                    ['name' => 'Mediação Cultural', 'icon' => 'globe'],
                ],
            ],
        ];

        $sortOrder = 0;
        foreach ($categories as $cat) {
            $children = $cat['children'] ?? [];
            unset($cat['children']);

            $parent = Category::create([
                'parent_id' => null,
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'] ?? null,
                'icon' => $cat['icon'] ?? null,
                'color' => $cat['color'] ?? null,
                'sort_order' => $sortOrder++,
                'is_active' => true,
            ]);

            $childOrder = 0;
            foreach ($children as $child) {
                Category::create([
                    'parent_id' => $parent->id,
                    'name' => $child['name'],
                    'slug' => Str::slug($child['name'] . '-' . $parent->id),
                    'icon' => $child['icon'] ?? null,
                    'sort_order' => $childOrder++,
                    'is_active' => true,
                ]);
            }
        }
    }
}
