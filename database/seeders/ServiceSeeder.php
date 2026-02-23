<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $anaSilva = Provider::whereHas('user', fn ($q) => $q->where('email', 'ana.silva@navego.pt'))->firstOrFail();
        $carlosFerreira = Provider::whereHas('user', fn ($q) => $q->where('email', 'carlos.ferreira@navego.pt'))->firstOrFail();
        $mariaCosta = Provider::whereHas('user', fn ($q) => $q->where('email', 'maria.costa@navego.pt'))->firstOrFail();

        $catJuridico = Category::where('name', 'Advogados de Imigração')->first()
            ?? Category::where('name', 'Serviços Jurídicos')->first();

        $catVisto = Category::where('name', 'Renovação de Vistos')->first()
            ?? $catJuridico;

        $catContab = Category::where('name', 'Declaração de IRS')->first()
            ?? Category::where('name', 'Finanças e Contabilidade')->first();

        $catNIF = Category::where('name', 'NIF e Serviços Fiscais')->first()
            ?? $catContab;

        $catTraducao = Category::where('name', 'Tradução de Documentos')->first()
            ?? Category::where('name', 'Tradução e Interpretação')->first();

        $catTradJur = Category::where('name', 'Tradução Juramentada')->first()
            ?? $catTraducao;

        $services = [
            // Ana Silva - Advogada
            [
                'provider_id' => $anaSilva->id,
                'category_id' => $catJuridico?->id ?? 1,
                'name' => 'Consulta Jurídica de Imigração',
                'description' => 'Consulta inicial de 60 minutos para análise da sua situação migratória e orientação sobre o melhor caminho a seguir.',
                'price_min' => 80.00,
                'price_max' => 80.00,
                'price_unit' => 'fixed',
                'tags' => ['imigração', 'consulta', 'visto', 'autorização residência'],
            ],
            [
                'provider_id' => $anaSilva->id,
                'category_id' => $catVisto?->id ?? 1,
                'name' => 'Renovação de Autorização de Residência',
                'description' => 'Serviço completo de renovação de autorização de residência, incluindo preparação de documentação e acompanhamento ao AIMA.',
                'price_min' => 350.00,
                'price_max' => 600.00,
                'price_unit' => 'fixed',
                'tags' => ['renovação', 'AR', 'AIMA', 'residência'],
            ],
            [
                'provider_id' => $anaSilva->id,
                'category_id' => $catJuridico?->id ?? 1,
                'name' => 'Pedido de Naturalização',
                'description' => 'Acompanhamento completo no processo de naturalização portuguesa, desde a verificação de requisitos até à entrega do processo.',
                'price_min' => 800.00,
                'price_max' => 1500.00,
                'price_unit' => 'fixed',
                'tags' => ['naturalização', 'cidadania', 'passaporte'],
            ],
            // Carlos Ferreira - Contabilista
            [
                'provider_id' => $carlosFerreira->id,
                'category_id' => $catContab?->id ?? 1,
                'name' => 'Declaração de IRS para Imigrantes',
                'description' => 'Preparação e entrega da declaração anual de IRS, com análise de benefícios fiscais aplicáveis (RNH, ex-residente, etc.).',
                'price_min' => 150.00,
                'price_max' => 300.00,
                'price_unit' => 'fixed',
                'tags' => ['IRS', 'impostos', 'declaração', 'RNH'],
            ],
            [
                'provider_id' => $carlosFerreira->id,
                'category_id' => $catNIF?->id ?? 1,
                'name' => 'Obtenção de NIF com Representante Fiscal',
                'description' => 'Serviço de obtenção do NIF português com representação fiscal incluída. Ideal para não residentes.',
                'price_min' => 120.00,
                'price_max' => 120.00,
                'price_unit' => 'fixed',
                'tags' => ['NIF', 'representante fiscal', 'finanças'],
            ],
            [
                'provider_id' => $carlosFerreira->id,
                'category_id' => $catContab?->id ?? 1,
                'name' => 'Contabilidade Mensal — Empresa',
                'description' => 'Serviço de contabilidade organizada mensal para micro e pequenas empresas. Inclui processamento de vencimentos.',
                'price_min' => 150.00,
                'price_max' => 400.00,
                'price_unit' => 'month',
                'tags' => ['contabilidade', 'empresa', 'mensal', 'vencimentos'],
            ],
            // Maria Costa - Tradutora
            [
                'provider_id' => $mariaCosta->id,
                'category_id' => $catTraducao?->id ?? 1,
                'name' => 'Tradução de Documentos Pessoais',
                'description' => 'Tradução de documentos como certidões de nascimento, casamento, habilitações literárias e outros documentos pessoais. Preço por página.',
                'price_min' => 25.00,
                'price_max' => 40.00,
                'price_unit' => 'page',
                'tags' => ['tradução', 'certidão', 'documentos', 'PT/EN/ES/FR'],
            ],
            [
                'provider_id' => $mariaCosta->id,
                'category_id' => $catTradJur?->id ?? 1,
                'name' => 'Tradução Juramentada',
                'description' => 'Tradução juramentada com valor legal, aceite em entidades públicas e tribunais. Urgência disponível.',
                'price_min' => 50.00,
                'price_max' => 80.00,
                'price_unit' => 'page',
                'tags' => ['juramentada', 'oficial', 'tribunal', 'AT', 'AIMA'],
            ],
        ];

        foreach ($services as $data) {
            $tags = $data['tags'] ?? null;
            unset($data['tags']);

            Service::firstOrCreate(
                [
                    'provider_id' => $data['provider_id'],
                    'name' => $data['name'],
                ],
                array_merge($data, [
                    'slug' => Str::slug($data['name'] . '-' . $data['provider_id']),
                    'currency' => 'EUR',
                    'is_active' => true,
                    'tags' => $tags,
                ])
            );
        }
    }
}
