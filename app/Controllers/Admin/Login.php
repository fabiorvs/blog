<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AuthService;
use CodeIgniter\Session\SessionInterface;

class Login extends BaseController
{

    private AuthService $auth;
    private SessionInterface $session;

    public function __construct(?AuthService $auth = null)
    {
        $this->session = session();
        $this->auth = $auth ?? new AuthService();
    }

    public function index()
    {
        if ($this->session->get('logado')) {
            return redirect()->to('/admin');
        }

        return view('login/index');
    }

    public function logar()
    {
        $email = trim((string) $this->request->getPost('email'));
        $senha = (string) $this->request->getPost('senha');
        // Mantém compatibilidade com o usuário legado "admin@admin" criado pelo seeder.
        if ($email === '' || strpos($email, '@') === false || strlen($email) > 200 || $senha === '') {
            return redirect()->back()->withInput()->with('msg', 'Informe um e-mail e uma senha válidos.');
        }
        $usuario = $this->auth->authenticate($email, $senha);
        if ($usuario) {
            $this->session->regenerate(true);
            $ses_data = [
                'id' => $usuario['id'],
                'name' => $usuario['nome'],
                'email' => $usuario['email'],
                'logado' => true,
            ];
            $this->session->set($ses_data);
            return redirect()->to('/admin');
        } else {
            $this->session->setFlashdata('msg', 'Usuário ou senha inválida.');
            return redirect()->to('/admin/login');
        }
    }

    public function deslogar()
    {
        $this->session->destroy();
        return redirect()->to('/admin/login');
    }
}
