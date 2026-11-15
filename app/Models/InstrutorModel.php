<?php

namespace App\Models;

use CodeIgniter\Model;

class InstrutorModel extends Model
{
    protected $table = 'instrutores';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nome', 'apelido', 'graduacao', 'email', 'whatsapp', 'biografia', 'foto_perfil', 'fotos', 'senha_hash', 'convite_token', 'convite_expira_em'];
}
