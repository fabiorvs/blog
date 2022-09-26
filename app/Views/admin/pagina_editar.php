<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>

<div class="row">

    <form action="<?= base_url('admin/pagina/salvar/' . $pagina['id']) ?>" method="post" enctype="multipart/form-data">
        <h2 class="text-center">
            Editar Página
        </h2>

        <div class="form-group">
            <label>Nome</label>
            <input type="text" class="form-control" name="nome" id="nome" value="<?= $pagina['nome'] ?>" required>
        </div>
        <div class="form-group mt-2 pb-4">
            <label>Texto</label>
            <textarea class="form-control" style="width: 100%; height: 400px;" id="conteudo" name="conteudo"><?= $pagina['conteudo'] ?></textarea>
            <input type="hidden" name="slug" value="<?= $pagina['slug'] ?>">
        </div>

        <div class="col-2 mt-2 pb-4 ">
            <button class="btn btn-primary btn-block" type="submit">Salvar</button>
            <a href="<?= base_url('admin/pagina') ?>" class="btn btn-danger btn-block">Cancelar</a>
        </div>
    </form>

</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>

<script type="text/javascript">
    // CKEDITOR.replace('conteudo', {
    //     height: 400,
    //     width: '100%',
    //     expand: true,
    //     filebrowserUploadUrl: "<?= base_url('assets/ckeditor/upload.php') ?>"
    // });

    ClassicEditor.create(document.querySelector('#conteudo'), {
            mediaEmbed: {
                previewsInData: true
            }
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: e10r8tjxmfle-8k5z603wm8ij');
            console.error(error);
        });
</script>

<?= $this->endSection() ?>