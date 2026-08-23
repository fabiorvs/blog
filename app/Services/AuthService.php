<?php

namespace App\Services;

use App\Models\UsuarioModel;

class AuthService
{
    private UsuarioModel $usuarios;

    public function __construct(?UsuarioModel $usuarios = null)
    {
        $this->usuarios = $usuarios ?? new UsuarioModel();
    }

    public function authenticate(string $email, string $password): ?array
    {
        $usuario = $this->usuarios->findByEmail($email);

        if ($usuario === null || !$this->passwordMatches($password, (string) $usuario['senha'])) {
            return null;
        }

        // Atualiza transparentemente os hashes MD5 legados no primeiro login válido.
        if ($this->isLegacyMd5((string) $usuario['senha'])) {
            $novoHash = password_hash($password, PASSWORD_DEFAULT);
            $this->usuarios->update($usuario['id'], ['senha' => $novoHash]);
            $usuario['senha'] = $novoHash;
        }

        return $usuario;
    }

    private function passwordMatches(string $password, string $hash): bool
    {
        if ($this->isLegacyMd5($hash)) {
            return hash_equals(strtolower($hash), md5($password));
        }

        return password_verify($password, $hash);
    }

    private function isLegacyMd5(string $hash): bool
    {
        return preg_match('/^[a-f0-9]{32}$/i', $hash) === 1;
    }
}
