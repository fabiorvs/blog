<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddExibirCapaToPostagens extends Migration
{
    public function up()
    {
        $this->forge->addColumn('postagens', [
            'exibir_capa' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
                'default' => 1,
                'after' => 'img',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('postagens', 'exibir_capa');
    }
}
