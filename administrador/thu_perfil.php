<?php
	if(isset($_POST['eliminar-foto']) && $_POST['eliminar-foto'] != ""){
		$portada = devolverValorQuery("SELECT avatar FROM ".DB_PREFIJO."administrador WHERE id".DB_PREFIJO."administrador=".$_SESSION[PREFIJO.'idadmin']." ");
		if($portada['avatar'] != ""){
    		unlink($portada['avatar']);
		}
		$borrarEntrada = "UPDATE ".DB_PREFIJO."administrador SET avatar = '' WHERE id".DB_PREFIJO."administrador= ".$_SESSION[PREFIJO.'idadmin']."";
		mysqli_query($conexion,$borrarEntrada) or die(mysql_error());
		$curpage = curPageURL();
		header("Location:".$curpage);
	}

	if(isset($_POST['editar']) && $_POST['usuario'] != ""){
		$anio = date('Y');
		$mes = date('m');

		$fecha = date('Y-m-d H:i:s');
		require_once('image_resize.php');
		$dir = "img/media/".$anio."/".$mes."/";
		$max_file = 3;
		$upload_dir = "../img/media/".$anio."/".$mes."/";
		$allowed_image_types = array('image/jpeg'=>"jpeg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png");
		$allowed_image_ext = array_unique($allowed_image_types); 
		$image_ext = "";


		if($_FILES['imagen']['name'] != null){

			foreach ($allowed_image_ext as $mime_type => $ext) {
				$image_ext.= strtoupper($ext)." ";
			}
			$random = strtotime(date('Y-m-d H:i:s'));
			$userfile_name = $_FILES['imagen']['name'];
			$userfile_tmp = $_FILES['imagen']['tmp_name'];
			$userfile_size = $_FILES['imagen']['size'];
			$userfile_type = $_FILES['imagen']['type'];
			
			$filename = basename($_FILES['imagen']['name']);
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));

			$original_location = $upload_dir."".$filename;


			//Solo precedemos si las imagenes son JPG, PNG, GIF y que no exedan el peso limite
			if((!empty($_FILES["imagen"]['name'])) && ($_FILES['imagen']['error'] == 0)) {
				foreach ($allowed_image_types as $mime_type => $ext) {
					//se hace un bucle atraves de los tipos de imagen especificados y se verifica si coincide con la extension despues de eso termina
					if($file_ext==$ext && $userfile_type==$mime_type){
						$error = "";
						break;
					}else{
						$error = "Solo se admiten imagenes con formato <strong>".$image_ext."</strong> <br />";
					}
				}
				//verifica que la imagen sea menor al tamaño especificado
				if ($userfile_size > ($max_file*1048576)) {
					$error.= "Las imagenes deben pesar menos de ".$max_file."MB";
				}
				
			}else{
				$error= "Seleccione una imagen para subir";
			}

			//Todo esta bien ahora si podemos subir la imagen.
			if (strlen($error)==0){			
				
				move_uploaded_file($userfile_tmp, $original_location);
				
				$image_normal = $upload_dir."imagen_".$random.".".$file_ext;
				
				$normal = new thumb();
				$normal->loadImage($original_location);
				$normal->resize(600, "width");
				$normal->save($image_normal, 90);
				
				unlink($original_location);

				$portada = devolverValorQuery("SELECT avatar FROM ".DB_PREFIJO."administrador WHERE id".DB_PREFIJO."administrador=".$_SESSION[PREFIJO.'idadmin']." ");
				if($portada['avatar'] != ""){
		    		unlink("../".$portada['avatar']);
				}
		
				$ruta_image_normal = $dir."imagen_".$random.".".$file_ext;

				$portada = "avatar ='".$ruta_image_normal."', ";

			}

			
					
		//fin condicion
		}else{
			$portada = "";
		}

		$editarPublicacion = "UPDATE ".DB_PREFIJO."administrador SET $portada nombre= '".utf8_decode($_POST['nombre'])."',apellidos= '".utf8_decode($_POST['apellidos'])."', correo='".utf8_decode($_POST['correo'])."'   WHERE id".DB_PREFIJO."administrador=".$_SESSION[PREFIJO.'idadmin']." ";
		mysqli_query($conexion,$editarPublicacion) or die(mysql_error());

		$success = "<i class='fa-icon-check-circle'></i> El perfil ha sido editado con éxito";
	}


		

	$consulta = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."administrador WHERE id".DB_PREFIJO."administrador=".$_SESSION[PREFIJO.'idadmin']." ");
?>
<!DOCTYPE HTML>
<html lang="es-MX">
<head>
	<meta charset="UTF-8">
	<title>Perfil de usuario - <?php echo PROYECTO; ?></title>
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
			<div class="ten columns">
				<div class="list-items">
					<div class="titulo">
						<h4>Perfil</h4>
						<p>Aqui puedes modificar tu información y tu foto de perfil</p>
					</div>
					<div class="form-add">
			        	<form name="form1" action="" method="post" enctype="multipart/form-data">
							<label for="usuario">Nombre de usuario</label>
							<input type="text" name="usuario" placeholder="Nombre de usuario" value="<?php if($consulta['usuario'] != ""){ echo utf8_encode($consulta['usuario']); } ?>" readonly="readonly" required>
							<label for="nombre">Nombre</label>
			        		<input type="text" name="nombre" placeholder="Nombre completo" value="<?php if($consulta['nombre'] != ""){ echo utf8_encode($consulta['nombre']); } ?>" required>
			        		<label for="apellidos">Apellidos</label>
			        		<input type="text" name="apellidos" placeholder="Nombre completo" value="<?php if($consulta['apellidos'] != ""){ echo utf8_encode($consulta['apellidos']); } ?>" required>
							<label for="nombre">Correo</label>
			        		<input type="text" name="correo" placeholder="Correo" value="<?php if($consulta['correo'] != ""){ echo utf8_encode($consulta['correo']); } ?>" required>
			        		<input type="file" name="imagen" <?php if($consulta['usuario'] != ""){ ?> <?php }else{ ?> required <?php } ?>><br>
							<?php if($consulta['usuario'] != ""){ ?> <div class="mintext">Si no selecionas una nueva foto se conserva la anterior</div> <?php }else{ ?>  <?php } ?><br>
			        		<input type="submit" name="editar" value="Guardar">
			        	</form>
			        </div>
			    </div>
			</div>
			<div class="six columns">
				<div class="list-items">
					<div class="form-add">
						<div class="foto-perfil">
						<label for="portada">Foto de perfil</label>
		        		<?php if($consulta['avatar'] != ""){ ?>
	        				<div class="foto" style="background:url(<?php echo URL.$consulta['avatar']; ?>)"></div>
	        				<div class="eliminar-foto">
		        				<form name="form2" action="" method="post">
		        					<input type="submit" class="delete" name="eliminar-foto" value="Eliminar Fotografía" class="confirm" title="¿Está seguro de borrar la fotografía?">
		        				</form>
		        			</div>
		        			
		        		<?php } ?>
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