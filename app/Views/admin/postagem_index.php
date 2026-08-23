<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<div class="admin-page-header"><div><h1>Postagens</h1><p>Crie, edite e acompanhe os artigos do blog.</p></div><a class="admin-btn admin-btn--primary" href="<?= base_url('admin/postagem/novo') ?>"><svg class="admin-icon"><use href="#icon-plus"/></svg>Nova postagem</a></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>ID</th><th>Postagem</th><th>Categoria</th><th>Publicação</th><th class="text-end">Ações</th></tr></thead><tbody>
<?php foreach ($posts as $post) : ?><tr><td>#<?= $post['id'] ?></td><td><div class="admin-table__title"><?= esc($post['titulo']) ?></div><div class="admin-table__meta"><?= esc($post['subtitulo']) ?></div></td><td><?= esc($post['nome_categoria']) ?></td><td><?= data_hora_br($post['created_at']) ?></td><td><div class="admin-actions"><a class="admin-btn admin-btn--secondary" href="<?= base_url('post/' . $post['slug']) ?>" target="_blank">Ver</a><a class="admin-btn admin-btn--secondary" href="<?= base_url('admin/postagem/editar/' . $post['id']) ?>">Editar</a><form action="<?= base_url('admin/postagem/excluir/' . $post['id']) ?>" method="post"><?= csrf_field() ?><button class="admin-btn admin-btn--danger" type="submit" onclick="return confirm('Excluir esta postagem?')">Excluir</button></form></div></td></tr><?php endforeach ?>
<?php if (empty($posts)) : ?><tr><td colspan="5" class="admin-empty">Nenhuma postagem cadastrada.</td></tr><?php endif ?>
</tbody></table></div></section>
<?php if ($pager) : ?><div class="mt-4"><?= $pager->links('default', 'bootstrap_pagination') ?></div><?php endif ?>
<?= $this->endSection() ?>
