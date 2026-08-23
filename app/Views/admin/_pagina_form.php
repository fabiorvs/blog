<div class="admin-page-header"><div><h1><?= $editing ? 'Editar página' : 'Nova página' ?></h1><p>Crie conteúdos institucionais que aparecem no menu do blog.</p></div></div>
<form class="admin-card admin-form-card" action="<?= $action ?>" method="post"><div class="admin-card__body"><?= csrf_field() ?>
    <div class="row g-3 mb-4">
        <div class="col-md-4"><label class="form-label" for="nome">Nome do link</label><input class="form-control" id="nome" name="nome" maxlength="150" value="<?= esc(old('nome', $pagina['nome'] ?? ''), 'attr') ?>" required><div class="form-text">Texto curto exibido no menu do blog.</div></div>
        <div class="col-md-5"><label class="form-label" for="titulo">Título da página</label><input class="form-control" id="titulo" name="titulo" maxlength="200" value="<?= esc(old('titulo', $pagina['titulo'] ?? $pagina['nome'] ?? ''), 'attr') ?>" required><div class="form-text">Título principal exibido ao abrir a página.</div></div>
        <div class="col-md-3"><label class="form-label" for="situacao">Situação</label><select class="form-select" id="situacao" name="situacao" required><?php foreach (\App\Services\ContentStatus::options() as $value => $label) : ?><option value="<?= esc($value, 'attr') ?>" <?= old('situacao', $pagina['situacao'] ?? \App\Services\ContentStatus::DRAFT) === $value ? 'selected' : '' ?>><?= esc($label) ?></option><?php endforeach ?></select><div class="form-text">Em aprovação abre somente pela URL.</div></div>
    </div>
    <div><label class="form-label" for="conteudo">Conteúdo</label><textarea class="form-control" id="conteudo" name="conteudo" rows="16"><?= esc(old('conteudo', $pagina['conteudo'] ?? '')) ?></textarea></div>
    <?php if ($editing) : ?><input type="hidden" name="slug" value="<?= esc($pagina['slug'], 'attr') ?>"><?php endif ?>
    <div class="admin-form-actions"><a class="admin-btn admin-btn--secondary" href="<?= base_url('admin/pagina') ?>">Cancelar</a><button class="admin-btn admin-btn--primary" type="submit">Salvar página</button></div>
</div></form>
