<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<div class="admin-page-header"><div><h1>Categorias</h1><p>Organize as postagens em assuntos fáceis de navegar.</p></div><a class="admin-btn admin-btn--primary" href="<?= base_url('admin/categoria/novo') ?>"><svg class="admin-icon"><use href="#icon-plus"/></svg>Nova categoria</a></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>ID</th><th>Categoria</th><th class="text-end">Ações</th></tr></thead><tbody>
<?php foreach ($categorias as $categoria) : ?><tr><td>#<?= $categoria['id'] ?></td><td><div class="admin-table__title"><?= esc($categoria['nome']) ?></div></td><td><div class="admin-actions"><a class="admin-btn admin-btn--secondary" href="<?= base_url('admin/categoria/editar/' . $categoria['id']) ?>">Editar</a><form action="<?= base_url('admin/categoria/excluir/' . $categoria['id']) ?>" method="post"><?= csrf_field() ?><button class="admin-btn admin-btn--danger" type="submit" onclick="return confirm('Excluir esta categoria?')">Excluir</button></form></div></td></tr><?php endforeach ?>
<?php if (empty($categorias)) : ?><tr><td colspan="3" class="admin-empty">Nenhuma categoria cadastrada.</td></tr><?php endif ?>
</tbody></table></div></section><?php if ($pager) : ?><div class="mt-4"><?= $pager->links('default', 'bootstrap_pagination') ?></div><?php endif ?>
<?= $this->endSection() ?>
