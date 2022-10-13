<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Login extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $dados = array();
        return view('login/index', $dados);
    }

    public function logar()
    {
        $email = $this->request->getVar('email');
        $senha = md5($this->request->getVar('senha'));
        $usuario = $this->usuarioModel->get_usuario_login($email, $senha);
        if ($usuario) {
            $ses_data = [
                'id' => $usuario['id'],
                'name' => $usuario['nome'],
                'email' => $usuario['email'],
                'logado' => TRUE
            ];
            $this->session->set($ses_data);
            return redirect()->to('/admin');
        } else {
            $this->session->setFlashdata('msg', 'Usuário ou senha inválida.');
            return redirect()->to('/admin/login');
        }
    }

    public function deslogar(){
        $this->session->destroy();
        return redirect()->to('/admin/login');
    }
}
