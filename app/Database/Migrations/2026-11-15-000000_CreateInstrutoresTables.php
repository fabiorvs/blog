<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstrutoresTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nome' => ['type' => 'VARCHAR', 'constraint' => 150],
            'apelido' => ['type' => 'VARCHAR', 'constraint' => 100],
            'graduacao' => ['type' => 'VARCHAR', 'constraint' => 30],
            'biografia' => ['type' => 'TEXT', 'null' => true],
            'foto_perfil' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'fotos' => ['type' => 'TEXT', 'null' => true],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('instrutores');

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'instrutor_id' => ['type' => 'INT', 'unsigned' => true],
            'nome' => ['type' => 'VARCHAR', 'constraint' => 150],
            'endereco' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'dias_horarios' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'latitude' => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'longitude' => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('instrutor_id');
        $this->forge->addForeignKey('instrutor_id', 'instrutores', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('instrutor_locais');
    }

    public function down()
    {
        $this->forge->dropTable('instrutor_locais', true);
        $this->forge->dropTable('instrutores', true);
    }
}
