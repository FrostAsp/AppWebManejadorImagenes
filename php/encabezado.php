<!DOCTYPE html>
<html>
<head>
	<title><?php print $titulo; ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="js/funciones.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a href="index.php" class="navbar-brand">Mis imágenes</a>
	<?php 
	if($etiquetasMenu){ ?>

	<div class="collapse navbar-collapse" id="mimenu">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a href="#" class="nav-link">Etiquetas</a>
			</li>
		</ul>
		<form class="form-inline my-2 my-lg-0" action="#" method="post">
			<input type="text" name="marca" list="marca" class="form-control mr-sm-2" placeholder="Etiqueta">
			<datalist id="marca">
			</datalist>
			<button type="submit" class="btn btn-outline-info my-2 my-sm-0">Buscar</button>
		</form>
	</div>
	<?php } ?>
</nav>
<div class="container-fluid">
	<div class="row content">
		<div class="col-sm-2 sidenav mt-5"></div>
 