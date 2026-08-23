<?= $this->extend('layout') ?>
<?php if ($underReview ?? false) : ?><?= $this->section('meta') ?><meta name="robots" content="noindex,nofollow"><?= $this->endSection() ?><?php endif ?>
<?= $this->section('conteudo') ?>
<article class="post-shell">
    <?php if ($underReview ?? false) : ?><div class="content-review-notice" role="status"><strong>Conteúdo em fase de aprovação</strong><span>Esta postagem ainda não está publicada e só pode ser visualizada por meio do link direto.</span></div><?php endif ?>
    <a class="eyebrow text-decoration-none" href="<?= base_url('categoria/' . $post['slug_categoria']) ?>"><?= esc($post['nome_categoria']) ?></a>
    <h1><?= esc($post['titulo']) ?></h1>
    <p class="text-muted mt-3">Publicado em <?= data_hora_br($post['created_at']) ?> por <?= esc($post['nome_usuario']) ?></p>
    <?php if (!empty($post['img']) && (int) ($post['exibir_capa'] ?? 1) === 1) : ?><img class="post-shell__cover" src="<?= base_url('uploads/' . $post['img']) ?>" alt="Capa: <?= esc($post['titulo'], 'attr') ?>"><?php endif ?>
    <div class="post-content"><?= $post['conteudo'] ?></div>
</article>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>document.querySelectorAll('oembed[url]').forEach(function(el){const frame=document.createElement('iframe');frame.src=el.getAttribute('url').replace('watch?v=','embed/');frame.width='100%';frame.height='440';frame.loading='lazy';frame.allowFullscreen=true;el.replaceWith(frame)});</script>
<?= $this->endSection() ?>
