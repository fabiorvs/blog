<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<div class="admin-page-header"><div><h1>Novo usuário</h1><p>Cadastre uma pessoa com acesso ao painel administrativo.</p></div></div>
<?= view('admin/_usuario_form', ['editing' => false, 'usuario' => [], 'action' => base_url('admin/usuario/salvar')]) ?>
<?= $this->endSection() ?>
