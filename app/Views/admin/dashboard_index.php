<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<div class="admin-page-header"><div><h1>Visão geral</h1><p>Acompanhe e gerencie o conteúdo publicado.</p></div><a class="admin-btn admin-btn--primary" href="<?= base_url('admin/postagem/novo') ?>"><svg class="admin-icon"><use href="#icon-plus"/></svg>Nova postagem</a></div>
<div class="admin-stat-grid">
    <?php foreach ([[$totalPosts, 'Postagens publicadas', 'icon-posts'], [$totalPages, 'Páginas institucionais', 'icon-page'], [$totalCategories, 'Categorias ativas', 'icon-category'], [$totalUsers, 'Usuários ativos', 'icon-users']] as [$value, $label, $icon]) : ?>
        <div class="admin-card admin-stat"><div><div class="admin-stat__value"><?= $value ?></div><div class="admin-stat__label"><?= $label ?></div></div><span class="admin-stat__icon"><svg class="admin-icon"><use href="#<?= $icon ?>"/></svg></span></div>
    <?php endforeach ?>
</div>
<section class="admin-card"><div class="admin-card__header"><h2>Postagens recentes</h2><a class="admin-btn admin-btn--secondary" href="<?= base_url('admin/postagem') ?>">Ver todas</a></div><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Postagem</th><th>Categoria</th><th>Publicação</th><th></th></tr></thead><tbody>
<?php foreach ($recentPosts as $post) : ?><tr><td><div class="admin-table__title"><?= esc($post['titulo']) ?></div><div class="admin-table__meta">#<?= $post['id'] ?></div></td><td><?= esc($post['nome_categoria']) ?></td><td><?= data_hora_br($post['created_at']) ?></td><td><div class="admin-actions"><a class="admin-btn admin-btn--secondary" href="<?= base_url('admin/postagem/editar/' . $post['id']) ?>">Editar</a></div></td></tr><?php endforeach ?>
<?php if (empty($recentPosts)) : ?><tr><td colspan="4" class="admin-empty">Ainda não há postagens.</td></tr><?php endif ?>
</tbody></table></div></section>
<?= $this->endSection() ?>
