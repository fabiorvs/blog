<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfiguracoesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'chave' => ['type' => 'VARCHAR', 'constraint' => 100],
            'valor' => ['type' => 'TEXT', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('chave');
        $this->forge->createTable('configuracoes', true);
    }

    public function down()
    {
        $this->forge->dropTable('configuracoes', true);
    }
}
