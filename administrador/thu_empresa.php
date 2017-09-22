<?php
if(isset($_GET['act']) && $_GET['act'] == "eliminar"){
	$logotipo = devolverValorQuery("SELECT logotipo FROM ".DB_PREFIJO."empresa WHERE id".DB_PREFIJO."empresa=".$_GET['id']." ");
	if($logotipo['logotipo'] != ""){
		unlink("../".$logotipo['logotipo']);
	}
	
    $borrarEntrada = "DELETE  FROM ".DB_PREFIJO."empresa WHERE id".DB_PREFIJO."empresa= ".$_GET['id']."";
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
        if($_POST['codigo'] != null){
            $busqueda .= " AND clave LIKE '%".$_POST['codigo']."%' ";
        }
        if($_POST['nombre'] != null){
            $busqueda .= " AND nombre LIKE '%".$_POST['nombre']."%' ";
        }

        $cantidad = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."empresa WHERE 1 ".$busqueda."");
        
        if($cantidad != 0){
            $cat=new pagination($cantidad,25,$current_page,5 /*number of button*/);
            mysqli_query($conexion,"SET lc_time_names = 'es_MX'" );
            $registro = "SELECT *,date_format(creado, '%d-%m-%Y') as creado FROM ".DB_PREFIJO."empresa WHERE 1 ".$busqueda." ORDER BY id".DB_PREFIJO."empresa
             LIMIT $cat->Start , $cat->End";
            $resultado = mysqli_query($conexion,$registro);
        }

    }else{
        

        $cantidad = cantidadRegistros("SELECT * FROM ".DB_PREFIJO."empresa WHERE 1");
        
        if($cantidad != 0){
	        $cat=new pagination($cantidad,25,$current_page,5 /*number of button*/);
	        mysqli_query($conexion,"SET lc_time_names = 'es_MX'" );
	        $registro = "SELECT *,date_format(creado, '%d-%m-%Y') as creado FROM ".DB_PREFIJO."empresa  ORDER BY id".DB_PREFIJO."empresa DESC LIMIT $cat->Start , $cat->End";
	        $resultado = mysqli_query($conexion,$registro);
	    }

    }

?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Empresa - <?php echo PROYECTO; ?></title>
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
						<h4>Empresa</h4>
						<p>Lista de las empresas</p>
					</div>
					
					<?php if($_SESSION[PREFIJO.'tipo'] == 1){ ?>
					<div class="add-button"><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/nuevo"> Nuevo</a></div>
					<?php } ?>
	        	<table class="mixta">
	        		<thead>
	        			<tr>
	        			
	        				<td width="8%">logotipo</td>
	        				<td width="10%">Razon social</td>
	        				<td width="10%">RFC</td>
	        				<td width="15%">Correo</td>
	        				<?php if($_SESSION[PREFIJO.'tipo'] == 1){ ?>
	        				<td width="10%">&nbsp;</td>
	        				<?php } ?>
	        			</tr>
	        		</thead>
	        		<tbody>
	        			<?php if($cantidad != 0){ ?>
	        				<?php 
	        					while($rowEmpresa = mysqli_fetch_array($resultado)){
	        						//$tipo = devolverValorQuery("SELECT tipo FROM ".DB_PREFIJO."equipos_tipo WHERE id".DB_PREFIJO."equipos_tipo =".$rowEmpresa['id'.DB_PREFIJO.'equipos_tipo']" ");
	        				?>
			        			<tr>
			        				<td><div class="foto" <?php if($rowEmpresa['logotipo'] != "" ){ ?> style="background:url(<?php echo URL.$rowEmpresa['logotipo']; ?>)" <?php } ?>> <?php if($rowEmpresa['logotipo'] == "" ){ ?><i class="fa-icon-barcode"><?php } ?></div></td>
			        				<td><?php echo utf8_encode($rowEmpresa['razon_social']); ?></td>
			        				<td><?php echo utf8_encode($rowEmpresa['rfc']); ?></td>
									<td><?php echo utf8_encode($rowEmpresa['correo']); ?></td>
			        				<td><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/editar/<?php echo $rowEmpresa['id'.DB_PREFIJO.'empresa']; ?>/">Editar</a></td>
			        				<td><a href="<?php echo ADMINURL; ?>content/<?php echo $_GET['do']; ?>/eliminar/<?php echo $rowEmpresa['id'.DB_PREFIJO.'empresa']; ?>/" class="confirm" title="¿Está seguro de borrar este registro?" >Eliminar</a></td>
			        			</tr>
		        			<?php } ?>
	        			<?php }else{ ?>
	        				<tr>
	        					<td colspan="7" class="center">No se encontraron resultados</td>
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