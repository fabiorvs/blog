<?php if (!empty($posts)) : ?>
<div class="article-grid">
    <?php foreach ($posts as $post) : ?>
        <article class="article-card">
            <a class="article-card__image" href="<?= base_url('post/' . $post['slug']) ?>"><img loading="lazy" src="<?= base_url('uploads/' . $post['img']) ?>" alt="Capa: <?= esc($post['titulo'], 'attr') ?>"></a>
            <div class="article-card__body">
                <div class="article-card__meta"><span><?= esc($post['nome_categoria']) ?></span><span><?= !empty($post['created_at']) ? date('d/m/Y', strtotime($post['created_at'])) : '' ?></span></div>
                <h3><a href="<?= base_url('post/' . $post['slug']) ?>"><?= esc($post['titulo']) ?></a></h3>
                <p><?= esc($post['subtitulo']) ?></p>
                <a class="article-card__link" href="<?= base_url('post/' . $post['slug']) ?>">Continuar lendo →</a>
            </div>
        </article>
    <?php endforeach ?>
</div>
<?php else : ?><div class="empty-state">Nenhuma postagem encontrada.</div><?php endif ?>
