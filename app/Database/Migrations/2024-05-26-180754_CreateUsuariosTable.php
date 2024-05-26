<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'img' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'historico' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'login' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'senha' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
