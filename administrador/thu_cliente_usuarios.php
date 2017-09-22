<?php
	if(isset($_GET['act']) && $_GET['act'] == "eliminar"){
	$archivo = devolverValorQuery("SELECT avatar FROM ".DB_PREFIJO."usuario WHERE id".DB_PREFIJO."usuario=".$_GET['id']." ");
	
	    $borrarEntrada = "DELETE  FROM ".DB_PREFIJO."usuario WHERE id".DB_PREFIJO."usuario= ".$_GET['id']."";
	    mysqli_query($conexion,$borrarEntrada) or die(mysql_error());
	    if($archivo['avatar'] != ""){
	    	unlink("../".$archivo['avatar']);
		}
		header("Location:".ADMINURL."content/".$_GET['do']);
}


    //param of url to specify page_number
    $get_param='page';
    
    //get current page from url
    $current_page=(isset($_GET[$get_param]) && is_numeric($_GET[$get_param]))?$_GET[$get_param]:1;
    //notice: when get param , you should SAFE it

    $url = ADMINURL."content/".$_GET['do']."/";


    if(isset($_GET['nombre'])){
        
        $busqueda = "";
        /*if($_GET['correo'] != null){
            $busqueda .= " AND emailusuarioEP = '".$_GET['correo']."' ";
        }*/
        if($_GET['nombre'] != null){
            $busqueda .= " AND nombre LIKE '%".$_GET['nombre']."%' ";
        }

        $cantidad = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."usuario WHERE 1 ".$busqueda."");
        
        if($cantidad != 0){
            $cat=new pagination($cantidad,25,$current_page,5 /*number of button*/);

            $registro = "SELECT * FROM ".DB_PREFIJO."usuario WHERE 1 ".$busqueda." ORDER BY id".DB_PREFIJO."usuario
             LIMIT $cat->Start , $cat->End";
            $resultado = mysqli_query($conexion,$registro);
        }

    }else{
        

        $cantidad = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."usuario WHERE 1");
        
        $cat=new pagination($cantidad,15,$current_page,5 /*number of button*/);

        $registro = "SELECT * FROM ".DB_PREFIJO."usuario WHERE 1 ORDER BY id".DB_PREFIJO."usuario DESC LIMIT $cat->Start , $cat->End";
        $resultado = mysqli_query($conexion,$registro);
    }

?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Usuarios - <?php echo PROYECTO; ?></title>
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
				<?php if (isset($_GET['error']) && $_GET['error'] != null) { ?>
					<div class="alert alert-warning"><i class="fa-icon-warning"></i> No se puede eliminar a un usuario Super Administrador</div>
				<?php } ?>
				<div class="list-items">
					<div class="titulo">
						<h4>Usuarios</h4>
						<p>Listado usuarios</p>
					</div>
					<div class="add-button"><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/nuevo"> Nuevo</a></div>
	        	<table class="mixta">
	        		<thead>
	        			<tr>
	        				<td width="10%">Avatar</td>
	        				<td width="30%">Correo</td>
	        				<td width="20%">Nombre</td>
	        				<td width="20%">Apellidos</td>
	        				<td width="10%">&nbsp;</td>
	        				<td width="10%">&nbsp;</td>
	        			</tr>
	        		</thead>
	        		<tbody>
	        			<?php if($cantidad != 0){ ?>
	        				<?php 
	        					while($rowUsuarios = mysqli_fetch_array($resultado)){
	        				?>
			        			<tr>
			        				<td><div class="foto" <?php if($rowUsuarios['avatar'] != "" ){ ?> style="background:url(<?php echo URL.$rowUsuarios['avatar']; ?>)" <?php } ?>> <?php if($rowUsuarios['avatar'] == "" ){ ?><i class="fa-icon-image"><?php } ?></div></td>
			        				<td><?php echo utf8_encode($rowUsuarios['correo']); ?></td>
			        				<td><?php echo utf8_encode($rowUsuarios['nombre']); ?></td>
			        				<td><?php echo utf8_encode($rowUsuarios['apellidos']); ?></td>
			        				<td><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/editar/<?php echo $rowUsuarios['id'.DB_PREFIJO.'usuario']; ?>/">Editar</a></td>
			        				<td><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/eliminar/<?php echo $rowUsuarios['id'.DB_PREFIJO.'usuario']; ?>/" class="confirm" title="¿Está seguro de borrar este registro?" >Eliminar</a></td>
			        			</tr>
		        			<?php } ?>
	        			<?php }else{ ?>
	        				<tr>
	        					<td colspan="8" class="center">No se encontraron resultados</td>
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