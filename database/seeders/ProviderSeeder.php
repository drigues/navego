<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $catJuridico  = Category::where('name', 'Serviços Jurídicos')->first();
        $catFinancas  = Category::where('name', 'Finanças e Contabilidade')->first();
        $catTraducao  = Category::where('name', 'Tradução e Interpretação')->first();

        $providers = [
            [
                'email'         => 'ana.silva@navego.pt',
                'category_id'   => $catJuridico?->id,
                'business_name' => 'Ana Silva — Advogada de Imigração',
                'description'   => 'Especialista em direito da imigração com mais de 10 anos de experiência. Apoio em vistos, autorizações de residência, reagrupamento familiar e naturalização.',
                'phone'         => '+351 912 345 678',
                'address'       => 'Av. da Liberdade, 110, 2º Dto',
                'city'          => 'Lisboa',
                'website'       => null,
                'instagram'     => '@anasilva.adv',
                'whatsapp'      => '+351 912 345 678',
                'plan'          => 'pro',
                'status'        => 'active',
            ],
            [
                'email'         => 'carlos.ferreira@navego.pt',
                'category_id'   => $catFinancas?->id,
                'business_name' => 'Ferreira & Associados — Contabilidade',
                'description'   => 'Serviços de contabilidade e consultoria fiscal para particulares e empresas. Especialização em situações fiscais de não residentes e trabalhadores estrangeiros.',
                'phone'         => '+351 922 345 678',
                'address'       => 'Rua de Santa Catarina, 200, 3º',
                'city'          => 'Porto',
                'website'       => 'https://ferreirassociados.pt',
                'instagram'     => null,
                'whatsapp'      => '+351 922 345 678',
                'plan'          => 'basic',
                'status'        => 'active',
            ],
            [
                'email'         => 'maria.costa@navego.pt',
                'category_id'   => $catTraducao?->id,
                'business_name' => 'Maria Costa — Tradutora Certificada',
                'description'   => 'Tradutora juramentada para PT/EN/FR/ES. Documentos oficiais, certidões, contratos e apostilas. Entrega em 24-48h.',
                'phone'         => '+351 932 345 678',
                'address'       => 'Largo do Paço, 5',
                'city'          => 'Braga',
                'website'       => null,
                'instagram'     => '@mariacosta.traducoes',
                'whatsapp'      => '+351 932 345 678',
                'plan'          => 'basic',
                'status'        => 'pending',
            ],
        ];

        foreach ($providers as $data) {
            $user = User::where('email', $data['email'])->firstOrFail();
            unset($data['email']);

            Provider::firstOrCreate(
                ['user_id' => $user->id],
                array_merge($data, [
                    'slug' => Str::slug($data['business_name']),
                ])
            );
        }
    }
}
