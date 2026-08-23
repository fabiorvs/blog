<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LegacyPostsSeeder extends Seeder
{
    private const CSV = APPPATH . 'Database/Data/postagens_202608231433.csv';

    public function run()
    {
        if (!is_file(self::CSV) || ($handle = fopen(self::CSV, 'rb')) === false) {
            throw new \RuntimeException('O CSV de postagens antigas não foi encontrado.');
        }

        $this->db->transStart();

        try {
            $usuarioId = $this->userId();
            $categoriaId = $this->categoryId();
            $header = fgetcsv($handle, 0, ';', '"', '');

            if ($header !== ['id', 'categoria', 'titulo', 'subtitulo', 'conteudo', 'data', 'img', 'user', 'status']) {
                throw new \RuntimeException('O cabeçalho do CSV de postagens não é compatível.');
            }

            while (($row = fgetcsv($handle, 0, ';', '"', '')) !== false) {
                if ($row === [null] || $row === ['']) { continue; }
                if (count($row) !== 9) {
                    throw new \RuntimeException('Foi encontrada uma linha inválida no CSV de postagens.');
                }

                $title = trim($row[2]);
                $slug = url_title($title, '-', true);
                $content = $this->normalizeContent($row[4]);
                $cover = $this->coverFrom($content);

                if ($title === '' || $cover === '') {
                    throw new \RuntimeException('A postagem antiga #' . $row[0] . ' não possui título ou imagem de capa válida.');
                }

                $data = [
                    'categoria' => $categoriaId,
                    'usuario' => $usuarioId,
                    'titulo' => mb_substr($title, 0, 150),
                    'subtitulo' => mb_substr(trim($row[3]) ?: $title, 0, 150),
                    'conteudo' => $content,
                    'slug' => $slug,
                    'img' => $cover,
                    'exibir_capa' => 0,
                    'situacao' => trim($row[8]) ?: 'Publicado',
                    'created_at' => $row[5],
                    'updated_at' => $row[5],
                    'deleted_at' => null,
                ];

                $existing = $this->db->table('postagens')->select('id')->where('slug', $slug)->get()->getRowArray();
                if ($existing === null) {
                    $this->db->table('postagens')->insert($data);
                } else {
                    $this->db->table('postagens')->where('id', $existing['id'])->update($data);
                }
            }
        } finally {
            fclose($handle);
        }

        $this->db->transComplete();
        if (!$this->db->transStatus()) {
            throw new \RuntimeException('Não foi possível importar as postagens antigas.');
        }
    }

    private function userId(): int
    {
        $user = $this->db->table('usuarios')->select('id')->where('deleted_at', null)->orderBy('id', 'ASC')->get()->getRowArray();
        if ($user === null) { throw new \RuntimeException('Execute o UsuarioSeeder antes da importação.'); }
        return (int) $user['id'];
    }

    private function categoryId(): int
    {
        $category = $this->db->table('categorias')->select('id')->where('slug', 'eventos')->get()->getRowArray();
        if ($category !== null) {
            $this->db->table('categorias')->where('id', $category['id'])->update(['nome' => 'Eventos', 'deleted_at' => null]);
            return (int) $category['id'];
        }

        $this->db->table('categorias')->insert(['nome' => 'Eventos', 'slug' => 'eventos']);
        return (int) $this->db->insertID();
    }

    private function normalizeContent(string $content): string
    {
        $content = preg_replace(
            '#https?://(?:www\.)?abadacapoeirasp\.com\.br/assets/uploads/#i',
            '/uploads/',
            $content
        ) ?? $content;

        return preg_replace('/(<img\b[^>]*?)\s+style="[^"]*"/i', '$1 loading="lazy"', $content) ?? $content;
    }

    private function coverFrom(string $content): string
    {
        preg_match('#/uploads/([^"\']+\.(?:jpe?g|png|gif|webp|peg))#i', $content, $match);
        return isset($match[1]) ? basename($match[1]) : '';
    }
}
