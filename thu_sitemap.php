<!DOCTYPE html>
<html lang="es-MX">
<head>
	<title>Sauber Productos de Limpieza</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">

	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo URL?>img/favicon.png">
	<link rel="apple-touch-icon" href="<?php echo URL?>img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL?>img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL?>img/apple-touch-icon-114x114.png">

	<link rel="stylesheet" type="text/css" href="<?php echo URL?>css/skeleton.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL?>css/layout.css">


</head>
<body>
<?php include(PREFIJO.'header.php'); ?>	

<div class="section sec-white pd-50	">
	<div class="container">
		<div class="sixteen columns">
			<div class="map maut"></div>
		</div>
	</div>
</div>
<div class="sixteen columns pd-left-5">
			<div class="navegacion">
				<ul>
					<li><a href="<?php echo URL; ?>">Inicio</a></li>
					<li class="separador">/</li>
					<li>Mapa de sitio</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
<div class="box pd-30">
 	<h3 class="col-green tx-cen">Mapa de sitio</h3>
	<p class="tx-cen">Estas son las secciones con las que cuenta este sitio web</p>

	<div class="section pd-40">
		<div class="box">
			<div class="container">			
				<div class="sixteen columns">
					<ul class="list-link-nbor tx-cen">
						<li><a href="<?php echo URL?>">Página de inicio</a></li>
						<li><a href="<?php echo URL?>sauber/">Acerca de Sauber</a></li>
						<li><a href="<?php echo URL?>contacto/">Contácto</a></li>
						<li><a href="<?php echo URL?>mapa-de-sitio/">Mapa de Sitio</a></li>
						<li><a href="<?php echo URL?>privacidad/">Aviso de privacidad</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>	
</div>
<div class="section sec-blue pd-30">
	<div class="container">
		<div class="ten columns">
			<div class="box pd-30">
				<h3 class="col-white no-mar-bo">¿Tienes dudas respecto a nuestros servicios o nuestros paquetes? contáctanos</h3>
			</div>
		</div>
		<div class="six columns">
			<div class="box pd-30">
				<a href="" class="btn abtn btn-default btn-big btn-white-out btn-center">Contáctanos</a>
			</div>
		</div>
	</div>
</div>
<?php include(PREFIJO.'footer.php'); ?>	
</body>
</html>