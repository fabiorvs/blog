<?= $this->extend('login/layout') ?>

<?= $this->section('conteudo') ?>
<style>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

<section>
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg" class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form action="<?= base_url('admin/login/logar') ?>" method="post">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="form1Example13" name="email" class="form-control form-control-lg" required />
                        <label class="form-label" for="form1Example13">Email</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="form1Example23" name="senha" class="form-control form-control-lg" required />
                        <label class="form-label" for="form1Example23">Senha</label>
                    </div>

                    <div class="d-flex justify-content-around align-items-center mb-4">

                        <a href="#!">Forgot password?</a>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Acessar</button>

                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>