<!DOCTYPE html>
<html lang="es-MX">
<head>
	<title>Sauber Productos de Limpieza</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo URL; ?>img/favicon.png">
	<link rel="apple-touch-icon" href="<?php echo URL; ?>img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL; ?>img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL; ?>img/apple-touch-icon-114x114.png">

	<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>css/skeleton.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>css/layout.css">

</head>
<body>
<?php include(PREFIJO.'header.php'); ?>

<div class="section pd-50">
	<div class="container">
		<div class="sixteen columns">
			<h3 class="col-green">Versiones</h3>
			<p>Historial de versiones y actualizaciones de la plataforma web de <?php echo PROYECTO; ?></p>
			<div class="box">
				<ul class="list-ver">
					<li>
						<h5>Version 1.0.3</h5>
						<small> 25/08/17</small>
						<p>Se agrega la sección de versiones y error 404, se mejora la visualización del sitio en tabletas y móviles.</p>
						<ul>
							<li>Se agregan elementos nuevos en el css</li>
							<li>Optimización en el peso de las imágenes del sitio</li>
							<li>Ranking de 100% en pingdom.</li>
							<li>Ranking de 100% en GTMetrix.</li>
							<li>Ranking de 97% en versión pc y 85% en versión móvil en Pagespeed Insights.</li>
						</ul>
					</li>
					<li>
						<h5>Version 1.0.2</h5>
						<small> 23/08/17</small>
						<p>Se cambia el slider por un slider sin uso de javascript, se mejora el menú movil.</p>
						<ul>
							<li>Cambio de imágenes por iconos vectorizados.</li>
							<li>Imagen en privacidad y mapa de sitio.</li>
							<li>Corrección de errores de vizualización en dispositivos móviles.</li>
							<li>Segunda prueba de velocidad de carga con pingdoom, gtmetrix y pagespeed insight.</li>
						</ul>
					</li>
					<li>
						<h5>Version 1.0.1</h5>
						<small> 22/08/17</small>
						<p>Se agregan dos apartados, aviso de privacidad y mapa de sitio.</p>
						<ul>
							<li>Se corrigen errores de diseño.</li>
							<li>Se agrega el tiempo de expiración de la caché de los archivos.</li>
							<li>Primer testeo de velocidad de carga del sitio con un rendimiento del 85%.</li>
						</ul>
					</li>
					<li>
						<h5>Version 1.0</h5>
						<small> 21/08/17</small>
						<p>Se libera la primera versión del sitio con las secciones principales, página de inicio, acerca de sauber y contacto.</p>
					</li>
				</ul>
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

<?php include(PREFIJO."footer.php"); ?>
</body>
</html>