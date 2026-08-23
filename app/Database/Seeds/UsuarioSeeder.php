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
            'senha' => password_hash('admin123', PASSWORD_DEFAULT),
            'deleted_at' => null,
        ];

        $usuario = $this->db->table('usuarios')
            ->select('id')
            ->groupStart()
                ->where('email', $data['email'])
                ->orWhere('login', $data['login'])
            ->groupEnd()
            ->get()
            ->getRowArray();

        if ($usuario === null) {
            $this->db->table('usuarios')->insert($data);
            return;
        }

        $this->db->table('usuarios')->where('id', $usuario['id'])->update($data);
    }

    public function down()
    {
        $this->db->table('usuarios')->where('login', 'admin')->delete();
    }
}
