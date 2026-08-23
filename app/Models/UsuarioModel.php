<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'email',
        'login',
        'senha',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)
            ->first();
    }

    public function get_usuarios()
    {
        return $this->select('id, nome, email, created_at, updated_at')
            ->orderBy('nome', 'ASC');
    }

    public function emailExists(string $email, ?int $exceptId = null): bool
    {
        $builder = db_connect($this->DBGroup)->table($this->table)
            ->where('email', $email)
            ->where($this->deletedField, null);
        if ($exceptId !== null) { $builder->where('id !=', $exceptId); }
        return $builder->countAllResults() > 0;
    }
}
