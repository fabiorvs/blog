<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BlogDemoSeeder extends Seeder
{
    public function run()
    {
        $this->db->transStart();

        $usuarioId = $this->ensureUser();
        $categorias = $this->ensureCategories();

        foreach ($this->posts($usuarioId, $categorias) as $post) {
            $existente = $this->db->table('postagens')
                ->select('id')
                ->where('slug', $post['slug'])
                ->get()
                ->getRowArray();

            if ($existente === null) {
                $this->db->table('postagens')->insert($post);
                continue;
            }

            $this->db->table('postagens')
                ->where('id', $existente['id'])
                ->update($post);
        }

        $this->db->transComplete();

        if (!$this->db->transStatus()) {
            throw new \RuntimeException('Não foi possível criar o conteúdo de demonstração.');
        }
    }

    private function ensureUser(): int
    {
        $usuario = $this->db->table('usuarios')
            ->select('id')
            ->where('deleted_at', null)
            ->orderBy('id', 'ASC')
            ->get()
            ->getRowArray();

        if ($usuario !== null) {
            return (int) $usuario['id'];
        }

        $this->db->table('usuarios')->insert([
            'nome' => 'Administrador',
            'email' => 'admin@admin',
            'login' => 'admin',
            'senha' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);

        return (int) $this->db->insertID();
    }

    private function ensureCategories(): array
    {
        $categorias = [
            'desenvolvimento' => 'Desenvolvimento',
            'tecnologia' => 'Tecnologia',
            'negocios' => 'Negócios',
            'produtividade' => 'Produtividade',
        ];
        $ids = [];

        foreach ($categorias as $slug => $nome) {
            $categoria = $this->db->table('categorias')
                ->select('id')
                ->where('slug', $slug)
                ->get()
                ->getRowArray();

            if ($categoria === null) {
                $this->db->table('categorias')->insert(['nome' => $nome, 'slug' => $slug]);
                $ids[$slug] = (int) $this->db->insertID();
            } else {
                $ids[$slug] = (int) $categoria['id'];
            }
        }

        return $ids;
    }

    private function posts(int $usuarioId, array $categorias): array
    {
        $items = [
            ['desenvolvimento', 'Primeiros passos com desenvolvimento web moderno', 'Um roteiro prático para organizar ferramentas, código e aprendizado.', 'primeiros-passos-desenvolvimento-web-moderno', 'capa-desenvolvimento-web.jpg', '<p>Desenvolver para a web ficou mais acessível, mas também exige boas escolhas desde o início. Organize seu ambiente, mantenha as dependências documentadas e prefira pequenas entregas que possam ser verificadas rapidamente.</p><h2>Comece pelo essencial</h2><p>HTML semântico, CSS responsivo e fundamentos de PHP formam uma base sólida. Depois, adicione framework, testes automatizados e controle de versão conforme o projeto crescer.</p><p>Um bom fluxo reduz retrabalho: planeje uma funcionalidade, implemente, teste e registre a decisão. A consistência vale mais que perseguir cada ferramenta nova.</p>'],
            ['tecnologia', 'Cibersegurança: hábitos simples que protegem projetos', 'Medidas práticas para reduzir riscos no desenvolvimento e na operação.', 'ciberseguranca-habitos-que-protegem-projetos', 'capa-ciberseguranca.jpg', '<p>Segurança não deve aparecer somente no fim do projeto. Atualizações frequentes, senhas fortes e permissões mínimas eliminam boa parte dos riscos mais comuns.</p><h2>Proteção em camadas</h2><p>Use hashes adequados para senhas, valide toda entrada recebida e mantenha segredos fora do repositório. No servidor, monitore logs e limite o acesso a serviços internos.</p><p>Backups testados e um processo claro de resposta a incidentes completam a estratégia. O objetivo é tornar falhas menos prováveis e sua recuperação mais rápida.</p>'],
            ['produtividade', 'Trabalho remoto sem perder foco e colaboração', 'Como equilibrar autonomia, comunicação e períodos de concentração.', 'trabalho-remoto-foco-colaboracao', 'capa-trabalho-remoto.jpg', '<p>O trabalho remoto funciona melhor quando a equipe combina expectativas explícitas. Horários de disponibilidade, canais de comunicação e critérios de conclusão precisam estar visíveis.</p><h2>Proteja o tempo de concentração</h2><p>Agrupe reuniões, silencie notificações durante tarefas profundas e registre decisões de forma assíncrona. Assim, todos conseguem acompanhar o projeto sem depender de estar online ao mesmo tempo.</p><p>Um espaço confortável e pausas regulares também ajudam a sustentar energia ao longo do dia.</p>'],
            ['tecnologia', 'Inteligência artificial aplicada ao dia a dia', 'Ideias para usar IA com responsabilidade, revisão e objetivos claros.', 'inteligencia-artificial-aplicada-dia-a-dia', 'capa-inteligencia-artificial.jpg', '<p>A inteligência artificial pode acelerar pesquisa, organização e tarefas repetitivas. O ganho aparece quando existe um objetivo claro e alguém responsável por revisar o resultado.</p><h2>Use como ferramenta, não como piloto automático</h2><p>Forneça contexto, descreva as restrições e verifique informações importantes. Dados confidenciais não devem ser enviados a serviços sem uma política adequada.</p><p>Comece por processos de baixo risco, meça o tempo economizado e documente o que realmente funcionou.</p>'],
            ['negocios', 'Métricas digitais que ajudam na tomada de decisão', 'Escolha indicadores que expliquem comportamento, não apenas volume.', 'metricas-digitais-tomada-de-decisao', 'capa-analytics-mobile.jpg', '<p>Uma tela cheia de números não garante clareza. Métricas úteis estão ligadas a uma pergunta de negócio e levam a uma decisão possível.</p><h2>Contexto antes do indicador</h2><p>Compare períodos equivalentes, observe tendências e separe aquisição, ativação e retenção. Uma taxa acompanhada ao longo do tempo costuma revelar mais que um total isolado.</p><p>Revise o painel regularmente e remova indicadores que ninguém utiliza.</p>'],
            ['tecnologia', 'Tecnologia sustentável além do discurso', 'Eficiência energética, vida útil e escolhas técnicas mensuráveis.', 'tecnologia-sustentavel-alem-do-discurso', 'capa-tecnologia-sustentavel.jpg', '<p>Sustentabilidade em tecnologia inclui energia, equipamentos e eficiência do software. Sistemas bem dimensionados consomem menos recursos e permanecem úteis por mais tempo.</p><h2>Meça antes de otimizar</h2><p>Observe utilização de servidores, volume de dados transferidos e ciclos de substituição. Consolidação de infraestrutura e cache bem aplicado podem reduzir custo e impacto ambiental.</p><p>Metas verificáveis transformam boas intenções em melhoria contínua.</p>'],
            ['tecnologia', 'Cloud computing: quando a nuvem faz sentido', 'Critérios para avaliar flexibilidade, custo e complexidade operacional.', 'cloud-computing-quando-nuvem-faz-sentido', 'capa-cloud-computing.jpg', '<p>A nuvem facilita provisionamento e crescimento, mas não elimina a necessidade de arquitetura e controle de custos. Cada serviço contratado adiciona capacidade e responsabilidade.</p><h2>Decida com base na carga real</h2><p>Mapeie disponibilidade necessária, volume de acesso, armazenamento e competências da equipe. Automatize infraestrutura e mantenha observabilidade desde o primeiro ambiente.</p><p>Planos de contingência e portabilidade devem fazer parte da decisão, mesmo quando a migração não está prevista.</p>'],
            ['produtividade', 'Colaboração criativa em equipes multidisciplinares', 'Técnicas para transformar perspectivas diferentes em soluções melhores.', 'colaboracao-criativa-equipes-multidisciplinares', 'capa-colaboracao.jpg', '<p>Equipes diversas produzem boas soluções quando todas as pessoas conseguem contribuir. Antes de discutir ferramentas, estabeleça o problema, as restrições e o resultado esperado.</p><h2>Separe criação de avaliação</h2><p>Primeiro gere alternativas sem julgamento prematuro. Depois, avalie cada proposta usando critérios compartilhados. Essa separação reduz bloqueios e torna a decisão mais objetiva.</p><p>Finalize registrando responsáveis e próximos passos.</p>'],
            ['produtividade', 'Um sistema simples para organizar a semana', 'Prioridades realistas, blocos de tempo e uma revisão curta.', 'sistema-simples-organizar-semana', 'capa-produtividade.jpg', '<p>Planejamento útil não tenta prever cada minuto. Escolha poucas prioridades, reserve blocos para executá-las e mantenha margem para imprevistos.</p><h2>Faça uma revisão semanal</h2><p>Liste pendências, descarte o que perdeu relevância e transforme objetivos grandes em próximas ações concretas. Agrupe tarefas semelhantes para reduzir trocas de contexto.</p><p>No fim da semana, compare o planejado com o realizado e ajuste o sistema sem culpa.</p>'],
            ['negocios', 'E-commerce para pequenos negócios: fundamentos', 'Uma operação confiável começa pela experiência e pelos processos básicos.', 'ecommerce-pequenos-negocios-fundamentos', 'capa-ecommerce.jpg', '<p>Uma loja virtual precisa transmitir confiança antes de buscar recursos sofisticados. Fotos claras, descrições honestas, frete previsível e atendimento acessível fazem diferença.</p><h2>Cuide da operação completa</h2><p>Estoque, embalagem, pagamento e pós-venda devem funcionar como um único fluxo. Automatize tarefas repetitivas apenas depois de entender onde estão os gargalos.</p><p>Acompanhe conversão, abandono e recompra para decidir as próximas melhorias.</p>'],
        ];

        $posts = [];
        foreach ($items as $index => [$categoria, $titulo, $subtitulo, $slug, $imagem, $conteudo]) {
            $createdAt = date('Y-m-d H:i:s', strtotime('-' . (9 - $index) . ' days'));
            $posts[] = [
                'categoria' => $categorias[$categoria],
                'usuario' => $usuarioId,
                'titulo' => $titulo,
                'subtitulo' => $subtitulo,
                'conteudo' => $conteudo,
                'slug' => $slug,
                'img' => $imagem,
                'situacao' => 'Publicado',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
                'deleted_at' => null,
            ];
        }

        return $posts;
    }
}
