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
            ['name' => 'Serviços Jurídicos',         'icon' => 'scale',         'description' => 'Advogados, solicitadores e consultores jurídicos especializados em imigração.'],
            ['name' => 'Saúde',                       'icon' => 'heart',         'description' => 'Médicos, psicólogos e outros profissionais de saúde.'],
            ['name' => 'Finanças e Contabilidade',    'icon' => 'currency-euro', 'description' => 'Contabilistas, consultores fiscais e serviços financeiros.'],
            ['name' => 'Educação e Idiomas',          'icon' => 'academic-cap',  'description' => 'Professores de português, cursos de integração e equivalências.'],
            ['name' => 'Habitação e Imóveis',         'icon' => 'home',          'description' => 'Arrendamento, compra e venda de imóveis.'],
            ['name' => 'Tradução e Interpretação',    'icon' => 'language',      'description' => 'Tradutores e intérpretes certificados.'],
            ['name' => 'Emprego e Carreira',          'icon' => 'briefcase',     'description' => 'Apoio na procura de emprego e desenvolvimento de carreira.'],
            ['name' => 'Apoio Social e Integração',   'icon' => 'users',         'description' => 'Associações e serviços de apoio à integração.'],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
