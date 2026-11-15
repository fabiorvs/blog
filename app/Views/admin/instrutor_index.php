<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<div class="admin-page-header"><div><h1>Aulas e locais</h1><p>Cadastre quem ministra aulas de capoeira e seus locais de atuação.</p></div><a class="admin-btn admin-btn--primary" href="<?= base_url('admin/instrutor/novo') ?>"><svg class="admin-icon"><use href="#icon-plus"/></svg>Novo cadastro</a></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Pessoa responsável</th><th>Graduação</th><th class="text-end">Ações</th></tr></thead><tbody>
<?php foreach ($instrutores as $instrutor) : ?><tr><td><div class="admin-table__title"><?= esc($instrutor['apelido']) ?></div><div class="text-muted"><?= esc($instrutor['nome']) ?></div></td><td><?= esc($instrutor['graduacao']) ?></td><td><div class="admin-actions"><a class="admin-btn admin-btn--secondary" href="<?= base_url('admin/instrutor/editar/' . $instrutor['id']) ?>">Editar</a><form action="<?= base_url('admin/instrutor/excluir/' . $instrutor['id']) ?>" method="post"><?= csrf_field() ?><button class="admin-btn admin-btn--danger" type="submit" onclick="return confirm('Excluir este cadastro?')">Excluir</button></form></div></td></tr><?php endforeach ?>
<?php if (empty($instrutores)) : ?><tr><td colspan="3" class="admin-empty">Nenhuma pessoa cadastrada.</td></tr><?php endif ?></tbody></table></div></section>
<?php if ($pager) : ?><div class="mt-4"><?= $pager->links('default', 'bootstrap_pagination') ?></div><?php endif ?>
<?= $this->endSection() ?>
