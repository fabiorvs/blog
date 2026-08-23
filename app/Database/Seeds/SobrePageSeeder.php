<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SobrePageSeeder extends Seeder
{
    public function run()
    {
        $contentFile = APPPATH . 'Database/Data/sobre.html';
        $content = is_file($contentFile) ? file_get_contents($contentFile) : false;
        if ($content === false || trim($content) === '') {
            throw new \RuntimeException('O conteúdo da página Sobre não foi encontrado.');
        }

        $user = $this->db->table('usuarios')->select('id')->where('deleted_at', null)->orderBy('id', 'ASC')->get()->getRowArray();
        if ($user === null) { throw new \RuntimeException('Execute o UsuarioSeeder antes de criar a página Sobre.'); }

        $data = [
            'usuario' => (int) $user['id'],
            'nome' => 'Sobre',
            'titulo' => 'ABADÁ CAPOEIRA SÃO PAULO',
            'slug' => 'sobre',
            'conteudo' => trim($content),
            'situacao' => 'Publicado',
            'deleted_at' => null,
        ];

        $page = $this->db->table('paginas')->select('id')->where('slug', 'sobre')->get()->getRowArray();
        if ($page === null) {
            $this->db->table('paginas')->insert($data);
            return;
        }

        $this->db->table('paginas')->where('id', $page['id'])->update($data);
    }
}
