<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        $anaSilva      = Provider::whereHas('user', fn ($q) => $q->where('email', 'ana.silva@navego.pt'))->first();
        $carlosFerreira = Provider::whereHas('user', fn ($q) => $q->where('email', 'carlos.ferreira@navego.pt'))->first();
        $mariaCosta    = Provider::whereHas('user', fn ($q) => $q->where('email', 'maria.costa@navego.pt'))->first();

        $quotes = [
            [
                'provider_id'  => $anaSilva?->id,
                'name'         => 'João Pereira',
                'email'        => 'joao@example.com',
                'phone'        => '+351 912 000 001',
                'description'  => 'Preciso de ajuda urgente para renovar a minha Autorização de Residência. Tenho visto de trabalho e moro em Lisboa há 3 anos.',
                'budget_range' => '€300–600',
                'deadline'     => '2 meses',
                'status'       => Quote::STATUS_REPLIED,
            ],
            [
                'provider_id'  => $carlosFerreira?->id,
                'name'         => 'Olha Kovalenko',
                'email'        => 'olha@example.com',
                'phone'        => '+351 913 000 002',
                'description'  => 'Trabalhei em Portugal durante 8 meses em 2024. Tenho também rendimentos do meu país de origem. Preciso de ajuda para a declaração de IRS.',
                'budget_range' => '€150–250',
                'deadline'     => '1 mês',
                'status'       => Quote::STATUS_VIEWED,
            ],
            [
                'provider_id'  => $mariaCosta?->id,
                'name'         => 'Amara Diallo',
                'email'        => 'amara@example.com',
                'phone'        => null,
                'description'  => 'Preciso de traduzir a minha certidão de nascimento do francês para português para submeter no AIMA.',
                'budget_range' => '€25–50',
                'deadline'     => '48 horas',
                'status'       => Quote::STATUS_CLOSED,
            ],
            [
                'provider_id'  => $anaSilva?->id,
                'name'         => 'Priya Sharma',
                'email'        => 'priya@example.com',
                'phone'        => '+351 914 000 004',
                'description'  => 'Tenho autorização de residência há 2 anos e quero perceber se consigo fazer o reagrupamento familiar para o meu marido que está na Índia.',
                'budget_range' => null,
                'deadline'     => null,
                'status'       => Quote::STATUS_NEW,
            ],
        ];

        foreach ($quotes as $data) {
            if (empty($data['provider_id'])) {
                continue;
            }
            Quote::create($data);
        }
    }
}
