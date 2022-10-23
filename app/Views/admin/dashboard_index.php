<?= $this->extend('admin/layout') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    body {
        background: #eee;
    }

    span {
        font-size: 15px;
    }

    .box {
        padding: 60px 0px;
    }

    .box-part {
        background: #FFF;
        border-radius: 0;
        padding: 60px 10px;
        margin: 30px 0px;
    }

    .text {
        margin: 20px 0px;
    }

    .fa {
        color: #4183D7;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<div class="box">
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="box-part text-center">
                    <i class="fa fa-file-code-o fa-3x" aria-hidden="true"></i>
                    <div class="title">
                        <h4>Páginas</h4>
                    </div>
                    <a href="<?= base_url('admin/pagina') ?>">Acessar</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="box-part text-center">
                    <i class="fa fa-th-list fa-3x" aria-hidden="true"></i>
                    <div class="title">
                        <h4>Categorias</h4>
                    </div>
                    <a href="<?= base_url('admin/categoria') ?>">Acessar</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="box-part text-center">
                    <i class="fa fa-newspaper-o fa-3x" aria-hidden="true"></i>
                    <div class="title">
                        <h4>Postagens</h4>
                    </div>
                    <a href="<?= base_url('admin/postagem') ?>">Acessar</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="box-part text-center">
                    <i class="fa fa-users fa-3x" aria-hidden="true"></i>
                    <div class="title">
                        <h4>Usuários</h4>
                    </div>
                    <a href="#">Acessar</a>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>