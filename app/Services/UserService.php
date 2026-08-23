<?php

namespace App\Services;

use App\Models\UsuarioModel;

class UserService
{
    private UsuarioModel $usuarios;

    public function __construct(?UsuarioModel $usuarios = null)
    {
        $this->usuarios = $usuarios ?? new UsuarioModel();
    }

    public function paginated(int $perPage): array
    {
        return ['usuarios' => $this->usuarios->get_usuarios()->paginate($perPage), 'pager' => $this->usuarios->pager];
    }

    public function find(int $id): ?array
    {
        return $this->usuarios->find($id);
    }

    public function save(array $data, ?int $id = null): array
    {
        $nome = trim((string) ($data['nome'] ?? ''));
        $email = strtolower(trim((string) ($data['email'] ?? '')));
        $senha = (string) ($data['senha'] ?? '');
        $confirmacao = (string) ($data['confirmacao_senha'] ?? '');
        $errors = [];

        if ($nome === '' || mb_strlen($nome) > 200) { $errors[] = 'Informe um nome com até 200 caracteres.'; }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 200) { $errors[] = 'Informe um e-mail válido.'; }
        if ($email !== '' && $this->usuarios->emailExists($email, $id)) { $errors[] = 'Este e-mail já está sendo utilizado.'; }
        if ($id === null && $senha === '') { $errors[] = 'Informe uma senha para o novo usuário.'; }
        if ($senha !== '' && strlen($senha) < 8) { $errors[] = 'A senha deve ter pelo menos 8 caracteres.'; }
        if ($senha !== $confirmacao) { $errors[] = 'A confirmação da senha não confere.'; }

        if ($errors !== []) { return ['success' => false, 'errors' => $errors]; }

        $usuario = ['nome' => $nome, 'email' => $email];
        if ($senha !== '') { $usuario['senha'] = password_hash($senha, PASSWORD_DEFAULT); }
        if ($id !== null) { $usuario['id'] = $id; }

        return ['success' => $this->usuarios->save($usuario), 'errors' => []];
    }

    public function delete(int $id): bool
    {
        return (bool) $this->usuarios->delete($id);
    }
}
