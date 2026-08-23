<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\UserService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Usuario extends BaseController
{
    private UserService $users;

    public function __construct(?UserService $users = null)
    {
        $this->users = $users ?? new UserService();
    }

    public function index()
    {
        return view('admin/usuario_index', $this->users->paginated($this->perPage()));
    }

    public function novo()
    {
        return view('admin/usuario_novo');
    }

    public function salvar($id = null)
    {
        $id = $id === null ? null : (int) $id;
        if ($id !== null && $this->users->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('Usuário não encontrado.');
        }

        $result = $this->users->save([
            'nome' => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
            'senha' => $this->request->getPost('senha'),
            'confirmacao_senha' => $this->request->getPost('confirmacao_senha'),
        ], $id);

        if (!$result['success']) {
            return redirect()->back()->withInput()->with('errors', $result['errors'] ?: ['Não foi possível salvar o usuário.']);
        }

        if ($id !== null && $id === (int) session('id')) {
            session()->set(['name' => trim((string) $this->request->getPost('nome')), 'email' => strtolower(trim((string) $this->request->getPost('email')))]);
        }

        return redirect()->to('/admin/usuario')->with('success', 'Usuário salvo com sucesso.');
    }

    public function editar($id)
    {
        $usuario = $this->users->find((int) $id);
        if ($usuario === null) { throw PageNotFoundException::forPageNotFound('Usuário não encontrado.'); }
        return view('admin/usuario_editar', ['usuario' => $usuario]);
    }

    public function excluir($id)
    {
        $id = (int) $id;
        if ($id === (int) session('id')) {
            return redirect()->back()->with('errors', ['Você não pode excluir a própria conta enquanto está conectado.']);
        }
        if ($this->users->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('Usuário não encontrado.');
        }
        if ($this->users->delete($id)) {
            return redirect()->to('/admin/usuario')->with('success', 'Usuário excluído com sucesso.');
        }
        return redirect()->back()->with('errors', ['Não foi possível excluir o usuário.']);
    }
}
