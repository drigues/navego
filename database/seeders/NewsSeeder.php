<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [
            [
                'title'        => 'AIMA anuncia novas medidas para reduzir filas e tempos de espera em 2025',
                'excerpt'      => 'A AIMA apresentou um plano de reestruturação para 2025 com o objetivo de reduzir significativamente os tempos de espera nos processos migratórios.',
                'content'      => "A **Agência para a Integração, Migrações e Asilo (AIMA)** anunciou um conjunto de medidas para modernizar os seus serviços.\n\nEntre as novidades destaca-se a expansão do agendamento online, novos balcões em Setúbal, Évora e Faro, e a possibilidade de submissão de renovações de AR por correio.\n\n## Reforço de Pessoal\n\nO governo comprometeu-se a contratar mais 200 técnicos até ao final do primeiro trimestre de 2025.\n\n## Processos em Atraso\n\nA agência estima cerca de 400 mil processos em análise, um número que deverá diminuir com as novas medidas.",
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title'        => 'Portugal entre os países europeus mais atrativos para imigrantes em 2025',
                'excerpt'      => 'Novo estudo da OCDE coloca Portugal em 4.º lugar no ranking europeu de países mais atrativos para imigrantes.',
                'content'      => "Um relatório da **OCDE** coloca Portugal na 4.ª posição europeia no índice de atratividade para imigrantes em 2025.\n\n## Destaques positivos\n\n- Língua portuguesa (5.ª mais falada no mundo)\n- Clima e qualidade de vida\n- Segurança (entre os mais seguros da Europa)\n\n## Desafios\n\n- Processos migratórios ainda lentos\n- Custo de habitação elevado em Lisboa e Porto\n- Salários médios abaixo da média europeia",
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title'        => 'Novas regras para o Reagrupamento Familiar entram em vigor em março',
                'excerpt'      => 'O governo publicou alterações ao regime jurídico do reagrupamento familiar, simplificando o processo para cônjuges e filhos menores.',
                'content'      => "O **Diário da República** publicou alterações ao regime jurídico de entrada e permanência de estrangeiros com impacto no **reagrupamento familiar**.\n\n## Principais alterações\n\n- Prazo mínimo de residência para cônjuges: de 1 ano para **6 meses**\n- Documentação para filhos menores simplificada\n- Processo pode ser iniciado online via portal AIMA\n\n## Entrada em vigor\n\nAs novas regras entram em vigor a **1 de março de 2025**.",
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title'        => 'Programa Portugal Acolhe alarga vagas para cursos de integração em 2025',
                'excerpt'      => 'O IEFP e o ACM anunciam novas turmas do programa Portugal Acolhe, com formação gratuita em português e cidadania para imigrantes.',
                'content'      => "O **IEFP** e o **ACM** anunciaram a abertura de novas turmas do programa **Portugal Acolhe** para 2025.\n\n## O que é o Portugal Acolhe?\n\nPrograma de formação gratuita com duas componentes:\n\n1. **Português para Todos** — aulas de língua portuguesa\n2. **Cidadania e Integração** — direitos e deveres na sociedade portuguesa\n\n## Para quem?\n\n- Imigrantes residentes em Portugal\n- Certificado reconhecido para pedidos de AR e naturalização\n- Inscrição nos centros de emprego do IEFP ou em iefp.pt\n\n## Novidade 2025\n\nModalidade mista (presencial + online), facilitando o acesso a imigrantes no interior.",
                'is_published' => true,
                'published_at' => now()->subDays(18),
            ],
        ];

        foreach ($news as $data) {
            News::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, ['slug' => Str::slug($data['title'])])
            );
        }
    }
}
