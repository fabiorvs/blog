<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTituloToPaginas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('paginas', [
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
                'after' => 'nome',
            ],
        ]);

        $this->db->query('UPDATE paginas SET titulo = nome WHERE titulo IS NULL OR titulo = ?', ['']);
    }

    public function down()
    {
        $this->forge->dropColumn('paginas', 'titulo');
    }
}
