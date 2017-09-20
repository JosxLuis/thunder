<?php include('lib/config.php'); ?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
	<title>Sitio no encontrado</title>
	<meta charset="UTF-8">
	<meta name="description" content="Ocurrió un error y no hemos encontrado el sitio al que intentas acceder.">
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
	<div class="section sec-blue absolute w1 h1">
		<div class="error-404-img"></div>
		<div class="error-404-mensaje">
				<h4 class="col-white">No hemos encontrado la dirección que solicistaste</h4><br>
				<a href="<?php echo URL; ?>" class="btn btn-big btn-white-out maut" >Regresar</a>
		</div>
	</div>
</body>
</html>