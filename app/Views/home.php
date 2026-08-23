<?= $this->extend('layout') ?>
<?= $this->section('conteudo') ?>

<?php if ($featured_post) : ?>
<?php
$hasHeroBackground = $theme['hero_background_path'] !== '';
$heroOpacity = max(0.55, min(0.98, (float) $theme['hero_background_opacity']));
?>
<section class="home-hero<?= $hasHeroBackground ? ' home-hero--background' : '' ?>"<?php if ($hasHeroBackground) : ?> style="background-image:linear-gradient(rgba(255,255,255,<?= $heroOpacity ?>),rgba(255,255,255,<?= $heroOpacity ?>)),url('<?= esc(base_url($theme['hero_background_path']), 'attr') ?>')"<?php endif ?>><div class="container"><div class="home-hero__grid">
    <div class="home-hero__content"><?php if ($theme['logo_path'] !== '') : ?><img class="home-hero__logo" src="<?= base_url($theme['logo_path']) ?>" alt="<?= esc($theme['site_name'], 'attr') ?>"><?php endif ?><h1><?= esc($theme['site_tagline']) ?></h1><p><?= esc($theme['site_description']) ?></p></div>
    <div class="home-hero__featured">
        <span class="eyebrow"><?= esc($theme['hero_label']) ?></span>
        <a class="home-hero__media" href="<?= base_url('post/' . $featured_post['slug']) ?>"><img class="js-featured-cover" src="<?= base_url('uploads/' . $featured_post['img']) ?>" alt="Capa: <?= esc($featured_post['titulo'], 'attr') ?>"><span class="home-hero__caption"><strong><?= esc($featured_post['titulo']) ?></strong><small><?= esc($featured_post['nome_categoria']) ?></small></span></a>
        <a class="button button--primary home-hero__button" href="<?= base_url('post/' . $featured_post['slug']) ?>"><?= esc($theme['hero_button']) ?> <span>→</span></a>
    </div>
</div></div></section>
<?php endif ?>

<div class="container home-content">
    <?php if ($theme['show_categories'] === '1' && !empty($categorias)) : ?>
        <nav class="category-chips" aria-label="Categorias"><a class="active" href="<?= base_url() ?>">Todos</a><?php foreach ($categorias as $categoria) : ?><a href="<?= base_url('categoria/' . $categoria['slug']) ?>"><?= esc($categoria['nome']) ?></a><?php endforeach ?></nav>
    <?php endif ?>
    <div class="section-heading"><div><span class="eyebrow">Conteúdo selecionado</span><h2><?= esc($theme['recent_title']) ?></h2></div><span class="section-heading__line"></span></div>
    <?php if (!empty($posts)) : ?>
        <div class="article-grid">
            <?php foreach ($posts as $post) : ?>
                <article class="article-card"><a class="article-card__image" href="<?= base_url('post/' . $post['slug']) ?>"><img loading="lazy" src="<?= base_url('uploads/' . $post['img']) ?>" alt="Capa: <?= esc($post['titulo'], 'attr') ?>"></a><div class="article-card__body"><div class="article-card__meta"><a href="<?= base_url('categoria/' . $post['slug_categoria']) ?>"><?= esc($post['nome_categoria']) ?></a><span><?= isset($post['created_at']) ? date('d/m/Y', strtotime($post['created_at'])) : '' ?></span></div><h3><a href="<?= base_url('post/' . $post['slug']) ?>"><?= esc($post['titulo']) ?></a></h3><p><?= esc($post['subtitulo']) ?></p><a class="article-card__link" href="<?= base_url('post/' . $post['slug']) ?>">Continuar lendo <span>→</span></a></div></article>
            <?php endforeach ?>
        </div>
    <?php else : ?><div class="empty-state">Nenhuma postagem publicada.</div><?php endif ?>
    <?php if ($pager) : ?><div class="theme-pagination"><?= $pager->links('default', 'bootstrap_pagination') ?></div><?php endif ?>
    <?php if ($theme['show_newsletter'] === '1') : ?>
        <section class="newsletter" aria-labelledby="newsletter-title"><div class="newsletter__icon">✉</div><div><h2 id="newsletter-title"><?= esc($theme['newsletter_title']) ?></h2><p><?= esc($theme['newsletter_text']) ?></p></div><div class="newsletter__form"><input type="email" placeholder="Seu melhor e-mail" aria-label="Seu melhor e-mail"><button type="button">Assinar newsletter</button></div></section>
    <?php endif ?>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>document.querySelectorAll('.js-featured-cover').forEach(function(image){function adjust(){image.parentElement.classList.toggle('home-hero__media--portrait',image.naturalHeight>image.naturalWidth*1.12)}image.complete?adjust():image.addEventListener('load',adjust,{once:true})});</script>
<?= $this->endSection() ?>
