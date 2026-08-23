<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateVisitasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'BIGINT','unsigned'=>true,'auto_increment'=>true],
            'caminho' => ['type'=>'VARCHAR','constraint'=>255],
            'referencia' => ['type'=>'VARCHAR','constraint'=>190,'null'=>true],
            'navegador' => ['type'=>'VARCHAR','constraint'=>40],
            'dispositivo' => ['type'=>'VARCHAR','constraint'=>20],
            'pais' => ['type'=>'CHAR','constraint'=>2,'null'=>true],
            'visitante_hash' => ['type'=>'CHAR','constraint'=>64],
            'visited_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('visited_at');
        $this->forge->addKey('visitante_hash');
        $this->forge->addKey('pais');
        $this->forge->createTable('visitas');
    }
    public function down() { $this->forge->dropTable('visitas'); }
}
