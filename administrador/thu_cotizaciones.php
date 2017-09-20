<?php
if(isset($_GET['act']) && $_GET['act'] == "eliminar"){
    $borrarEntrada = "DELETE  FROM ".DB_PREFIJO."cotizacion WHERE id".DB_PREFIJO."cotizacion= ".$_GET['id']."";
    mysqli_query($conexion,$borrarEntrada);
    header("Location:".ADMINURL."content/".$_GET['do']);
}

    //param of url to specify page_number
    $get_param='page';
    
    //get current page from url
    $current_page=(isset($_GET[$get_param]) && is_numeric($_GET[$get_param]))?$_GET[$get_param]:1;
    //notice: when get param , you should SAFE it

    $url = ADMINURL."content/".$_GET['do']."/";


    if(isset($_POST['buscar'])){
        
        $busqueda = "";
        if($_POST['correo'] != null){
            $busqueda .= " AND correo = '".$_POST['correo']."' ";
        }
        if($_POST['nombre'] != null){
            $busqueda .= " AND nombre LIKE '%".$_POST['nombre']."%' ";
        }
         if($_POST['folio'] != null){
            $busqueda .= " AND folio LIKE '%".$_POST['folio']."%' ";
        }

        $cantidad = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."cotizacion WHERE 1 ".$busqueda."");
        
        if($cantidad != 0){
            $cat=new pagination($cantidad,25,$current_page,5 /*number of button*/);
            mysqli_query($conexion,"SET lc_time_names = 'es_MX'" );
            $registro = "SELECT *,date_format(creado, '%d-%m-%Y') as creado FROM ".DB_PREFIJO."cotizacion WHERE 1 ".$busqueda." ORDER BY id".DB_PREFIJO."cotizacion
             LIMIT $cat->Start , $cat->End";
            $resultado = mysqli_query($conexion,$registro);
        }

    }else{
        

        $cantidad = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."cotizacion WHERE 1");
        
        $cat=new pagination($cantidad,25,$current_page,5 /*number of button*/);
        mysqli_query($conexion,"SET lc_time_names = 'es_MX'" );
        $registro = "SELECT *,date_format(creado, '%d-%m-%Y') as creado FROM ".DB_PREFIJO."cotizacion  ORDER BY id".DB_PREFIJO."cotizacion DESC LIMIT $cat->Start , $cat->End";
        $resultado = mysqli_query($conexion,$registro);

    }

?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Cotizaciones - <?php echo PROYECTO; ?></title>
	<!-- Metas  Especificas para  mobiles -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/base.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/layout.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/fonts/custom/style.css">
	<link rel="stylesheet" href="<?php echo ADMINURL; ?>css/themes/blitzer/jquery.ui.css">

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
				<div class="list-items">
					<div class="titulo">
						<h4>Cotizaciones</h4>
						<p>Lista de las cotizaciones realizadas por los usuarios</p>
					</div>
					<div class="left-side-button">
						<form name="busqueda" method="post">
							<input type="text" name="folio" class="w1" placeholder="Folio">
							<input type="text" name="nombre" class="w2" placeholder="Nombre">
							<input type="text" name="correo" class="w2" placeholder="Correo">
							<input type="submit" name="buscar" value="Buscar">
						</form>
					</div>
					<div class="add-button"><!--<a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/nuevo"> Nuevo</a>--></div>
	        	<table class="mixta">
	        		<thead>
	        			<tr>
	        				<td width="5%">ID</td>
	        				<td width="5%">Folio</td>
	        				<td width="25%">Nombre</td>
	        				<td width="10%">Correo</td>
	        				<td width="10%">Teléfono</td>
	        				<td width="10%">Creado</td>
	        				<td width="10%">Productos</td>
	        				<td width="5%">&nbsp;</td>
	        				<?php if($_SESSION[PREFIJO.'idadmin'] == 1){ ?>
	        				<td width="10%">&nbsp;</td>
	        				<?php } ?>
	        			</tr>
	        		</thead>
	        		<tbody>
	        			<?php if($cantidad != 0){ ?>
	        				<?php 
	        					while($rowCotizacion = mysqli_fetch_array($resultado)){
	        						$productos = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."cotizacion_has_producto WHERE id".DB_PREFIJO."cotizacion =".$rowCotizacion['id'.DB_PREFIJO.'cotizacion']." ");
	        				?>
			        			<tr>
			        				<td>#<?php echo $rowCotizacion['id'.DB_PREFIJO.'cotizacion']; ?></td>
			        				<td><?php echo "C".utf8_encode($rowCotizacion['folio']); ?></td>
			        				<td><?php echo utf8_encode($rowCotizacion['nombre']); ?></td>
			        				<td><?php echo utf8_encode($rowCotizacion['correo']); ?></td>
			        				<td><?php echo utf8_encode($rowCotizacion['telefono']); ?></td>
			        				<td><?php echo utf8_encode($rowCotizacion['creado']); ?></td>
			        				<td><?php echo $productos ?> producto(s)</td>
			        				<td><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/detalle/<?php echo $rowCotizacion['id'.DB_PREFIJO.'cotizacion']; ?>/">Ver</a></td>
									<?php if($_SESSION[PREFIJO.'tipo'] == 1){ ?>
			        				<td><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/eliminar/<?php echo $rowCotizacion['id'.DB_PREFIJO.'cotizacion']; ?>/" class="confirm" title="¿Está seguro de borrar este registro?" >Eliminar</a></td>
			        				<?php } ?>
			        			</tr>
		        			<?php } ?>
	        			<?php }else{ ?>
	        				<tr>
	        					<td colspan="9" class="center">No se encontraron resultados</td>
	        				</tr>
	        			<?php } ?>
	        		</tbody>
	        	</table>

	        	<?php if($cantidad != 0){ ?>
				<div class="pagination"><?php $cat->Show_Pagination($url,'page','paginacion'); ?></div>
				<?php } ?>
			</div>
		</div>
		<div class="clear"></div>
		
	</div>
	<?php require_once(PREFIJO.'footer.php'); ?>
	
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