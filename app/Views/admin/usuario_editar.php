<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<div class="admin-page-header"><div><h1>Editar usuário</h1><p>Atualize os dados de acesso ao painel.</p></div></div>
<?= view('admin/_usuario_form', ['editing' => true, 'usuario' => $usuario, 'action' => base_url('admin/usuario/salvar/' . $usuario['id'])]) ?>
<?= $this->endSection() ?>
