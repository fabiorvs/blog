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
	<link rel="stylesheet" href="<?= base_url('assets/high/styles/codepen-embed.min.css') ?>">
	<?= $this->renderSection('estilos') ?>	
</head>

<body>
	<!-- Responsive navbar-->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="<?= base_url() ?>"">Start Bootstrap</a>
			<button class=" navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
						<?php menu_paginas() ?>
					</ul>
				</div>
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
			<div class="col-lg-8">
				<?= $this->renderSection('conteudo') ?>
			</div>
			<!-- Side widgets-->
			<div class="col-lg-4">
				<!-- Search widget-->
				<div class="card mb-4">
					<div class="card-header">Pesquisar</div>
					<div class="card-body">
						<?= form_open('pesquisar'); ?>
						<div class="input-group">
							<input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" name="pesquisa" id="pesquisa" />
							<button class="btn btn-primary" id="button-search" type="submit">Go!</button>
						</div>
						<?= form_close() ?>
					</div>
				</div>
				<!-- Categories widget-->
				<div class="card mb-4">
					<div class="card-header">Categorias</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								<ul class="list-unstyled mb-0">
									<?= menu_categorias() ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- Side widget-->
				<div class="card mb-4">
					<div class="card-header">Side Widget</div>
					<div class="card-body">You can put anything you want inside of these side widgets. They are easy to
						use, and feature the Bootstrap 5 card component!</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer-->
	<footer class="py-5 bg-dark">
		<div class="container">
			<p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p>
		</div>
	</footer>
	<!-- Bootstrap core JS-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Core theme JS-->
	<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
	<script src="<?= base_url('assets/high/highlight.min.js') ?>"></script>
	<script>
		hljs.highlightAll();
	</script>
	<?= $this->renderSection('scripts') ?>
</body>

</html>