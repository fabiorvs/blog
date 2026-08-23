<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MestreCamisaPageSeeder extends Seeder
{
    public function run()
    {
        $usuario = $this->db->table('usuarios')
            ->select('id')
            ->where('deleted_at', null)
            ->orderBy('id', 'ASC')
            ->get()
            ->getRowArray();

        if ($usuario === null) {
            throw new \RuntimeException('Crie o usuário administrador antes de cadastrar a página.');
        }

        $conteudo = <<<'HTML'
<figure style="margin: 0 0 2rem">
    <img src="/uploads/mestre-camisa.jpg" alt="Mestre Camisa segurando um berimbau" style="width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:14px">
    <figcaption style="font-size:.82rem;color:#6b756f;margin-top:.6rem">Mestre Camisa, fundador da ABADÁ-Capoeira. Imagem: reprodução/Globo Esporte.</figcaption>
</figure>

<p><strong>José Tadeu Carneiro Cardoso</strong>, conhecido mundialmente como Mestre Camisa, nasceu em 28 de outubro de 1955, na Fazenda Estiva, região de Jacobina, Bahia. Sua história se confunde com a expansão contemporânea da capoeira: da infância no sertão baiano às rodas de Salvador, das primeiras aulas no Rio de Janeiro à criação de uma organização presente em dezenas de países.</p>

<h2>Da Bahia para a capoeira</h2>
<p>O primeiro contato de Camisa com a capoeira aconteceu ainda na juventude, influenciado pelo irmão mais velho, Camisa Roxa. Depois de se mudar para Salvador, frequentou rodas de rua ligadas a mestres como Waldemar e Traíra e aprofundou sua formação na academia de Mestre Bimba, referência fundamental da Capoeira Regional.</p>
<p>Esse aprendizado reuniu tradição, disciplina, musicalidade e atenção à eficiência dos movimentos — elementos que mais tarde marcariam sua maneira de ensinar. Ainda jovem, também participou de apresentações de manifestações populares brasileiras, levando capoeira, samba de roda, maculelê e outras expressões culturais aos palcos.</p>

<h2>A chegada ao Rio de Janeiro</h2>
<p>Em 1972, aos 16 anos, mudou-se para o Rio de Janeiro e começou a ensinar em academias. Sem se afastar dos fundamentos aprendidos na Bahia, dedicou-se à pesquisa e à organização de uma metodologia própria, buscando tornar o ensino mais progressivo, técnico e seguro.</p>
<p>Durante esse período integrou o Grupo Senzala e consolidou sua atuação como professor. Sua proposta combinava aspectos da Capoeira Regional e da Capoeira Angola, preservando o diálogo com a tradição enquanto adaptava o treinamento às necessidades de novos públicos.</p>

<h2>A fundação da ABADÁ-Capoeira</h2>
<p>Em 1988, Mestre Camisa fundou a <strong>Associação Brasileira de Apoio e Desenvolvimento da Arte-Capoeira — ABADÁ-Capoeira</strong>. A entidade nasceu com o propósito de apoiar capoeiristas, aperfeiçoar a formação técnica e pedagógica e divulgar a cultura brasileira.</p>
<p>A filosofia da organização costuma ser resumida pela ideia de avançar mantendo “um pé no passado e outro no futuro”: respeitar os mestres, a história, os rituais e a musicalidade da capoeira, ao mesmo tempo em que a arte continua evoluindo. Segundo a ABADÁ-Capoeira San Francisco, a rede está presente em mais de 70 países e reúne aproximadamente 80 mil praticantes.</p>

<h2>Educação, cultura e legado</h2>
<p>Ao longo de sua trajetória, Mestre Camisa ministrou cursos e palestras nos cinco continentes. Seu trabalho ajudou a apresentar a capoeira como uma expressão ampla, na qual luta, jogo, música, ritual, poesia, educação e desenvolvimento humano permanecem inseparáveis.</p>
<p>Em 28 de maio de 2010, recebeu da Universidade Federal de Uberlândia o título de Doutor Honoris Causa, em reconhecimento à contribuição para a cultura afro-brasileira e à atuação cultural, social e educacional. Seu legado também está na formação de gerações de instrutores, professores e mestres que dão continuidade à capoeira em diferentes comunidades do Brasil e do mundo.</p>

<blockquote style="border-left:4px solid var(--theme-accent);margin:2rem 0;padding:.4rem 0 .4rem 1.4rem;font-family:var(--theme-serif);font-size:1.35rem">Para Mestre Camisa, a capoeira permanece viva quando tradição, pesquisa e transformação caminham juntas.</blockquote>

<h2>Fontes consultadas</h2>
<ul>
    <li><a href="https://www.abada.org/international/" target="_blank" rel="noopener">ABADÁ-Capoeira San Francisco — história, filosofia e atuação internacional</a></li>
    <li><a href="https://abadacapoeira.poa.br/mestre-camisa/" target="_blank" rel="noopener">ABADÁ-Capoeira Porto Alegre — biografia de Mestre Camisa</a></li>
    <li><a href="https://ge.globo.com/combate/noticia/2025/09/17/mestre-camisa-destaca-legado-importancia-e-internacionalizacao-da-capoeira.ghtml" target="_blank" rel="noopener">Globo Esporte — entrevista sobre legado e internacionalização da capoeira</a></li>
</ul>
HTML;

        $data = [
            'usuario' => (int) $usuario['id'],
            'nome' => 'Mestre Camisa',
            'titulo' => 'Mestre Camisa: uma vida dedicada à Capoeira',
            'slug' => 'mestre-camisa',
            'conteudo' => $conteudo,
            'situacao' => 'Publicado',
            'deleted_at' => null,
        ];

        $pagina = $this->db->table('paginas')->select('id')->where('slug', $data['slug'])->get()->getRowArray();
        if ($pagina === null) {
            $this->db->table('paginas')->insert($data);
            return;
        }

        $this->db->table('paginas')->where('id', $pagina['id'])->update($data);
    }
}
