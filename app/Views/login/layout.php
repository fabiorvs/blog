<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Blog Home - Start Bootstrap Template</title>
	<!-- Favicon-->
	<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
	<!-- Core theme CSS (includes Bootstrap)-->
	<link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet" />
	<?= $this->renderSection('css') ?>
</head>

<body>
	<!-- Responsive navbar-->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="<?= base_url() ?>"><?= getenv('NAME') ?></a>

		</div>
	</nav>
	<!-- Page header with logo and tagline-->
	<header class="py-5 bg-light border-bottom mb-4 masthead">
		<div class="container">
			<div class="text-center my-5">

			</div>
		</div>
	</header>
	<!-- Page content-->
	<div class="container">
		<div class="row">
			<!-- Blog entries-->
			<div class="col-lg-12">
				<?= $this->renderSection('conteudo') ?>
			</div>
		</div>
	</div>
	<!-- Footer-->
	<footer class="py-5 bg-dark mt-4">
		<div class="container">
			<p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p>
		</div>
	</footer>
	<!-- Bootstrap core JS-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- Core theme JS-->
	<script src="<?= base_url('assets/ckeditor5/ckeditor.js'); ?>"></script>
	<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
	<?= $this->renderSection('js') ?>
</body>

</html>