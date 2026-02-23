<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            [
                'email' => 'ana.silva@navego.pt',
                'business_name' => 'Ana Silva — Advogada de Imigração',
                'description' => 'Especialista em direito da imigração com mais de 10 anos de experiência. Apoio em vistos, autorizações de residência, reagrupamento familiar e naturalização.',
                'nif' => '123456789',
                'address' => 'Av. da Liberdade, 110, 2º Dto',
                'city' => 'Lisboa',
                'district' => 'Lisboa',
                'postal_code' => '1250-096',
                'phone' => '+351 912 345 678',
                'whatsapp' => '+351 912 345 678',
                'contact_email' => 'ana.silva@navego.pt',
                'languages' => ['pt', 'en', 'es'],
                'social_links' => ['linkedin' => 'https://linkedin.com/in/ana-silva-adv'],
                'working_hours' => ['seg' => '9:00-18:00', 'ter' => '9:00-18:00', 'qua' => '9:00-18:00', 'qui' => '9:00-18:00', 'sex' => '9:00-17:00'],
                'serves_remote' => true,
                'is_verified' => true,
                'rating' => 4.8,
                'reviews_count' => 47,
            ],
            [
                'email' => 'carlos.ferreira@navego.pt',
                'business_name' => 'Ferreira & Associados — Contabilidade',
                'description' => 'Serviços de contabilidade e consultoria fiscal para particulares e empresas. Especialização em situações fiscais de não residentes e trabalhadores estrangeiros.',
                'nif' => '987654321',
                'address' => 'Rua de Santa Catarina, 200, 3º',
                'city' => 'Porto',
                'district' => 'Porto',
                'postal_code' => '4000-450',
                'phone' => '+351 922 345 678',
                'whatsapp' => '+351 922 345 678',
                'contact_email' => 'carlos.ferreira@navego.pt',
                'languages' => ['pt', 'en'],
                'social_links' => ['website' => 'https://ferreirassociados.pt'],
                'working_hours' => ['seg' => '9:00-18:00', 'ter' => '9:00-18:00', 'qua' => '9:00-18:00', 'qui' => '9:00-18:00', 'sex' => '9:00-13:00'],
                'serves_remote' => true,
                'is_verified' => true,
                'rating' => 4.6,
                'reviews_count' => 31,
            ],
            [
                'email' => 'maria.costa@navego.pt',
                'business_name' => 'Maria Costa — Tradutora Certificada',
                'description' => 'Tradutora juramentada para PT/EN/FR/ES. Documentos oficiais, certidões, contratos e apostilas. Entrega em 24-48h.',
                'nif' => '456789123',
                'address' => 'Largo do Paço, 5',
                'city' => 'Braga',
                'district' => 'Braga',
                'postal_code' => '4700-024',
                'phone' => '+351 932 345 678',
                'whatsapp' => '+351 932 345 678',
                'contact_email' => 'maria.costa@navego.pt',
                'languages' => ['pt', 'en', 'fr', 'es'],
                'social_links' => ['instagram' => 'https://instagram.com/mariacosta.traducoes'],
                'working_hours' => ['seg' => '9:00-17:00', 'ter' => '9:00-17:00', 'qua' => '9:00-17:00', 'qui' => '9:00-17:00', 'sex' => '9:00-13:00'],
                'serves_remote' => true,
                'is_verified' => false,
                'rating' => 4.9,
                'reviews_count' => 88,
            ],
        ];

        foreach ($providers as $data) {
            $user = User::where('email', $data['email'])->firstOrFail();
            unset($data['email']);

            Provider::firstOrCreate(
                ['user_id' => $user->id],
                array_merge($data, [
                    'slug' => Str::slug($data['business_name']),
                    'is_active' => true,
                ])
            );
        }
    }
}
