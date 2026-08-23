<form class="admin-card admin-form-card" action="<?= $action ?>" method="post">
    <?= csrf_field() ?>
    <div class="card-body p-4">
        <div class="mb-4"><label class="form-label" for="nome">Nome</label><input class="form-control" id="nome" name="nome" maxlength="200" value="<?= esc(old('nome', $usuario['nome'] ?? ''), 'attr') ?>" autocomplete="name" required></div>
        <div class="mb-4"><label class="form-label" for="email">E-mail de acesso</label><input class="form-control" type="email" id="email" name="email" maxlength="200" value="<?= esc(old('email', $usuario['email'] ?? ''), 'attr') ?>" autocomplete="email" required><div class="form-text">Todos os usuários cadastrados possuem acesso administrativo.</div></div>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="senha"><?= $editing ? 'Nova senha' : 'Senha' ?></label><input class="form-control" type="password" id="senha" name="senha" minlength="8" autocomplete="new-password" <?= $editing ? '' : 'required' ?>><div class="form-text"><?= $editing ? 'Deixe em branco para manter a senha atual.' : 'Use pelo menos 8 caracteres.' ?></div></div>
            <div class="col-md-6"><label class="form-label" for="confirmacao_senha">Confirmar senha</label><input class="form-control" type="password" id="confirmacao_senha" name="confirmacao_senha" minlength="8" autocomplete="new-password" <?= $editing ? '' : 'required' ?>></div>
        </div>
        <div class="admin-form-actions"><a class="admin-btn admin-btn--secondary" href="<?= base_url('admin/usuario') ?>">Cancelar</a><button class="admin-btn admin-btn--primary" type="submit">Salvar usuário</button></div>
    </div>
</form>
