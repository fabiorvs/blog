<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>

<div class="admin-page-header">
    <div>
        <h1>Aparência do blog</h1>
        <p>Personalize identidade, destaque e seções da página inicial.</p>
    </div>
    <a class="admin-btn admin-btn--secondary" href="<?= base_url() ?>" target="_blank" rel="noopener">Visualizar blog <svg class="admin-icon"><use href="#icon-external"/></svg></a>
</div>

<form action="<?= base_url('admin/aparencia') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card admin-form-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Identidade</h2>
                    <div class="mb-3">
                        <label class="form-label" for="site_name">Nome do blog</label>
                        <input class="form-control" id="site_name" name="site_name" value="<?= esc($theme['site_name'], 'attr') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="site_tagline">Título principal</label>
                        <input class="form-control" id="site_tagline" name="site_tagline" value="<?= esc($theme['site_tagline'], 'attr') ?>" required>
                    </div>
                    <div>
                        <label class="form-label" for="site_description">Descrição</label>
                        <textarea class="form-control" id="site_description" name="site_description" rows="3"><?= esc($theme['site_description']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="admin-card admin-form-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 mb-1">Analytics e métricas</h2>
                    <p class="text-muted small">Cole tags <code>&lt;script&gt;</code> de serviços como Plausible, Google Analytics ou outro provedor. Por segurança, apenas URLs HTTPS externas e atributos <code>data-*</code> são aceitos; scripts inline são removidos.</p>
                    <label class="form-label" for="analytics_scripts">Scripts</label>
                    <textarea class="form-control font-monospace" id="analytics_scripts" name="analytics_scripts" rows="6" placeholder="&lt;script defer src=&quot;https://analytics.exemplo.com/script.js&quot; data-website-id=&quot;SEU-UUID&quot;&gt;&lt;/script&gt;"><?= esc(html_entity_decode($theme['analytics_scripts'], ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?></textarea>
                    <div class="form-text">Um ou mais scripts, um por linha. Deixe vazio para desativar.</div>
                </div>
            </div>

            <div class="admin-card admin-form-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 mb-1">Imagens da identidade</h2>
                    <p class="text-muted small mb-4">Use arquivos otimizados em JPG, PNG ou WebP, com até 5 MB.</p>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label" for="logo">Logotipo do cabeçalho</label>
                            <?php if ($theme['logo_path'] !== '') : ?>
                                <div class="p-3 rounded border bg-light mb-3"><img src="<?= base_url($theme['logo_path']) ?>" alt="Logo atual" style="max-width: 220px; max-height: 70px; object-fit: contain"></div>
                                <div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1"><label class="form-check-label" for="remove_logo">Remover logo atual</label></div>
                            <?php endif ?>
                            <input class="form-control" type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">Recomendado: PNG ou WebP transparente, até 500 × 160 px.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="hero_background">Imagem de fundo do início</label>
                            <?php if ($theme['hero_background_path'] !== '') : ?>
                                <div class="mb-3"><img src="<?= base_url($theme['hero_background_path']) ?>" alt="Fundo atual" style="width:100%;aspect-ratio:16/6;object-fit:cover;border-radius:10px"></div>
                                <div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="remove_hero_background" name="remove_hero_background" value="1"><label class="form-check-label" for="remove_hero_background">Remover fundo atual</label></div>
                            <?php endif ?>
                            <input class="form-control" type="file" id="hero_background" name="hero_background" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">Recomendado: imagem horizontal com pelo menos 1600 px de largura.</div>
                            <label class="form-label mt-3 d-flex justify-content-between" for="hero_background_opacity"><span>Clarear imagem</span><span id="opacity_value"><?= (int) ((float) $theme['hero_background_opacity'] * 100) ?>%</span></label>
                            <input class="form-range" type="range" id="hero_background_opacity" name="hero_background_opacity" min="0.55" max="0.98" step="0.01" value="<?= esc($theme['hero_background_opacity'], 'attr') ?>" oninput="document.getElementById('opacity_value').textContent=Math.round(this.value*100)+'%'">
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-card admin-form-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Página inicial</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="hero_label">Etiqueta do destaque</label>
                            <input class="form-control" id="hero_label" name="hero_label" value="<?= esc($theme['hero_label'], 'attr') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="hero_button">Texto do botão</label>
                            <input class="form-control" id="hero_button" name="hero_button" value="<?= esc($theme['hero_button'], 'attr') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="featured_post_id">Postagem em destaque</label>
                            <select class="form-select" id="featured_post_id" name="featured_post_id">
                                <option value="0">Usar a postagem mais recente</option>
                                <?php foreach ($posts as $post) : ?>
                                    <option value="<?= $post['id'] ?>" <?= (int) $theme['featured_post_id'] === (int) $post['id'] ? 'selected' : '' ?>><?= esc($post['titulo']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="recent_title">Título da listagem</label>
                            <input class="form-control" id="recent_title" name="recent_title" value="<?= esc($theme['recent_title'], 'attr') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="footer_text">Texto do rodapé</label>
                            <input class="form-control" id="footer_text" name="footer_text" value="<?= esc($theme['footer_text'], 'attr') ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="show_categories" name="show_categories" value="1" <?= $theme['show_categories'] === '1' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="show_categories">Exibir atalhos de categorias</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_newsletter" name="show_newsletter" value="1" <?= $theme['show_newsletter'] === '1' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="show_newsletter">Exibir bloco de newsletter</label>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-6"><input class="form-control" name="newsletter_title" value="<?= esc($theme['newsletter_title'], 'attr') ?>" aria-label="Título da newsletter"></div>
                        <div class="col-md-6"><input class="form-control" name="newsletter_text" value="<?= esc($theme['newsletter_text'], 'attr') ?>" aria-label="Descrição da newsletter"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card sticky-top" style="top: 6rem">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Paleta de cores</h2>
                    <?php foreach (['primary_color' => 'Principal', 'accent_color' => 'Destaque', 'background_color' => 'Fundo', 'text_color' => 'Texto'] as $key => $label) : ?>
                        <label class="form-label d-flex justify-content-between align-items-center" for="<?= $key ?>">
                            <span><?= $label ?></span><code id="<?= $key ?>_value"><?= esc($theme[$key]) ?></code>
                        </label>
                        <input class="form-control form-control-color w-100 mb-3" type="color" id="<?= $key ?>" name="<?= $key ?>" value="<?= esc($theme[$key], 'attr') ?>" oninput="document.getElementById('<?= $key ?>_value').textContent=this.value">
                    <?php endforeach ?>
                    <button class="admin-btn admin-btn--primary w-100 mt-2" type="submit">Salvar alterações</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
