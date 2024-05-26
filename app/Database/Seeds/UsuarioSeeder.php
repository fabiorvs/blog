<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nome' => 'Administrador',
            'email' => 'admin@admin',
            'login' => 'admin',
            'senha' => md5('admin123'),
        ];
        $this->db->table('usuarios')->insert($data);
    }

    public function down()
    {
        $this->db->table('usuarios')->where('login', 'admin')->delete();
    }
}
