<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<?= view('admin/_instrutor_form', ['action' => base_url('admin/instrutor/salvar/' . $instrutor['id']), 'editing' => true, 'instrutor' => $instrutor, 'locais' => $locais, 'graduacoes' => $graduacoes]) ?>
<?= $this->endSection() ?>
