<?php

namespace App\Models;

use CodeIgniter\Model;

class InstrutorLocalModel extends Model
{
    protected $table = 'instrutor_locais';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['instrutor_id', 'nome', 'endereco', 'dias_horarios', 'latitude', 'longitude'];
}
