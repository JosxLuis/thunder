<?php	
	$cotizacion = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."cotizacion WHERE id".DB_PREFIJO."cotizacion=".$_GET['id']." ");

	$productos = "SELECT * FROM ".DB_PREFIJO."cotizacion_has_producto WHERE id".DB_PREFIJO."cotizacion=".$_GET['id']." ";
	$resProductos = mysqli_query($conexion,$productos);

?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Detalle Cotización - <?php echo PROYECTO; ?></title>
	<!-- Metas  Especificas para  mobiles -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/base.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/layout.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/fonts/custom/style.css">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo ADMINURL; ?>img/favicon.png">
	<link rel="apple-touch-icon" href="<?php echo ADMINURL; ?>img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo ADMINURL; ?>img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo ADMINURL; ?>img/apple-touch-icon-114x114.png">
</head>
<body>
	<div class="dashboard">
		<?php require_once(PREFIJO.'menu.php'); ?>
		<div class="container">
			<div class="sixteen columns">
			<?php if (isset($error) && $error != null) { ?>
				<div class="alert alert-danger"><i class="fa-icon-warning"></i> <?php echo $error; ?></div>
			<?php } ?>
			<?php if (isset($success)){ ?>
				<div class="alert alert-success"><?php echo $success; ?></div>
			<?php } ?>
			</div>
			<div class="seven columns">
				<div class="list-items">
					<div class="titulo">
						<h4>Cotización</h4>
						<p>Detalle de la solicitud de cotización con folio c<?php echo $cotizacion['folio']; ?></p>
					</div>
					<div class="form-add">
			        	<form name="form1" action="" method="post" enctype="multipart/form-data">
							<label for="nombre">Nombre</label>
			        		<input type="text" name="nombre" placeholder="Nombre completo" value="<?php if($cotizacion['nombre'] != ""){ echo utf8_encode($cotizacion['nombre']); } ?>" readonly="readonly" required>
							<label for="nombre">Correo</label>
			        		<input type="text" name="correo" placeholder="Correo" value="<?php if($cotizacion['correo'] != ""){ echo utf8_encode($cotizacion['correo']); } ?>" readonly="readonly" required>
			        		<label for="telefono">Teléfono</label>
			        		<input type="text" name="telefono" placeholder="Teléfono" value="<?php if($cotizacion['telefono'] != ""){ echo utf8_encode($cotizacion['telefono']); } ?>" readonly="readonly" required>
			        		<label for="estado">Estado</label>
			        		<input type="text" name="estado" placeholder="Estado" value="<?php if($cotizacion['id'.DB_PREFIJO.'estado'] != ""){ echo mostrarNombreEstado(utf8_encode($cotizacion['id'.DB_PREFIJO.'estado'])); } ?>" readonly="readonly" required>
			        		<label for="comentario">Comentarios</label>
			        		<textarea readonly="readonly" ><?php if($cotizacion['comentario'] != ""){ echo utf8_encode($cotizacion['comentario']); } ?></textarea>
			        	</form>
			        </div>
			    </div>
			</div>
			<div class="nine columns">
				<div class="list-items">
					<div class="form-add">
						<div class="foto-perfil">
							<label for="portada">Productos</label>
		        		</div>
		        		<div class="carrito">
		        		<table>
		        			<thead>
		        				<tr>
		        					<td width="10%">Foto</td>
		        					<td width="15%">Código</td>
		        					<td width="60%">Producto</td>
		        					<td width="15%" align="center">Cant</td>
		        				</tr>
		        			</thead>
		        			<?php while($rowProducto = mysqli_fetch_array($resProductos)){ 
		        				$producto = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."producto WHERE id".DB_PREFIJO."producto=".$rowProducto['id'.DB_PREFIJO.'producto']."");
		        			?>
		        			<tr>
             					<td><div class="foto" style="background:url(<?php echo URL.$producto['portada']; ?>);"></div></td>
             					<td><?php echo utf8_encode($producto['clave']); ?></td>
             					<td><?php echo utf8_encode($producto['nombre']); ?></td>
             					<td align="center"><?php echo utf8_encode($rowProducto['cantidad']); ?></td>
             				</tr>
		        			<?php } ?>
		        		</table>
		        		<br>
		        		<a href="<?php echo ADMINURL; ?>content/cotizaciones/pdf/<?php echo $_GET['id']; ?>/" class="pdf-button" target="_blank"><i class="fa-icon-print"></i> Imprimir PDF</a>
		        		
		        		</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once(PREFIJO.'footer.php'); ?>
	</div>
	
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/default.js"></script>
	<script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.ui.js"></script>
    <script type="text/javascript" src="<?php echo ADMINURL; ?>js/jquery.confirm.js"></script>
    <script>
    	$(document).ready(function(){
    		$(".confirm").easyconfirm({locale: { title: 'Borrar publicacion', button: ['No','Sí']}});
    	});
    </script>

</body>
</html>