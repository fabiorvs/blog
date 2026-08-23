<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>
<div class="admin-page-header"><div><h1>Páginas</h1><p>Gerencie conteúdos institucionais e links do menu.</p></div><a class="admin-btn admin-btn--primary" href="<?= base_url('admin/pagina/novo') ?>"><svg class="admin-icon"><use href="#icon-plus"/></svg>Nova página</a></div>
<?php if (! empty($menuPages)) : ?>
<section class="admin-card menu-order-card">
    <div class="admin-card__header"><div><h2>Ordem do menu</h2><p>Organize a sequência das páginas exibidas no cabeçalho e no rodapé.</p></div></div>
    <form action="<?= base_url('admin/pagina/ordenar') ?>" method="post"><?= csrf_field() ?>
        <ol class="menu-order-list" id="menuOrderList">
            <?php foreach ($menuPages as $paginaMenu) : ?>
                <?php $menuStatus = \App\Services\ContentStatus::normalize($paginaMenu['situacao'] ?? null); ?>
                <li class="menu-order-item">
                    <input type="hidden" name="ordem[]" value="<?= (int) $paginaMenu['id'] ?>">
                    <span class="menu-order-item__handle" aria-hidden="true">⋮⋮</span>
                    <span class="menu-order-item__position"></span>
                    <span class="menu-order-item__name"><?= esc($paginaMenu['nome']) ?><small><?= esc($paginaMenu['titulo'] ?: $paginaMenu['nome']) ?></small></span>
                    <span class="content-status content-status--<?= esc($menuStatus, 'attr') ?>"><?= esc(\App\Services\ContentStatus::label($menuStatus)) ?></span>
                    <span class="menu-order-item__actions"><button type="button" data-move="up" aria-label="Mover <?= esc($paginaMenu['nome'], 'attr') ?> para cima">↑</button><button type="button" data-move="down" aria-label="Mover <?= esc($paginaMenu['nome'], 'attr') ?> para baixo">↓</button></span>
                </li>
            <?php endforeach ?>
        </ol>
        <div class="menu-order-footer"><span>Apenas páginas publicadas aparecem no site.</span><button class="admin-btn admin-btn--primary" type="submit">Salvar ordem</button></div>
    </form>
</section>
<?php endif ?>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>ID</th><th>Página</th><th>Situação</th><th>Data</th><th class="text-end">Ações</th></tr></thead><tbody>
<?php foreach ($paginas as $pagina) : ?><?php $status = \App\Services\ContentStatus::normalize($pagina['situacao'] ?? null); ?><tr><td>#<?= $pagina['id'] ?></td><td><div class="admin-table__title"><?= esc($pagina['nome']) ?> <span class="admin-table__meta">— <?= esc($pagina['titulo'] ?: $pagina['nome']) ?></span></div><div class="admin-table__meta">/pagina/<?= esc($pagina['slug']) ?></div></td><td><span class="content-status content-status--<?= esc($status, 'attr') ?>"><?= esc(\App\Services\ContentStatus::label($status)) ?></span></td><td><?= data_hora_br($pagina['created_at']) ?></td><td><div class="admin-actions"><?php if ($status !== \App\Services\ContentStatus::DRAFT) : ?><a class="admin-btn admin-btn--secondary" href="<?= base_url('pagina/' . $pagina['slug']) ?>" target="_blank">Ver</a><?php endif ?><a class="admin-btn admin-btn--secondary" href="<?= base_url('admin/pagina/editar/' . $pagina['id']) ?>">Editar</a><form action="<?= base_url('admin/pagina/excluir/' . $pagina['id']) ?>" method="post"><?= csrf_field() ?><button class="admin-btn admin-btn--danger" type="submit" onclick="return confirm('Excluir esta página?')">Excluir</button></form></div></td></tr><?php endforeach ?>
<?php if (empty($paginas)) : ?><tr><td colspan="5" class="admin-empty">Nenhuma página cadastrada.</td></tr><?php endif ?>
</tbody></table></div></section><?php if ($pager) : ?><div class="mt-4"><?= $pager->links('default', 'bootstrap_pagination') ?></div><?php endif ?>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>document.querySelectorAll('[data-move]').forEach(function(button){button.addEventListener('click',function(){var item=button.closest('.menu-order-item');var sibling=button.dataset.move==='up'?item.previousElementSibling:item.nextElementSibling;if(!sibling)return;if(button.dataset.move==='up')item.parentNode.insertBefore(item,sibling);else item.parentNode.insertBefore(sibling,item);})});</script>
<?= $this->endSection() ?>
