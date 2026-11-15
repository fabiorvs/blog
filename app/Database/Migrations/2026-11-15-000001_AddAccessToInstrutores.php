<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccessToInstrutores extends Migration
{
    public function up()
    {
        $this->forge->addColumn('instrutores', [
            'email' => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true, 'after' => 'graduacao'],
            'whatsapp' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true, 'after' => 'email'],
            'senha_hash' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'fotos'],
            'convite_token' => ['type' => 'CHAR', 'constraint' => 64, 'null' => true, 'after' => 'senha_hash'],
            'convite_expira_em' => ['type' => 'DATETIME', 'null' => true, 'after' => 'convite_token'],
        ]);
        $this->forge->addUniqueKey('email', 'instrutores_email_unique');
    }

    public function down()
    {
        $this->forge->dropKey('instrutores', 'instrutores_email_unique');
        $this->forge->dropColumn('instrutores', ['email', 'whatsapp', 'senha_hash', 'convite_token', 'convite_expira_em']);
    }
}
