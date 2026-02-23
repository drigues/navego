<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@navego.pt')->firstOrFail();

        $news = [
            [
                'title' => 'AIMA anuncia novas medidas para reduzir filas e tempos de espera em 2025',
                'excerpt' => 'A Agência para a Integração, Migrações e Asilo (AIMA) apresentou um plano de reestruturação para 2025 com o objetivo de reduzir significativamente os tempos de espera nos processos migratórios.',
                'content' => "A **Agência para a Integração, Migrações e Asilo (AIMA)** anunciou esta semana um conjunto de medidas para modernizar os seus serviços e reduzir as longas filas que têm marcado a agência desde a sua criação.\n\nEntre as novidades destaca-se a expansão do sistema de agendamento online, a abertura de novos balcões de atendimento em cidades como Setúbal, Évora e Faro, e a possibilidade de submissão de renovações de AR por correio para casos considerados simples.\n\n## Reforço de Pessoal\n\nO governo comprometeu-se a contratar mais 200 técnicos para a AIMA até ao final do primeiro trimestre de 2025.\n\n## Processos em Atraso\n\nA agência estima que existam atualmente cerca de 400 mil processos em diferentes fases de análise, um número que deverá diminuir com as novas medidas.\n\n*Fonte: Comunicado oficial da AIMA*",
                'language' => 'pt',
                'status' => 'published',
                'source_name' => 'AIMA',
                'tags' => ['AIMA', 'imigração', 'autorização residência', 'Portugal'],
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Portugal entre os países europeus mais atrativos para imigrantes em 2025',
                'excerpt' => 'Novo estudo da OCDE coloca Portugal em 4.º lugar no ranking de países europeus mais atrativos para imigrantes, com destaque para a qualidade de vida e integração.',
                'content' => "Um novo relatório da **OCDE** publicado esta semana coloca Portugal na 4.ª posição europeia no índice de atratividade para imigrantes em 2025.\n\nO estudo avalia critérios como estabilidade económica, custo de vida relativo, facilidade de integração, acesso a serviços públicos e receptividade cultural.\n\n## Destaques positivos\n\n- **Língua**: O português é a 5.ª língua mais falada no mundo, facilitando a integração de falantes\n- **Clima e qualidade de vida**: Consistentemente valorizado pelos inquiridos\n- **Segurança**: Portugal mantém-se entre os países mais seguros da Europa (Global Peace Index)\n\n## Desafios identificados\n\n- Processos migratórios ainda considerados lentos\n- Custo de habitação em Lisboa e Porto como barreira\n- Salários médios abaixo da média europeia\n\nApesar dos desafios, o saldo migratório português continua positivo, com o país a receber mais imigrantes do que os que partem.",
                'language' => 'pt',
                'status' => 'published',
                'source_name' => 'OCDE / Público',
                'tags' => ['Portugal', 'imigração', 'OCDE', 'qualidade de vida'],
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Novas regras para o Reagrupamento Familiar entram em vigor em março',
                'excerpt' => 'O governo publicou as alterações ao regime jurídico do reagrupamento familiar, simplificando o processo para cônjuges e filhos menores.',
                'content' => "O **Diário da República** publicou esta semana as alterações ao regime jurídico de entrada, permanência, saída e afastamento de estrangeiros, com impacto direto no **reagrupamento familiar**.\n\n## Principais alterações\n\n### Cônjuges\nO prazo mínimo de residência para pedir reagrupamento familiar para cônjuges passa de 1 ano para **6 meses** para titulares de AR por atividade profissional.\n\n### Filhos\nOs documentos exigidos para filhos menores são simplificados, eliminando-se a necessidade de alguns documentos até agora obrigatórios.\n\n### Tramitação digital\nTodo o processo poderá agora ser iniciado online através do portal AIMA, com menos deslocações presenciais.\n\n## Entrada em vigor\n\nAs novas regras entram em vigor a **1 de março de 2025**.\n\nRecomenda-se consultar um advogado especializado para casos específicos.",
                'language' => 'pt',
                'status' => 'published',
                'source_name' => 'Diário da República',
                'tags' => ['reagrupamento familiar', 'família', 'visto', 'lei'],
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Portugal Extends Digital Nomad Visa Program with New Benefits',
                'excerpt' => 'Portugal has announced an extension and enhancement of its Digital Nomad Visa program, making it easier for remote workers worldwide to live and work from Portugal.',
                'content' => "Portugal has announced significant improvements to its **Digital Nomad Visa** (D8), one of Europe's most popular programs for remote workers, effective from early 2025.\n\n## What's New?\n\n### Lower Income Threshold\nThe minimum monthly income requirement has been adjusted to €3,040 (4x the Portuguese minimum wage), down from previous requirements.\n\n### Faster Processing\nA dedicated fast-track lane for D8 applications at the AIMA has been introduced, with a target processing time of 30 days.\n\n### Path to Residency\nDigital nomad visa holders can now more easily transition to a standard residence permit after 1 year, opening a clearer path to long-term residency.\n\n## Who Qualifies?\n\n- Non-EU citizens\n- Remote workers employed by foreign companies\n- Freelancers with clients outside Portugal\n- Minimum monthly income: €3,040\n\n## Popular Cities\n\nLisbon, Porto, and the Algarve continue to be the top destinations for digital nomads in Portugal.",
                'language' => 'en',
                'status' => 'published',
                'source_name' => 'Portugal Government',
                'tags' => ['digital nomad', 'visa', 'remote work', 'D8', 'Portugal'],
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Programa "Portugal Acolhe" alarga vagas para cursos de integração em 2025',
                'excerpt' => 'O IEFP e o ACM anunciam a abertura de novas turmas do programa Portugal Acolhe, com formação gratuita em língua portuguesa e cidadania para imigrantes.',
                'content' => "O **Instituto do Emprego e Formação Profissional (IEFP)** e o **Alto Comissariado para as Migrações (ACM)** anunciaram a abertura de novas turmas do programa **Portugal Acolhe** para 2025.\n\n## O que é o Portugal Acolhe?\n\nTrata-se de um programa de formação gratuita destinado a imigrantes, com duas componentes:\n\n1. **Português para Todos** — aulas de língua portuguesa adaptadas a diferentes níveis\n2. **Cidadania e Integração** — módulo sobre direitos, deveres e funcionamento da sociedade portuguesa\n\n## Para quem?\n\n- Imigrantes residentes em Portugal\n- Inscrição gratuita (financiado pelo Estado)\n- Certificado reconhecido para pedidos de AR e naturalização\n\n## Como inscrever?\n\nInscrições abertas nos centros de emprego do IEFP em todo o país e online em iefp.pt.\n\n## Novidade 2025\n\nPela primeira vez, o programa estará disponível em modalidade **mista (presencial + online)**, facilitando o acesso a imigrantes em zonas do interior.",
                'language' => 'pt',
                'status' => 'published',
                'source_name' => 'IEFP / ACM',
                'tags' => ['integração', 'português', 'IEFP', 'Portugal Acolhe', 'formação'],
                'published_at' => now()->subDays(18),
            ],
        ];

        foreach ($news as $data) {
            $tags = $data['tags'] ?? null;
            unset($data['tags']);

            News::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, [
                    'author_id' => $admin->id,
                    'slug' => Str::slug($data['title']),
                    'views_count' => rand(100, 2000),
                    'tags' => $tags,
                ])
            );
        }
    }
}
