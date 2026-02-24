<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            [
                'title'       => 'Como obter o NIF em Portugal — Guia Completo 2024',
                'category'    => 'Serviços Jurídicos',
                'excerpt'     => 'O NIF (Número de Identificação Fiscal) é indispensável para quase tudo em Portugal. Saiba como obtê-lo passo a passo.',
                'content'     => "# Como obter o NIF em Portugal\n\nO **NIF (Número de Identificação Fiscal)** é essencial para abrir conta bancária, trabalhar, alugar casa e muito mais em Portugal.\n\n## Quem pode obter?\n\nQualquer pessoa, residente ou não, pode obter um NIF em Portugal.\n\n## Documentos necessários\n\n- Documento de identidade válido (passaporte ou BI)\n- Comprovativo de morada\n- Caso seja não residente: representante fiscal com NIF português\n\n## Passo a passo\n\n1. Dirija-se a qualquer repartição de Finanças (AT)\n2. Apresente os documentos\n3. O NIF é emitido de imediato e é gratuito\n\n## Custos\n\nO NIF é **gratuito** se solicitado presencialmente. Serviços privados cobram entre €60 e €150.",
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title'       => 'Autorização de Residência — Tudo o que precisa de saber',
                'category'    => 'Serviços Jurídicos',
                'excerpt'     => 'Guia completo sobre tipos de Autorização de Residência, como pedir, renovar e quais os requisitos.',
                'content'     => "# Autorização de Residência em Portugal\n\nA Autorização de Residência (AR) permite que cidadãos estrangeiros de países fora da UE vivam legalmente em Portugal.\n\n## Tipos de AR\n\n- **Por atividade profissional** — para quem tem contrato de trabalho\n- **Para nómadas digitais** — trabalhadores remotos\n- **Por reagrupamento familiar** — para familiares de residentes\n\n## Como pedir\n\n1. Entrar em Portugal com o visto correto\n2. Agendar no AIMA (aima.gov.pt)\n3. Apresentar documentação\n4. Aguardar decisão (até 90 dias)\n\n## Documentação base\n\n- Passaporte válido\n- Comprovativo de meios de subsistência\n- Comprovativo de alojamento\n- Seguro de saúde\n- Registo criminal apostilado",
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title'       => 'SNS para Imigrantes — Como aceder ao Sistema Nacional de Saúde',
                'category'    => 'Saúde',
                'excerpt'     => 'Sabia que pode ter acesso gratuito ao SNS? Descubra como inscrever-se no Centro de Saúde e quais os seus direitos.',
                'content'     => "# Acesso ao SNS para Imigrantes\n\nTodos os imigrantes em Portugal têm direito a aceder ao **Serviço Nacional de Saúde (SNS)**.\n\n## Como se inscrever\n\n1. Dirija-se ao Centro de Saúde da sua área de residência\n2. Leve o NIF e comprovativo de morada\n3. Solicite a inscrição como utente\n\n## Sem documentos?\n\nMesmo sem documentação regularizada, pode aceder ao SNS para cuidados urgentes.\n\n## Linha SNS 24\n\nPara dúvidas não urgentes: **808 24 24 24** (24h/dia).",
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'title'       => 'Arrendar casa em Portugal — Guia para imigrantes',
                'category'    => 'Habitação e Imóveis',
                'excerpt'     => 'Encontrar casa em Portugal pode ser desafiante. Saiba como funciona o mercado e os seus direitos como inquilino.',
                'content'     => "# Arrendar Casa em Portugal\n\nO mercado imobiliário português é muito competitivo. Este guia ajuda-o a navegar o processo.\n\n## Plataformas de pesquisa\n\n- Idealista.pt\n- OLX.pt\n- Imovirtual.com\n\n## Documentos habitualmente pedidos\n\n- 3 últimos recibos de vencimento\n- NIF\n- Documento de identidade\n\n## O Fiador\n\nMuitos senhorios pedem um fiador. Alternativas: seguro-caução ou adiantamento de meses de renda.\n\n## Os seus direitos\n\nO **Novo Regime do Arrendamento Urbano** protege os inquilinos. A caução máxima é de 2 meses de renda.",
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title'       => 'Aprender Português — Recursos gratuitos e pagos',
                'category'    => 'Educação e Idiomas',
                'excerpt'     => 'Uma lista curada de recursos para aprender ou melhorar o seu português.',
                'content'     => "# Aprender Português em Portugal\n\n## Recursos Gratuitos\n\n- **Duolingo** — ótimo para iniciantes\n- **RTP Play** — conteúdo em português com legendas\n- **LanguageTransfer** — curso áudio gratuito\n\n## Cursos com Certificação\n\n### CIPLE (B1)\nCertificação oficial necessária para alguns pedidos de AR e naturalização.\n\n### Programa Portugal Acolhe\nCurso gratuito oferecido pelo Estado para imigrantes — inscrição no IEFP.\n\n## Dica\n\nPratique com portugueses! O sotaque aprende-se melhor no dia-a-dia.",
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($guides as $data) {
            Guide::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, ['slug' => Str::slug($data['title'])])
            );
        }
    }
}
