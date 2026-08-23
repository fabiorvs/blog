<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NormalizeContentStatus extends Migration
{
    public function up()
    {
        foreach (['postagens', 'paginas'] as $table) {
            $this->db->query("UPDATE {$table} SET situacao = 'publicado' WHERE LOWER(situacao) = 'publicado' OR situacao IS NULL OR situacao = ''");
            $this->db->query("UPDATE {$table} SET situacao = 'aprovacao' WHERE LOWER(situacao) IN ('aprovação', 'em aprovação', 'aprovacao', 'em aprovacao')");
            $this->db->query("UPDATE {$table} SET situacao = 'rascunho' WHERE situacao NOT IN ('publicado', 'aprovacao', 'rascunho')");
            $this->forge->modifyColumn($table, [
                'situacao' => [
                    'name' => 'situacao',
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'default' => 'rascunho',
                    'null' => false,
                ],
            ]);
        }
    }

    public function down()
    {
        foreach (['postagens', 'paginas'] as $table) {
            $this->db->query("UPDATE {$table} SET situacao = 'Publicado' WHERE situacao = 'publicado'");
            $this->db->query("UPDATE {$table} SET situacao = 'Rascunho' WHERE situacao IN ('rascunho', 'aprovacao')");
            $this->forge->modifyColumn($table, [
                'situacao' => [
                    'name' => 'situacao',
                    'type' => 'VARCHAR',
                    'constraint' => $table === 'postagens' ? 50 : 45,
                    'default' => 'Publicado',
                    'null' => false,
                ],
            ]);
        }
    }
}
