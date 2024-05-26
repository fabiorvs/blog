<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostagensTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'categoria' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'usuario' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
            ],
            'subtitulo' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
            ],
            'conteudo' => [
                'type' => 'LONGTEXT',
                'null' => false,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false,
            ],
            'img' => [
                'type' => 'LONGTEXT',
                'null' => false,
            ],
            'situacao' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addKey('categoria');
        $this->forge->addKey('usuario');
        $this->forge->addForeignKey('categoria', 'categorias', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('usuario', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('postagens');
    }

    public function down()
    {
        $this->forge->dropTable('postagens');
    }
}
