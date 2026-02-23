<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Quote;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        $joao = User::where('email', 'joao@example.com')->first();
        $olha = User::where('email', 'olha@example.com')->first();
        $amara = User::where('email', 'amara@example.com')->first();
        $priya = User::where('email', 'priya@example.com')->first();

        $anaSilva = Provider::whereHas('user', fn ($q) => $q->where('email', 'ana.silva@navego.pt'))->first();
        $carlosFerreira = Provider::whereHas('user', fn ($q) => $q->where('email', 'carlos.ferreira@navego.pt'))->first();
        $mariaCosta = Provider::whereHas('user', fn ($q) => $q->where('email', 'maria.costa@navego.pt'))->first();

        $serviceRenovacao = Service::where('name', 'Renovação de Autorização de Residência')->first();
        $serviceIRS = Service::where('name', 'Declaração de IRS para Imigrantes')->first();
        $serviceTrad = Service::where('name', 'Tradução de Documentos Pessoais')->first();

        $quotes = [
            [
                'user_id' => $joao?->id,
                'provider_id' => $anaSilva?->id,
                'service_id' => $serviceRenovacao?->id,
                'title' => 'Renovação da minha AR — vence em 2 meses',
                'description' => 'Preciso de ajuda urgente para renovar a minha Autorização de Residência. Tenho visto de trabalho e moro em Lisboa há 3 anos. Os meus documentos estão todos em ordem.',
                'budget_min' => 300.00,
                'budget_max' => 600.00,
                'currency' => 'EUR',
                'status' => Quote::STATUS_REPLIED,
                'provider_response' => 'Olá João! Analisei o seu caso e posso ajudá-lo com a renovação. Para este perfil o custo será de €450 tudo incluído. Podemos agendar uma reunião esta semana?',
                'proposed_price' => 450.00,
                'responded_at' => now()->subDays(2),
            ],
            [
                'user_id' => $olha?->id,
                'provider_id' => $carlosFerreira?->id,
                'service_id' => $serviceIRS?->id,
                'title' => 'Declaração IRS 2024 — rendimentos PT e UA',
                'description' => 'Trabalhei em Portugal durante 8 meses em 2024. Tenho também rendimentos do meu país de origem. Preciso de ajuda para perceber o que devo declarar.',
                'budget_min' => 150.00,
                'budget_max' => 250.00,
                'currency' => 'EUR',
                'status' => Quote::STATUS_ACCEPTED,
                'provider_response' => 'Bom dia Olha! Este é um caso que trato regularmente. Para rendimentos mistos PT/estrangeiro o valor será €220. Posso tratar de tudo remotamente via email.',
                'proposed_price' => 220.00,
                'responded_at' => now()->subDays(5),
            ],
            [
                'user_id' => $amara?->id,
                'provider_id' => $mariaCosta?->id,
                'service_id' => $serviceTrad?->id,
                'title' => 'Tradução de certidão de nascimento — FR para PT',
                'description' => 'Preciso de traduzir a minha certidão de nascimento do francês para português. É para submeter no pedido de AR no AIMA.',
                'budget_min' => 25.00,
                'budget_max' => 50.00,
                'currency' => 'EUR',
                'status' => Quote::STATUS_COMPLETED,
                'provider_response' => 'Olá Amara! Certidão de nascimento de 1 página será €30. Entrego em 24h úteis.',
                'proposed_price' => 30.00,
                'responded_at' => now()->subDays(14),
                'completed_at' => now()->subDays(12),
            ],
            [
                'user_id' => $priya?->id,
                'provider_id' => $anaSilva?->id,
                'service_id' => null,
                'title' => 'Possibilidade de trazer o meu marido para Portugal',
                'description' => 'Tenho autorização de residência há 2 anos. Quero perceber se consigo fazer o reagrupamento familiar para o meu marido que está na Índia. Qual é o processo?',
                'budget_min' => null,
                'budget_max' => null,
                'currency' => 'EUR',
                'status' => Quote::STATUS_PENDING,
            ],
        ];

        foreach ($quotes as $data) {
            if (empty($data['user_id']) || empty($data['provider_id'])) {
                continue;
            }
            Quote::create($data);
        }
    }
}
