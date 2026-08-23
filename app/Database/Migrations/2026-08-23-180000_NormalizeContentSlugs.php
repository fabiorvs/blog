<?php

namespace App\Database\Migrations;

use App\Services\SlugService;
use CodeIgniter\Database\Migration;

class NormalizeContentSlugs extends Migration
{
    public function up()
    {
        $this->normalizeTable('postagens', 'titulo');
        $this->normalizeTable('paginas', 'nome');
    }

    public function down()
    {
        // A transliteração não pode ser revertida com segurança.
    }

    private function normalizeTable(string $table, string $fallbackField): void
    {
        $rows = $this->db->table($table)
            ->select("id, slug, {$fallbackField}")
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
        $used = [];

        foreach ($rows as $row) {
            $source = trim((string) $row['slug']) !== '' ? $row['slug'] : $row[$fallbackField];
            $base = SlugService::make((string) $source, 'conteudo-' . $row['id']);
            $slug = $base;
            $suffix = 2;
            while (isset($used[$slug])) {
                $slug = $base . '-' . $suffix++;
            }
            $used[$slug] = true;

            if ($slug !== $row['slug']) {
                $this->db->table($table)->where('id', $row['id'])->update(['slug' => $slug]);
            }
        }
    }
}
