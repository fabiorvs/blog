<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaginasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'usuario' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
            ],
            'conteudo' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false,
            ],
            'situacao' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'default' => 'Publicado',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('usuario');
        $this->forge->addForeignKey('usuario', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('paginas');
    }

    public function down()
    {
        $this->forge->dropTable('paginas');
    }
}
