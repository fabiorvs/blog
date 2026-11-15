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
    protected $allowedFields = ['nome', 'apelido', 'graduacao', 'biografia', 'foto_perfil', 'fotos'];
}
