<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Guide;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@navego.pt')->firstOrFail();

        $catJuridico = Category::where('name', 'Serviços Jurídicos')->first();
        $catSaude = Category::where('name', 'Saúde')->first();
        $catFinancas = Category::where('name', 'Finanças e Contabilidade')->first();
        $catEducacao = Category::where('name', 'Educação e Idiomas')->first();
        $catHabitacao = Category::where('name', 'Habitação e Imóveis')->first();

        $guides = [
            [
                'category_id' => $catJuridico?->id,
                'title' => 'Como obter o NIF em Portugal — Guia Completo 2024',
                'excerpt' => 'O NIF (Número de Identificação Fiscal) é indispensável para quase tudo em Portugal. Saiba como obtê-lo passo a passo.',
                'content' => "# Como obter o NIF em Portugal\n\nO **NIF (Número de Identificação Fiscal)** é essencial para abrir conta bancária, trabalhar, alugar casa e muito mais em Portugal.\n\n## Quem pode obter?\n\nQualquer pessoa, residente ou não, pode obter um NIF em Portugal.\n\n## Documentos necessários\n\n- Documento de identidade válido (passaporte ou BI)\n- Comprovativo de morada (no país de origem ou em Portugal)\n- Caso seja não residente: representante fiscal com NIF português\n\n## Passo a passo\n\n### 1. Presencialmente nas Finanças\nDiriga-se a qualquer repartição de Finanças (AT) com os documentos e solicite o NIF. É gratuito.\n\n### 2. Online (para residentes)\nAtravés do Portal das Finanças, se já tiver acesso.\n\n### 3. Através de um representante fiscal\nSe for não residente, pode solicitar online através de um representante fiscal registado.\n\n## Custos\n\nO NIF é **gratuito** se solicitado presencialmente. Serviços privados de obtenção de NIF cobram entre €60 e €150.\n\n## Dicas\n\n- Leve cópia de todos os documentos\n- O processo é imediato em balcão\n- Guarde bem o cartão do NIF",
                'language' => 'pt',
                'status' => 'published',
                'tags' => ['NIF', 'finanças', 'documentação', 'imigrante'],
                'published_at' => now()->subDays(30),
            ],
            [
                'category_id' => $catJuridico?->id,
                'title' => 'Autorização de Residência — Tudo o que precisa de saber',
                'excerpt' => 'Guia completo sobre tipos de Autorização de Residência, como pedir, renovar e quais os requisitos.',
                'content' => "# Autorização de Residência em Portugal\n\nA Autorização de Residência (AR) permite que cidadãos estrangeiros de países fora da UE vivam legalmente em Portugal.\n\n## Tipos de Autorização de Residência\n\n### AR por atividade profissional\nPara quem tem um contrato de trabalho em Portugal.\n\n### AR para nómadas digitais\nPara profissionais que trabalham remotamente para empresas fora de Portugal.\n\n### AR por reagrupamento familiar\nPara familiares de cidadãos portugueses ou residentes legais.\n\n### AR por investimento\nAntigo Visto Gold — atualmente em reformulação.\n\n## Como pedir\n\n1. Entrar em Portugal com o visto correto\n2. Agendar no AIMA (aima.gov.pt)\n3. Apresentar documentação\n4. Aguardar decisão\n\n## Documentação base\n\n- Passaporte válido\n- Comprovativo de meios de subsistência\n- Comprovativo de alojamento\n- Seguro de saúde\n- Registo criminal do país de origem (apostilado)\n\n## Prazos\n\nO AIMA tem prazo legal de 90 dias, mas na prática pode demorar mais. Recomenda-se submeter com antecedência.",
                'language' => 'pt',
                'status' => 'published',
                'tags' => ['AR', 'AIMA', 'residência', 'visto', 'documentação'],
                'published_at' => now()->subDays(20),
            ],
            [
                'category_id' => $catSaude?->id,
                'title' => 'SNS para Imigrantes — Como aceder ao Sistema Nacional de Saúde',
                'excerpt' => 'Sabia que pode ter acesso gratuito ao SNS? Descubra como inscrever-se no Centro de Saúde e quais os seus direitos.',
                'content' => "# Acesso ao SNS para Imigrantes\n\nTodos os imigrantes em Portugal têm direito a aceder ao **Serviço Nacional de Saúde (SNS)**, independentemente do seu estatuto migratório.\n\n## Como se inscrever no Centro de Saúde\n\n1. Dirija-se ao Centro de Saúde da sua área de residência\n2. Leve o seu NIF e comprovativo de morada\n3. Solicite a inscrição como utente\n\n## Documentos\n\n- NIF\n- Comprovativo de morada\n- Documento de identificação\n\n## Sem documentos?\n\nMesmo sem documentação regularizada, pode aceder ao SNS para cuidados urgentes e essenciais.\n\n## Número de Utente SNS\n\nApós inscrição, receberá um número de utente SNS, necessário para consultas e prescrições.\n\n## Linha SNS 24\n\nPara dúvidas de saúde não urgentes, ligue **808 24 24 24** (disponível 24h).",
                'language' => 'pt',
                'status' => 'published',
                'tags' => ['SNS', 'saúde', 'centro de saúde', 'utente'],
                'published_at' => now()->subDays(15),
            ],
            [
                'category_id' => $catHabitacao?->id,
                'title' => 'Arrendar casa em Portugal — Guia para imigrantes',
                'excerpt' => 'Encontrar casa em Portugal pode ser desafiante. Saiba como funciona o mercado, o que é o fiador, e os seus direitos como inquilino.',
                'content' => "# Arrendar Casa em Portugal\n\nO mercado imobiliário português, especialmente em Lisboa e Porto, é muito competitivo. Este guia ajuda-o a navegar o processo.\n\n## Plataformas de pesquisa\n\n- **Idealista** (idealista.pt)\n- **OLX** (olx.pt)\n- **Imovirtual** (imovirtual.com)\n- **Uniplaces** — especialmente para arrendamentos de médio prazo\n\n## Documentos habitualmente pedidos\n\n- 3 últimos recibos de vencimento\n- Declaração de IRS ou proposta de trabalho\n- NIF\n- Documento de identidade\n\n## O Fiador\n\nMuitos senhorios pedem um **fiador** — uma pessoa com NIF e rendimentos em Portugal que garante o pagamento. Para imigrantes sem rede local, isto pode ser um obstáculo.\n\n**Alternativas:**\n- Seguro-caução (substitui o fiador em muitos casos)\n- Adiantamento de meses de renda\n- Plataformas de arrendamento com flexibilidade\n\n## Contrato de Arrendamento\n\n- Obrigatoriamente registado nas Finanças\n- Duração mínima: 1 ano (para arrendamentos habituais)\n- Caução: máximo 2 meses de renda\n\n## Os seus direitos\n\nO **Novo Regime do Arrendamento Urbano** protege os inquilinos. O senhorio não pode aumentar a renda arbitrariamente nem forçar a saída sem fundamentação legal.",
                'language' => 'pt',
                'status' => 'published',
                'tags' => ['arrendamento', 'casa', 'habitação', 'contrato', 'fiador'],
                'published_at' => now()->subDays(10),
            ],
            [
                'category_id' => $catEducacao?->id,
                'title' => 'Aprender Português — Recursos gratuitos e pagos',
                'excerpt' => 'Uma lista curada de recursos para aprender ou melhorar o seu português, desde apps gratuitas até cursos com certificação.',
                'content' => "# Aprender Português em Portugal\n\n## Recursos Gratuitos\n\n### Apps\n- **Duolingo** — ótimo para iniciantes\n- **Memrise** — vocabulário e expressões\n- **LanguageTransfer** — curso áudio gratuito\n\n### Online\n- **RTP Play** — conteúdo em português com legendas\n- **YouTube** — canais como 'Português com Vanessa'\n\n## Cursos com Certificação\n\n### DIPLE / CIPLE (B1)\nCertificação oficial do Camões Instituto. Necessária para alguns pedidos de AR.\n\n### Curso de Português para Estrangeiros (CPE)\nOferta gratuita pelo Estado português para imigrantes — verifique disponibilidade no IEFP ou Santa Casa.\n\n## Conversação\n\n- **Meetup** — grupos de intercâmbio linguístico em Lisboa e Porto\n- **Tandem** — app de parceiros linguísticos\n\n## Dica\n\nPratique com portugueses! O sotaque e expressões idiomáticas aprendem-se melhor na prática do dia-a-dia.",
                'language' => 'pt',
                'status' => 'published',
                'tags' => ['português', 'língua', 'cursos', 'CIPLE', 'integração'],
                'published_at' => now()->subDays(5),
            ],
            [
                'category_id' => $catFinancas?->id,
                'title' => 'How to Get a NIF in Portugal — Complete Guide for Expats',
                'excerpt' => 'The NIF (Tax Identification Number) is essential for almost everything in Portugal. Learn how to get yours step by step.',
                'content' => "# How to Get a NIF in Portugal\n\nThe **NIF (Número de Identificação Fiscal)** is Portugal's tax identification number. You'll need it for banking, working, renting, and much more.\n\n## Who Can Get a NIF?\n\nAnyone — resident or non-resident — can get a NIF in Portugal.\n\n## Required Documents\n\n- Valid ID (passport or national ID)\n- Proof of address (from your home country or Portugal)\n- Non-residents: a fiscal representative with a Portuguese NIF\n\n## Step by Step\n\n### Option 1: In Person at Tax Office (AT/Finanças)\nVisit any Finanças office with your documents. It's free and usually done on the spot.\n\n### Option 2: Through a Fiscal Representative\nNon-residents can apply through an authorized fiscal representative. Services cost between €60–€150.\n\n## Tips\n\n- Bring copies of all documents\n- The process is usually immediate at the counter\n- Keep your NIF card safe — it's used constantly",
                'language' => 'en',
                'status' => 'published',
                'tags' => ['NIF', 'tax', 'expat', 'documentation', 'finances'],
                'published_at' => now()->subDays(25),
            ],
        ];

        foreach ($guides as $data) {
            $tags = $data['tags'] ?? null;
            unset($data['tags']);

            Guide::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, [
                    'author_id' => $admin->id,
                    'slug' => Str::slug($data['title']),
                    'views_count' => rand(50, 500),
                    'tags' => $tags,
                ])
            );
        }
    }
}
