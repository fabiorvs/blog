<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderToPages extends Migration
{
    public function up()
    {
        $this->forge->addColumn('paginas', [
            'ordem' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
                'after' => 'situacao',
            ],
        ]);

        $pages = $this->db->table('paginas')->select('id')->orderBy('id', 'ASC')->get()->getResultArray();
        foreach ($pages as $position => $page) {
            $this->db->table('paginas')->where('id', $page['id'])->update(['ordem' => $position + 1]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('paginas', 'ordem');
    }
}
